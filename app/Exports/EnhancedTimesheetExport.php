<?php

namespace App\Exports;

use App\Models\Timesheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Database\Eloquent\Collection;

class EnhancedTimesheetExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $timesheets;
    protected $columns;

    /**
     * @param Collection $timesheets
     * @param array $columns
     */
    public function __construct($timesheets, $columns = [])
    {
        $this->timesheets = $timesheets;
        $this->columns = !empty($columns) ? $columns : [
            'id', 'employee', 'date', 'start_time', 'end_time', 
            'hours_worked', 'break_duration', 'tasks', 'notes', 'status'
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->timesheets;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headers = [];
        $headerMap = [
            'id' => 'ID',
            'employee' => 'Employee Name',
            'date' => 'Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'hours_worked' => 'Hours Worked',
            'break_duration' => 'Break Duration (hrs)',
            'tasks' => 'Tasks Completed',
            'notes' => 'Notes',
            'status' => 'Status',
            'shift' => 'Related Shift',
            'created_at' => 'Submitted At',
            'updated_at' => 'Last Updated',
        ];

        foreach ($this->columns as $column) {
            if (isset($headerMap[$column])) {
                $headers[] = $headerMap[$column];
            }
        }

        return $headers;
    }

    /**
     * @param mixed $timesheet
     * @return array
     */
    public function map($timesheet): array
    {
        $data = [];

        foreach ($this->columns as $column) {
            switch ($column) {
                case 'id':
                    $data[] = $timesheet->id;
                    break;
                case 'employee':
                    $data[] = $timesheet->user->first_name . ' ' . $timesheet->user->last_name;
                    break;
                case 'date':
                    $data[] = $timesheet->date->format('Y-m-d');
                    break;
                case 'start_time':
                    $data[] = $timesheet->start_time->format('H:i');
                    break;
                case 'end_time':
                    $data[] = $timesheet->end_time->format('H:i');
                    break;
                case 'hours_worked':
                    $data[] = number_format($timesheet->hours_worked, 2);
                    break;
                case 'break_duration':
                    $data[] = number_format($timesheet->break_duration, 2);
                    break;
                case 'tasks':
                    $data[] = $timesheet->tasks_completed;
                    break;
                case 'notes':
                    $data[] = $timesheet->notes;
                    break;
                case 'status':
                    $data[] = ucfirst($timesheet->status);
                    break;
                case 'shift':
                    $data[] = $timesheet->shift ? "#{$timesheet->shift->id} - {$timesheet->shift->location}" : 'N/A';
                    break;
                case 'created_at':
                    $data[] = $timesheet->created_at->format('Y-m-d H:i');
                    break;
                case 'updated_at':
                    $data[] = $timesheet->updated_at->format('Y-m-d H:i');
                    break;
                default:
                    $data[] = '';
            }
        }

        return $data;
    }

    /**
     * @param Worksheet $sheet
     * @return void
     */
    public function styles(Worksheet $sheet)
    {
        // Style the header row
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'], // Indigo color
            ],
        ]);

        // Apply borders to all cells
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD'],
                ],
            ],
        ]);

        // Apply zebra striping
        for ($row = 2; $row <= $sheet->getHighestRow(); $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':' . $sheet->getHighestColumn() . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F3F4F6'], // Light gray
                    ],
                ]);
            }
        }
    }
}
