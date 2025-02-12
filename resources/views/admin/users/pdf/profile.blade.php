<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>User Profile - {{ $user->full_name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .user-initials {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #1a56db;
            padding-bottom: 5px;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 10px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 150px auto;
            gap: 5px;
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #4b5563;
        }
        .value {
            color: #1f2937;
        }
        .card {
            border: 1px solid #e5e7eb;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 12px;
        }
        .status-verified {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-unverified {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="user-initials">
            {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
        </div>
        <h1>User Profile - {{ $user->full_name }}</h1>
        <p>Generated on {{ now()->format('d M Y H:i') }}</p>
    </div>

    @if(in_array('personal', $sections))
    <div class="section">
        <h2 class="section-title">Personal Information</h2>
        <div class="info-grid">
            <div class="label">Name:</div>
            <div class="value">{{ $user->full_name }}</div>
            
            <div class="label">Email:</div>
            <div class="value">{{ $user->email }}</div>
            
            <div class="label">Mobile:</div>
            <div class="value">{{ $user->mobile_number }}</div>
            
            <div class="label">Job Role:</div>
            <div class="value">{{ $user->job_role }}</div>
            
            <div class="label">Date of Birth:</div>
            <div class="value">{{ $user->date_of_birth?->format('d M Y') }}</div>
            
            <div class="label">Gender:</div>
            <div class="value">{{ ucfirst($user->gender) }}</div>
            
            <div class="label">Nationality:</div>
            <div class="value">{{ $user->nationality }}</div>
            
            <div class="label">NI Number:</div>
            <div class="value">{{ $user->national_insurance_number }}</div>
        </div>
    </div>
    @endif

    @if(in_array('documents', $sections))
    <div class="section">
        <h2 class="section-title">Documents & Certifications</h2>
        @forelse($user->documents as $document)
        <div class="card">
            <div class="info-grid">
                <div class="label">Type:</div>
                <div class="value">{{ $document->type }}</div>
                
                <div class="label">Uploaded:</div>
                <div class="value">{{ $document->created_at->format('d M Y') }}</div>
                
                <div class="label">Status:</div>
                <div class="value">
                    @if($document->verified)
                    <span class="status status-verified">Verified</span>
                    @else
                    <span class="status status-unverified">Pending</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p>No documents uploaded</p>
        @endforelse

        @if($user->certifications->count() > 0)
        <h3>Certifications</h3>
        @foreach($user->certifications as $cert)
        <div class="card">
            <div class="info-grid">
                <div class="label">Title:</div>
                <div class="value">{{ $cert->title }}</div>
                
                <div class="label">Issued Date:</div>
                <div class="value">{{ $cert->issued_date?->format('d M Y') }}</div>
                
                <div class="label">Expiry Date:</div>
                <div class="value">{{ $cert->expiry_date?->format('d M Y') }}</div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    @endif

    @if(in_array('address', $sections) && $user->profileDetail)
    <div class="section">
        <h2 class="section-title">Address Information</h2>
        <div class="info-grid">
            <div class="label">Address:</div>
            <div class="value">
                {{ $user->profileDetail->address_line_1 }}
                @if($user->profileDetail->address_line_2)
                <br>{{ $user->profileDetail->address_line_2 }}
                @endif
            </div>
            
            <div class="label">City:</div>
            <div class="value">{{ $user->profileDetail->city }}</div>
            
            <div class="label">Postcode:</div>
            <div class="value">{{ $user->profileDetail->postcode }}</div>
            
            <div class="label">Country:</div>
            <div class="value">{{ $user->profileDetail->country }}</div>
        </div>
    </div>
    @endif

    @if(in_array('bank', $sections) && $user->bankDetail)
    <div class="section page-break">
        <h2 class="section-title">Bank Information</h2>
        <div class="info-grid">
            <div class="label">Account Name:</div>
            <div class="value">{{ $user->bankDetail->account_name }}</div>
            
            <div class="label">Bank Name:</div>
            <div class="value">{{ $user->bankDetail->bank_name }}</div>
            
            <div class="label">Account Number:</div>
            <div class="value">{{ $user->bankDetail->account_number }}</div>
            
            <div class="label">Sort Code:</div>
            <div class="value">{{ $user->bankDetail->sort_code }}</div>
        </div>
    </div>
    @endif

    @if(in_array('work', $sections) && $user->workHistory->count() > 0)
    <div class="section">
        <h2 class="section-title">Work History</h2>
        @foreach($user->workHistory as $work)
        <div class="card">
            <div class="info-grid">
                <div class="label">Company:</div>
                <div class="value">{{ $work->company_name }}</div>
                
                <div class="label">Position:</div>
                <div class="value">{{ $work->position }}</div>
                
                <div class="label">Duration:</div>
                <div class="value">
                    {{ $work->start_date->format('M Y') }} - 
                    {{ $work->end_date ? $work->end_date->format('M Y') : 'Present' }}
                </div>
                
                @if($work->description)
                <div class="label">Description:</div>
                <div class="value">{{ $work->description }}</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if(in_array('training', $sections) && $user->trainingRecords->count() > 0)
    <div class="section">
        <h2 class="section-title">Training Records</h2>
        @foreach($user->trainingRecords as $training)
        <div class="card">
            <div class="info-grid">
                <div class="label">Title:</div>
                <div class="value">{{ $training->title }}</div>
                
                <div class="label">Provider:</div>
                <div class="value">{{ $training->provider }}</div>
                
                <div class="label">Completed:</div>
                <div class="value">{{ $training->completion_date?->format('d M Y') }}</div>
                
                @if($training->expiry_date)
                <div class="label">Expires:</div>
                <div class="value">{{ $training->expiry_date->format('d M Y') }}</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</body>
</html>
