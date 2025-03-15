<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Dompdf\Options;

class TimesheetExportController extends Controller
{
    /**
     * Show the export form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::whereHas('timesheets')->orderBy('first_name')->get();
        return view('admin.timesheets.export', compact('users'));
    }

    /**
     * Export timesheets based on filter criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        // Validate request
        $request->validate([
            'format' => 'required|in:csv,pdf',
            'columns' => 'required|array',
            'columns.*' => 'string',
        ]);

        // Get filter parameters
        $userId = $request->input('user_id');
        $status = $request->input('status');
        $dateRange = $request->input('date_range');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $format = $request->input('format');
        $columns = $request->input('columns');

        // Build query
        $query = Timesheet::with('user');

        // Apply filters
        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        // Apply date range filter
        switch ($dateRange) {
            case 'this_week':
                $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'last_week':
                $query->whereBetween('date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            case 'last_month':
                $query->whereBetween('date', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]);
                break;
            case 'custom':
                if ($dateFrom && $dateTo) {
                    $query->whereBetween('date', [$dateFrom, $dateTo]);
                }
                break;
        }

        // Get data
        $timesheets = $query->orderBy('date', 'desc')->get();

        // Check if there are any results
        if ($timesheets->isEmpty()) {
            return redirect()->back()->with('error', 'No timesheets found matching your criteria.');
        }

        // Generate filename
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $filename = "timesheets_export_{$timestamp}";

        // Export based on format
        if ($format === 'csv') {
            return $this->exportToCsv($timesheets, $columns, $filename);
        } else {
            return $this->exportToPdf($timesheets, $columns, $filename);
        }
    }

    /**
     * Export data to CSV.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $timesheets
     * @param  array  $columns
     * @param  string  $filename
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    private function exportToCsv($timesheets, $columns, $filename)
    {
        // Set up headers
        $headers = $this->getColumnHeaders($columns);
        
        // Create CSV content
        $callback = function() use ($timesheets, $columns, $headers) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, $headers);
            
            // Add data
            foreach ($timesheets as $timesheet) {
                $row = [];
                foreach ($columns as $column) {
                    $row[] = $this->getColumnValue($timesheet, $column);
                }
                fputcsv($file, $row);
            }
            
            fclose($file);
        };
        
        // Create response
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
        ];
        
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export data to PDF.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $timesheets
     * @param  array  $columns
     * @param  string  $filename
     * @return \Illuminate\Http\Response
     */
    private function exportToPdf($timesheets, $columns, $filename)
    {
        // Set up headers
        $headers = $this->getColumnHeaders($columns);
        
        // Prepare data for PDF
        $data = [];
        foreach ($timesheets as $timesheet) {
            $row = [];
            foreach ($columns as $column) {
                $row[$column] = $this->getColumnValue($timesheet, $column);
            }
            $data[] = $row;
        }
        
        // Generate PDF view
        $pdf = View::make('admin.timesheets.pdf-export', [
            'timesheets' => $data,
            'headers' => $headers,
            'columns' => $columns,
            'filename' => $filename,
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        // Create PDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdf);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        // Save PDF to file
        $path = storage_path('app/public/exports/' . $filename . '.pdf');
        
        // Ensure directory exists
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        
        file_put_contents($path, $dompdf->output());
        
        // Return PDF file for download
        return response()->download($path)->deleteFileAfterSend(true);
    }

    /**
     * Get column headers based on selected columns.
     *
     * @param  array  $columns
     * @return array
     */
    private function getColumnHeaders($columns)
    {
        $headers = [];
        $columnMap = [
            'id' => 'ID',
            'employee' => 'Employee Name',
            'date' => 'Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'hours_worked' => 'Hours Worked',
            'break_duration' => 'Break Duration (hrs)',
            'status' => 'Status',
            'tasks' => 'Tasks Completed',
            'notes' => 'Notes',
        ];

        foreach ($columns as $column) {
            if (isset($columnMap[$column])) {
                $headers[] = $columnMap[$column];
            }
        }

        return $headers;
    }

    /**
     * Get column value for a timesheet.
     *
     * @param  \App\Models\Timesheet  $timesheet
     * @param  string  $column
     * @return string
     */
    private function getColumnValue($timesheet, $column)
    {
        switch ($column) {
            case 'id':
                return $timesheet->id;
            case 'employee':
                return $timesheet->user->first_name . ' ' . $timesheet->user->last_name;
            case 'date':
                return $timesheet->date->format('Y-m-d');
            case 'start_time':
                return $timesheet->start_time->format('H:i');
            case 'end_time':
                return $timesheet->end_time->format('H:i');
            case 'hours_worked':
                return $timesheet->hours_worked;
            case 'break_duration':
                return $timesheet->break_duration;
            case 'status':
                return ucfirst($timesheet->status);
            case 'tasks':
                return $timesheet->tasks_completed;
            case 'notes':
                return $timesheet->notes;
            default:
                return '';
        }
    }
}
