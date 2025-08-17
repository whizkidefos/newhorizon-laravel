<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $filename }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        img {
            max-width: 100%;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #4F46E5;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 14px;
            margin-top: 0;
        }
        .profile-section {
            margin-bottom: 30px;
        }
        .profile-section h2 {
            color: #4F46E5;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            font-size: 18px;
        }
        .profile-data {
            width: 100%;
            border-collapse: collapse;
        }
        .profile-data td {
            padding: 8px;
            vertical-align: top;
        }
        .profile-data tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .label {
            font-weight: bold;
            width: 40%;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        @page {
            margin: 0.5cm;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h1>Profile Information</h1>
                <p>{{ $user->first_name }} {{ $user->last_name }} - {{ $timestamp }}</p>
            </div>
            @if(isset($profileImageBase64) && $profileImageBase64)
            <div style="width: 100px; height: 100px; overflow: hidden; border-radius: 50%; border: 3px solid #4F46E5;">
                <img src="data:image/jpeg;base64,{{ $profileImageBase64 }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Profile Photo">
            </div>
            @endif
        </div>
    </div>

    @php
        $personalFields = ['first_name', 'last_name', 'email', 'username', 'mobile_number', 'date_of_birth', 'gender'];
        $professionalFields = ['job_role', 'national_insurance_number', 'nationality', 'right_to_work_uk', 'has_enhanced_dbs', 'has_criminal_convictions'];
        $otherFields = ['address', 'employee_id', 'department', 'position', 'created_at'];
        $additionalSections = ['work_history', 'training_records'];
        
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
            'work_history' => 'Work History',
            'training_records' => 'Training Records',
        ];
    @endphp

    <!-- Personal Information -->
    @if(count(array_intersect($personalFields, $columns)) > 0)
    <div class="profile-section">
        <h2>Personal Information</h2>
        <table class="profile-data">
            @foreach($columns as $column)
                @if(in_array($column, $personalFields))
                    <tr>
                        <td class="label">{{ $headerMap[$column] }}</td>
                        <td>{{ $data[$column] }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
    @endif

    <!-- Professional Information -->
    @if(count(array_intersect($professionalFields, $columns)) > 0)
    <div class="profile-section">
        <h2>Professional Information</h2>
        <table class="profile-data">
            @foreach($columns as $column)
                @if(in_array($column, $professionalFields))
                    <tr>
                        <td class="label">{{ $headerMap[$column] }}</td>
                        <td>{{ $data[$column] }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
    @endif

    <!-- Other Information -->
    @if(count(array_intersect($otherFields, $columns)) > 0)
    <div class="profile-section">
        <h2>Other Information</h2>
        <table class="profile-data">
            @foreach($columns as $column)
                @if(in_array($column, $otherFields))
                    <tr>
                        <td class="label">{{ $headerMap[$column] }}</td>
                        <td>{{ $data[$column] }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
    @endif

    <!-- Work History Section -->
    @if(in_array('work_history', $columns) && isset($workHistory) && $workHistory->count() > 0)
    <div class="profile-section">
        <h2>Work History</h2>
        <table class="profile-data">
            <tr>
                <th style="text-align: left; padding: 8px; background-color: #f2f2f2;">Company</th>
                <th style="text-align: left; padding: 8px; background-color: #f2f2f2;">Position</th>
                <th style="text-align: left; padding: 8px; background-color: #f2f2f2;">Period</th>
            </tr>
            @foreach($workHistory as $work)
            <tr>
                <td style="padding: 8px;">{{ $work->company_name }}</td>
                <td style="padding: 8px;">{{ $work->position }}</td>
                <td style="padding: 8px;">
                    {{ $work->start_date->format('M Y') }} - 
                    {{ $work->end_date ? $work->end_date->format('M Y') : 'Present' }}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif

    <!-- Training Records Section -->
    @if(in_array('training_records', $columns) && isset($trainingRecords) && $trainingRecords->count() > 0)
    <div class="profile-section">
        <h2>Training Records</h2>
        <table class="profile-data">
            <tr>
                <th style="text-align: left; padding: 8px; background-color: #f2f2f2;">Training Name</th>
                <th style="text-align: left; padding: 8px; background-color: #f2f2f2;">Type</th>
                <th style="text-align: left; padding: 8px; background-color: #f2f2f2;">Status</th>
                <th style="text-align: left; padding: 8px; background-color: #f2f2f2;">Completion Date</th>
                <th style="text-align: left; padding: 8px; background-color: #f2f2f2;">Expiry Date</th>
            </tr>
            @foreach($trainingRecords as $training)
            <tr>
                <td style="padding: 8px;">{{ $training->training_name }}</td>
                <td style="padding: 8px;">{{ $training->type }}</td>
                <td style="padding: 8px;">{{ $training->passed ? 'Passed' : 'Not Passed' }}</td>
                <td style="padding: 8px;">{{ $training->completion_date ? $training->completion_date->format('d M Y') : 'N/A' }}</td>
                <td style="padding: 8px;">{{ $training->expiry_date ? $training->expiry_date->format('d M Y') : 'N/A' }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif

    <div class="footer">
        <p>This document was generated from New Horizon Healthcare on {{ $timestamp }}.</p>
        <p>The information contained in this document is confidential and for personal use only.</p>
    </div>
</body>
</html>
