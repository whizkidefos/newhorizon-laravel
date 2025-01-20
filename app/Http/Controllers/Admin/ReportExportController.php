<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportGeneratorService;
use Illuminate\Http\Request;

class ReportExportController extends Controller
{
    protected $reportGenerator;

    public function __construct(ReportGeneratorService $reportGenerator)
    {
        $this->reportGenerator = $reportGenerator;
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:shifts,staff,performance',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'format' => 'required|in:pdf,csv,excel',
            'filters' => 'array'
        ]);

        $filename = sprintf(
            '%s-report-%s-to-%s.%s',
            $validated['type'],
            $request->start_date,
            $request->end_date,
            $validated['format']
        );

        $content = match($validated['format']) {
            'pdf' => $this->reportGenerator->generatePDF(
                $validated['type'],
                $validated['start_date'],
                $validated['end_date'],
                $validated['filters'] ?? []
            ),
            'csv' => $this->reportGenerator->generateCSV(/* ... */),
            'excel' => $this->reportGenerator->generateExcel(/* ... */),
        };

        return response()->streamDownload(
            fn() => print($content),
            $filename,
            ['Content-Type' => $this->getContentType($validated['format'])]
        );
    }

    private function getContentType($format)
    {
        return match($format) {
            'pdf' => 'application/pdf',
            'csv' => 'text/csv',
            'excel' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        };
    }
}