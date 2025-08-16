<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfileExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $user;
    protected $columns;

    /**
     * @param User $user
     * @param array $columns
     */
    public function __construct(User $user, $columns = [])
    {
        $this->user = $user;
        $this->columns = !empty($columns) ? $columns : [
            'id', 'first_name', 'last_name', 'email', 'username', 'mobile_number',
            'job_role', 'date_of_birth', 'gender', 'national_insurance_number',
            'nationality', 'address', 'created_at'
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([$this->user]);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headers = [];
        $headerMap = [
            'id' => 'ID',
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
        ];

        foreach ($this->columns as $column) {
            if (isset($headerMap[$column])) {
                $headers[] = $headerMap[$column];
            }
        }

        return $headers;
    }

    /**
     * @param mixed $user
     * @return array
     */
    public function map($user): array
    {
        $data = [];

        foreach ($this->columns as $column) {
            switch ($column) {
                case 'id':
                    $data[] = $user->id;
                    break;
                case 'first_name':
                    $data[] = $user->first_name;
                    break;
                case 'last_name':
                    $data[] = $user->last_name;
                    break;
                case 'email':
                    $data[] = $user->email;
                    break;
                case 'username':
                    $data[] = $user->username;
                    break;
                case 'mobile_number':
                    $data[] = $user->mobile_number;
                    break;
                case 'job_role':
                    $data[] = ucwords(str_replace('_', ' ', $user->job_role));
                    break;
                case 'date_of_birth':
                    $data[] = $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : 'Not provided';
                    break;
                case 'gender':
                    $data[] = ucfirst($user->gender);
                    break;
                case 'national_insurance_number':
                    $data[] = $user->national_insurance_number;
                    break;
                case 'nationality':
                    $data[] = $user->nationality;
                    break;
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
                    $data[] = $address ?: 'Not provided';
                    break;
                case 'right_to_work_uk':
                    $data[] = $user->right_to_work_uk ? 'Yes' : 'No';
                    break;
                case 'has_enhanced_dbs':
                    $data[] = $user->has_enhanced_dbs ? 'Yes' : 'No';
                    break;
                case 'has_criminal_convictions':
                    $data[] = $user->has_criminal_convictions ? 'Yes' : 'No';
                    break;
                case 'employee_id':
                    $data[] = $user->employee_id ?? 'Not provided';
                    break;
                case 'department':
                    $data[] = $user->department ?? 'Not provided';
                    break;
                case 'position':
                    $data[] = $user->position ?? 'Not provided';
                    break;
                case 'created_at':
                    $data[] = $user->created_at->format('Y-m-d');
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
