<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $filename }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
        .export-info {
            margin-bottom: 20px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Timesheets Export</h1>
    
    <div class="export-info">
        <p>Generated on: {{ $timestamp }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($timesheets as $timesheet)
                <tr>
                    @foreach($columns as $column)
                        <td>{{ $timesheet[$column] }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) }}" style="text-align: center;">No timesheets found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>New Horizon - Timesheet Report - {{ $timestamp }}</p>
    </div>
</body>
</html>
