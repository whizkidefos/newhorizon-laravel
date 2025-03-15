@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Export Timesheets</h4>
                    <div>
                        <a href="{{ route('admin.timesheets.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-1"></i> Back to Timesheets
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

                    <form action="{{ route('admin.timesheets.export.download') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Filter Options</h5>
                                        <div class="row g-3">
                                            <div class="col-md-4">
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
                                            <div class="col-md-4">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select" id="status" name="status">
                                                    <option value="">All Statuses</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="approved">Approved</option>
                                                    <option value="rejected">Rejected</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
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
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_date" value="date" checked>
                                                    <label class="form-check-label" for="col_date">
                                                        Date
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_start_time" value="start_time" checked>
                                                    <label class="form-check-label" for="col_start_time">
                                                        Start Time
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_end_time" value="end_time" checked>
                                                    <label class="form-check-label" for="col_end_time">
                                                        End Time
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
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_hours_worked" value="hours_worked" checked>
                                                    <label class="form-check-label" for="col_hours_worked">
                                                        Hours Worked
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_break_duration" value="break_duration" checked>
                                                    <label class="form-check-label" for="col_break_duration">
                                                        Break Duration
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_status" value="status" checked>
                                                    <label class="form-check-label" for="col_status">
                                                        Status
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_tasks" value="tasks" checked>
                                                    <label class="form-check-label" for="col_tasks">
                                                        Tasks Completed
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input column-checkbox" type="checkbox" name="columns[]" id="col_notes" value="notes" checked>
                                                    <label class="form-check-label" for="col_notes">
                                                        Notes
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-file-export me-1"></i> Export Timesheets
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
