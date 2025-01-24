<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TimesheetExport implements FromCollection, WithHeadings, WithMapping
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        return $this->user->shifts()
            ->whereIn('status', ['completed', 'approved'])
            ->orderBy('start_datetime', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'Start Time',
            'End Time',
            'Hours Worked',
            'Location',
            'Department',
            'Status',
            'Rate per Hour',
            'Total Amount',
            'Notes'
        ];
    }

    public function map($shift): array
    {
        return [
            $shift->start_datetime->format('Y-m-d'),
            $shift->checkin_time ? $shift->checkin_time->format('H:i') : $shift->start_datetime->format('H:i'),
            $shift->checkout_time ? $shift->checkout_time->format('H:i') : $shift->end_datetime->format('H:i'),
            $shift->duration,
            $shift->location,
            $shift->department,
            ucfirst($shift->status),
            '£' . number_format($shift->rate_per_hour, 2),
            '£' . number_format($shift->duration * $shift->rate_per_hour, 2),
            $shift->timesheet_notes
        ];
    }
}
