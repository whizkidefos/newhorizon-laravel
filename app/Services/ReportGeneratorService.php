<?php

namespace App\Services;

use PDF;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;

class ReportGeneratorService
{
    public function generatePDF($type, $startDate, $endDate, $filters = [])
    {
        $data = $this->getData($type, $startDate, $endDate, $filters);
        $view = "reports.pdf.{$type}";
        
        $pdf = PDF::loadView($view, $data);
        
        return $pdf->output();
    }

    private function getData($type, $startDate, $endDate, $filters)
    {
        return match($type) {
            'shifts' => $this->getShiftData($startDate, $endDate, $filters),
            'staff' => $this->getStaffData($startDate, $endDate, $filters),
            'performance' => $this->getPerformanceData($startDate, $endDate, $filters),
            default => throw new \InvalidArgumentException('Invalid report type')
        };
    }

    private function getShiftData($startDate, $endDate, $filters)
    {
        $shifts = Shift::query()
            ->whereBetween('start_datetime', [$startDate, $endDate])
            ->when($filters['status'] ?? null, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($filters['location'] ?? null, function($query, $location) {
                $query->where('location', 'like', "%{$location}%");
            })
            ->with('user')
            ->get();

        $stats = [
            'total_shifts' => $shifts->count(),
            'completed_shifts' => $shifts->where('status', 'completed')->count(),
            'cancelled_shifts' => $shifts->where('status', 'cancelled')->count(),
            'total_hours' => $shifts->sum(function($shift) {
                return Carbon::parse($shift->start_datetime)
                    ->diffInHours($shift->end_datetime);
            }),
            'average_duration' => $shifts->avg(function($shift) {
                return Carbon::parse($shift->start_datetime)
                    ->diffInHours($shift->end_datetime);
            })
        ];

        return [
            'shifts' => $shifts,
            'stats' => $stats,
            'date_range' => [
                'start' => Carbon::parse($startDate)->format('d M Y'),
                'end' => Carbon::parse($endDate)->format('d M Y')
            ]
        ];
    }

    private function getStaffData($startDate, $endDate, $filters)
    {
        // Similar implementation for staff reports
    }

    private function getPerformanceData($startDate, $endDate, $filters)
    {
        // Similar implementation for performance reports
    }
}