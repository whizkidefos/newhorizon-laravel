<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Dompdf\Options;

class ComplaintExportController extends Controller
{
    /**
     * Show the export form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::whereHas('complaints')->orderBy('first_name')->get();
        return view('admin.complaints.export', compact('users'));
    }

    /**
     * Export complaints based on filter criteria.
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
        $severity = $request->input('severity');
        $dateRange = $request->input('date_range');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $format = $request->input('format');
        $columns = $request->input('columns');

        // Build query
        $query = Complaint::with(['user', 'resolver', 'shift']);

        // Apply filters
        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($severity) {
            $query->where('severity', $severity);
        }

        // Apply date range filter
        switch ($dateRange) {
            case 'this_week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'last_week':
                $query->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            case 'last_month':
                $query->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]);
                break;
            case 'custom':
                if ($dateFrom && $dateTo) {
                    $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                }
                break;
        }

        // Get data
        $complaints = $query->orderBy('created_at', 'desc')->get();

        // Check if there are any results
        if ($complaints->isEmpty()) {
            return redirect()->back()->with('error', 'No complaints found matching your criteria.');
        }

        // Generate filename
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $filename = "complaints_export_{$timestamp}";

        // Export based on format
        if ($format === 'csv') {
            return $this->exportToCsv($complaints, $columns, $filename);
        } else {
            return $this->exportToPdf($complaints, $columns, $filename);
        }
    }

    /**
     * Export data to CSV.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $complaints
     * @param  array  $columns
     * @param  string  $filename
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    private function exportToCsv($complaints, $columns, $filename)
    {
        // Set up headers
        $headers = $this->getColumnHeaders($columns);
        
        // Create CSV content
        $callback = function() use ($complaints, $columns, $headers) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, $headers);
            
            // Add data
            foreach ($complaints as $complaint) {
                $row = [];
                foreach ($columns as $column) {
                    $row[] = $this->getColumnValue($complaint, $column);
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
     * @param  \Illuminate\Database\Eloquent\Collection  $complaints
     * @param  array  $columns
     * @param  string  $filename
     * @return \Illuminate\Http\Response
     */
    private function exportToPdf($complaints, $columns, $filename)
    {
        // Set up headers
        $headers = $this->getColumnHeaders($columns);
        
        // Prepare data for PDF
        $data = [];
        foreach ($complaints as $complaint) {
            $row = [];
            foreach ($columns as $column) {
                $row[$column] = $this->getColumnValue($complaint, $column);
            }
            $data[] = $row;
        }
        
        // Generate PDF view
        $pdf = View::make('admin.complaints.pdf-export', [
            'complaints' => $data,
            'headers' => $headers,
            'columns' => $columns,
            'filename' => $filename,
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        // Return PDF view for browser rendering
        return Response::make($pdf, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'inline; filename="' . $filename . '.pdf"',
        ]);
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
            'title' => 'Title',
            'severity' => 'Severity',
            'status' => 'Status',
            'description' => 'Description',
            'resolution' => 'Resolution Notes',
            'created_at' => 'Submitted Date',
            'resolved_at' => 'Resolved Date',
            'shift' => 'Related Shift',
        ];

        foreach ($columns as $column) {
            if (isset($columnMap[$column])) {
                $headers[] = $columnMap[$column];
            }
        }

        return $headers;
    }

    /**
     * Get column value for a complaint.
     *
     * @param  \App\Models\Complaint  $complaint
     * @param  string  $column
     * @return string
     */
    private function getColumnValue($complaint, $column)
    {
        switch ($column) {
            case 'id':
                return $complaint->id;
            case 'employee':
                return $complaint->user->first_name . ' ' . $complaint->user->last_name;
            case 'title':
                return $complaint->title;
            case 'severity':
                return ucfirst($complaint->severity);
            case 'status':
                return ucfirst(str_replace('_', ' ', $complaint->status));
            case 'description':
                return $complaint->description;
            case 'resolution':
                return $complaint->resolution_notes ?? 'N/A';
            case 'created_at':
                return $complaint->created_at->format('Y-m-d H:i');
            case 'resolved_at':
                return $complaint->resolved_at ? $complaint->resolved_at->format('Y-m-d H:i') : 'N/A';
            case 'shift':
                return $complaint->shift ? 'Shift #' . $complaint->shift->id . ' (' . $complaint->shift->date->format('Y-m-d') . ')' : 'N/A';
            default:
                return '';
        }
    }
}
