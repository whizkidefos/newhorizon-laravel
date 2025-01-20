<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Add your PDF styles here */
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .stats-container {
            margin-bottom: 20px;
        }
        .stats-box {
            display: inline-block;
            width: 30%;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Shift Report</h1>
        <p>{{ $date_range['start'] }} - {{ $date_range['end'] }}</p>
    </div>

    <div class="stats-container">
        <div class="stats-box">
            <h3>Total Shifts</h3>
            <p>{{ $stats['total_shifts'] }}</p>
        </div>
        <div class="stats-box">
            <h3>Completed Shifts</h3>
            <p>{{ $stats['completed_shifts'] }}</p>
        </div>
        <div class="stats-box">
            <h3>Total Hours</h3>
            <p>{{ number_format($stats['total_hours'], 1) }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Location</th>
                <th>Staff Member</th>
                <th>Duration</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shifts as $shift)
                <tr>
                    <td>{{ $shift->start_datetime->format('d M Y H:i') }}</td>
                    <td>{{ $shift->location }}</td>
                    <td>{{ $shift->user->full_name ?? 'Unassigned' }}</td>
                    <td>{{ $shift->duration }} hrs</td>
                    <td>{{ ucfirst($shift->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>