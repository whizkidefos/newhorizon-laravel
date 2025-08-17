<?php

namespace App\Http\Controllers;

use App\Exports\ProfileExport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Dompdf\Options;
use Maatwebsite\Excel\Facades\Excel;

class ProfileExportController extends Controller
{
    /**
     * Show the export form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('profile.export');
    }

    /**
     * Export profile based on filter criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        // Validate request
        $request->validate([
            'format' => 'required|in:csv,excel,pdf',
            'columns' => 'required|array',
            'columns.*' => 'string',
        ]);

        // Get user and export parameters
        $user = Auth::user();
        $format = $request->input('format');
        $columns = $request->input('columns');

        // Generate filename
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $filename = "profile_export_{$user->username}_{$timestamp}";

        // Export based on format
        switch ($format) {
            case 'csv':
                return $this->exportToCsv($user, $columns, $filename);
            case 'excel':
                return $this->exportToExcel($user, $columns, $filename);
            case 'pdf':
                return $this->exportToPdf($user, $columns, $filename);
            default:
                return $this->exportToCsv($user, $columns, $filename);
        }
    }

    /**
     * Export data to CSV.
     *
     * @param  \App\Models\User  $user
     * @param  array  $columns
     * @param  string  $filename
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    private function exportToCsv($user, $columns, $filename)
    {
        // Set up headers
        $headers = $this->getColumnHeaders($columns);
        
        // Create CSV content
        $callback = function() use ($user, $columns, $headers) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, $headers);
            
            // Add data
            $row = [];
            foreach ($columns as $column) {
                $row[] = $this->getColumnValue($user, $column);
            }
            fputcsv($file, $row);
            
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
     * Export data to Excel.
     *
     * @param  \App\Models\User  $user
     * @param  array  $columns
     * @param  string  $filename
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    private function exportToExcel($user, $columns, $filename)
    {   
        return Excel::download(new ProfileExport($user, $columns), $filename . '.xlsx');
    }

    /**
     * Export data to PDF.
     *
     * @param  \App\Models\User  $user
     * @param  array  $columns
     * @param  string  $filename
     * @return \Illuminate\Http\Response
     */
    private function exportToPdf($user, $columns, $filename)
    {
        // Set up headers
        $headers = $this->getColumnHeaders($columns);
        
        // Prepare data for PDF
        $data = [];
        foreach ($columns as $column) {
            $data[$column] = $this->getColumnValue($user, $column);
        }
        
        // Prepare additional data for PDF if needed
        $workHistory = in_array('work_history', $columns) ? $user->workHistory()->orderBy('start_date', 'desc')->get() : null;
        $trainingRecords = in_array('training_records', $columns) ? $user->trainingRecords()->orderBy('completion_date', 'desc')->get() : null;
        
        // Prepare profile image as base64 if available
        $profileImageBase64 = null;
        if ($user->profile_photo) {
            $imagePath = storage_path('app/public/' . $user->profile_photo);
            if (file_exists($imagePath)) {
                // Use Intervention Image to fix orientation issues
                try {
                    // For Intervention Image v3
                    $driver = new \Intervention\Image\Drivers\Gd\Driver();
                    $imageManager = new \Intervention\Image\ImageManager($driver);
                    $image = $imageManager->read($imagePath);
                    // Fix orientation based on EXIF data
                    $image = $image->autoOrientate();
                    // Convert to data URL
                    $profileImageBase64 = base64_encode($image->toJpeg(90)->toString());
                } catch (\Exception $e) {
                    // Fallback to direct file reading if Intervention Image fails
                    $imageData = file_get_contents($imagePath);
                    $profileImageBase64 = base64_encode($imageData);
                }
            }
        }
        
        // Generate PDF view
        $pdf = View::make('profile.pdf-export', [
            'user' => $user,
            'data' => $data,
            'headers' => $headers,
            'columns' => $columns,
            'filename' => $filename,
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s'),
            'workHistory' => $workHistory,
            'trainingRecords' => $trainingRecords,
            'profileImageBase64' => $profileImageBase64
        ]);
        
        // Create PDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true); // Enable remote file access
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdf);
        $dompdf->setPaper('A4', 'portrait');
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
            'profile_photo' => 'Profile Picture',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'username' => 'Username',
            'mobile_number' => 'Mobile Number',
            'job_role' => 'Job Role',
            'date_of_birth' => 'Date of Birth',
            'gender' => 'Gender',
            'national_insurance_number' => 'NI Number',
            'nationality' => 'Nationality',
            'address' => 'Address',
            'right_to_work_uk' => 'Right to Work in UK',
            'has_enhanced_dbs' => 'Enhanced DBS',
            'has_criminal_convictions' => 'Criminal Convictions',
            'employee_id' => 'Employee ID',
            'department' => 'Department',
            'position' => 'Position',
            'created_at' => 'Account Created',
            'work_history' => 'Work History',
            'training_records' => 'Training Records',
        ];

        foreach ($columns as $column) {
            if (isset($columnMap[$column])) {
                $headers[] = $columnMap[$column];
            }
        }

        return $headers;
    }

    /**
     * Get column value for a user.
     *
     * @param  \App\Models\User  $user
     * @param  string  $column
     * @return string
     */
    private function getColumnValue($user, $column)
    {
        switch ($column) {
            case 'id':
                return $user->id;
            case 'profile_photo':
                return $user->profile_photo ? 'Available' : 'Not provided';
            case 'first_name':
                return $user->first_name;
            case 'last_name':
                return $user->last_name;
            case 'email':
                return $user->email;
            case 'username':
                return $user->username;
            case 'mobile_number':
                return $user->mobile_number;
            case 'job_role':
                return ucwords(str_replace('_', ' ', $user->job_role));
            case 'date_of_birth':
                return $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : 'Not provided';
            case 'gender':
                return ucfirst($user->gender);
            case 'national_insurance_number':
                return $user->national_insurance_number;
            case 'nationality':
                return $user->nationality;
            case 'address':
                $address = '';
                if ($user->profileDetail) {
                    $parts = [];
                    if ($user->profileDetail->address_line_1) $parts[] = $user->profileDetail->address_line_1;
                    if ($user->profileDetail->address_line_2) $parts[] = $user->profileDetail->address_line_2;
                    if ($user->profileDetail->city) $parts[] = $user->profileDetail->city;
                    if ($user->profileDetail->county) $parts[] = $user->profileDetail->county;
                    if ($user->profileDetail->postcode) $parts[] = $user->profileDetail->postcode;
                    if ($user->profileDetail->country) $parts[] = $user->profileDetail->country;
                    $address = implode(', ', $parts);
                }
                return $address ?: 'Not provided';
            case 'right_to_work_uk':
                return $user->right_to_work_uk ? 'Yes' : 'No';
            case 'has_enhanced_dbs':
                return $user->has_enhanced_dbs ? 'Yes' : 'No';
            case 'has_criminal_convictions':
                return $user->has_criminal_convictions ? 'Yes' : 'No';
            case 'employee_id':
                return $user->employee_id ?? 'Not provided';
            case 'department':
                return $user->department ?? 'Not provided';
            case 'position':
                return $user->position ?? 'Not provided';
            case 'created_at':
                return $user->created_at->format('Y-m-d');
            case 'work_history':
                // For CSV/Excel, just return a summary count
                return $user->workHistory()->count() . ' employment records';
            case 'training_records':
                // For CSV/Excel, just return a summary count
                return $user->trainingRecords()->count() . ' training records';
            default:
                return '';
        }
    }
}
