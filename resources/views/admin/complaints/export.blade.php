@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Export Complaints</h4>
                    <div>
                        <a href="{{ route('admin.complaints.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-1"></i> Back to Complaints
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.complaints.export.download') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Filter Options</h5>
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label for="user_id" class="form-label">Employee</label>
                                                <select class="form-select" id="user_id" name="user_id">
                                                    <option value="">All Employees</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select" id="status" name="status">
                                                    <option value="">All Statuses</option>
                                                    <option value="open">Open</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="resolved">Resolved</option>
                                                    <option value="closed">Closed</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="severity" class="form-label">Severity</label>
                                                <select class="form-select" id="severity" name="severity">
                                                    <option value="">All Severities</option>
                                                    <option value="low">Low</option>
                                                    <option value="medium">Medium</option>
                                                    <option value="high">High</option>
                                                    <option value="critical">Critical</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="date_range" class="form-label">Date Range</label>
                                                <select class="form-select" id="date_range" name="date_range">
                                                    <option value="all">All Time</option>
                                                    <option value="this_week">This Week</option>
                                                    <option value="last_week">Last Week</option>
                                                    <option value="this_month">This Month</option>
                                                    <option value="last_month">Last Month</option>
                                                    <option value="custom">Custom Range</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row g-3 mt-2" id="custom_date_range" style="display: none;">
                                            <div class="col-md-6">
                                                <label for="date_from" class="form-label">Date From</label>
                                                <input type="date" class="form-control" id="date_from" name="date_from">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="date_to" class="form-label">Date To</label>
                                                <input type="date" class="form-control" id="date_to" name="date_to">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Export Format</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Select Format</label>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="format" id="format_csv" value="csv" checked>
                                                    <label class="form-check-label" for="format_csv">
                                                        <i class="fas fa-file-csv text-primary me-1"></i> CSV
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="format" id="format_pdf" value="pdf">
                                                    <label class="form-check-label" for="format_pdf">
                                                        <i class="fas fa-file-pdf text-danger me-1"></i> PDF
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Columns to Include</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="include_all" checked>
                                                    <label class="form-check-label fw-bold" for="include_all">
                                                        Select All
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_id" value="id" checked>
                                                    <label class="form-check-label" for="col_id">
                                                        ID
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_employee" value="employee" checked>
                                                    <label class="form-check-label" for="col_employee">
                                                        Employee Name
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_title" value="title" checked>
                                                    <label class="form-check-label" for="col_title">
                                                        Title
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_severity" value="severity" checked>
                                                    <label class="form-check-label" for="col_severity">
                                                        Severity
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_status" value="status" checked>
                                                    <label class="form-check-label" for="col_status">
                                                        Status
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check mb-2 invisible">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">
                                                        &nbsp;
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_description" value="description" checked>
                                                    <label class="form-check-label" for="col_description">
                                                        Description
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_resolution" value="resolution" checked>
                                                    <label class="form-check-label" for="col_resolution">
                                                        Resolution Notes
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_created_at" value="created_at" checked>
                                                    <label class="form-check-label" for="col_created_at">
                                                        Submitted Date
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_resolved_at" value="resolved_at" checked>
                                                    <label class="form-check-label" for="col_resolved_at">
                                                        Resolved Date
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_shift" value="shift" checked>
                                                    <label class="form-check-label" for="col_shift">
                                                        Related Shift
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-file-export me-1"></i> Export Complaints
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle date range selection
        const dateRangeSelect = document.getElementById('date_range');
        const customDateRange = document.getElementById('custom_date_range');
        
        dateRangeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDateRange.style.display = 'flex';
            } else {
                customDateRange.style.display = 'none';
            }
        });
        
        // Handle select all checkbox
        const includeAllCheckbox = document.getElementById('include_all');
        const columnCheckboxes = document.querySelectorAll('.column-checkbox');
        
        includeAllCheckbox.addEventListener('change', function() {
            columnCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
        
        // Update select all checkbox when individual checkboxes change
        columnCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(columnCheckboxes).every(c => c.checked);
                includeAllCheckbox.checked = allChecked;
            });
        });
    });
</script>
@endpush
@endsection
