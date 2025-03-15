@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Timesheet Details</h4>
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

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Timesheet Information</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>ID:</strong> #{{ $timesheet->id }}</p>
                                    <p>
                                        <strong>Status:</strong>
                                        @if($timesheet->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($timesheet->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($timesheet->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($timesheet->status) }}</span>
                                        @endif
                                    </p>
                                    <p><strong>Date:</strong> {{ $timesheet->date->format('M d, Y') }}</p>
                                    <p><strong>Start Time:</strong> {{ \Carbon\Carbon::parse($timesheet->start_time)->format('h:i A') }}</p>
                                    <p><strong>End Time:</strong> {{ \Carbon\Carbon::parse($timesheet->end_time)->format('h:i A') }}</p>
                                    <p><strong>Hours Worked:</strong> {{ number_format($timesheet->hours_worked, 2) }}</p>
                                    <p><strong>Break Duration:</strong> {{ number_format($timesheet->break_duration, 2) }} hours</p>
                                    <p><strong>Submitted:</strong> {{ $timesheet->created_at->format('M d, Y g:i A') }}</p>
                                    @if($timesheet->status == 'approved')
                                        <p><strong>Approved:</strong> {{ $timesheet->approved_at ? \Carbon\Carbon::parse($timesheet->approved_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                    @elseif($timesheet->status == 'rejected')
                                        <p><strong>Rejected:</strong> {{ $timesheet->rejected_at ? \Carbon\Carbon::parse($timesheet->rejected_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Employee Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3">
                                            @if($timesheet->user->profile_photo_path)
                                                <img src="{{ Storage::url($timesheet->user->profile_photo_path) }}" alt="{{ $timesheet->user->name }}" class="rounded-circle" width="60" height="60">
                                            @else
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    {{ strtoupper(substr($timesheet->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h5 class="mb-1">{{ $timesheet->user->name }}</h5>
                                            <p class="mb-0 text-muted">{{ $timesheet->user->email }}</p>
                                        </div>
                                    </div>
                                    <p><strong>Employee ID:</strong> {{ $timesheet->user->id }}</p>
                                    <p><strong>Position:</strong> {{ $timesheet->user->position ?? 'N/A' }}</p>
                                    <p><strong>Department:</strong> {{ $timesheet->user->department ?? 'N/A' }}</p>
                                    <p><strong>Phone:</strong> {{ $timesheet->user->phone ?? 'N/A' }}</p>
                                    <a href="{{ route('admin.users.show', $timesheet->user) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-user me-1"></i> View Employee Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($timesheet->shift)
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Related Shift</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Shift ID:</strong> #{{ $timesheet->shift->id }}</p>
                                        <p><strong>Date:</strong> {{ $timesheet->shift->date->format('M d, Y') }}</p>
                                        <p><strong>Location:</strong> {{ $timesheet->shift->location }}</p>
                                        <p><strong>Position:</strong> {{ $timesheet->shift->position }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Check-in:</strong> {{ $timesheet->shift->checked_in_at ? \Carbon\Carbon::parse($timesheet->shift->checked_in_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                        <p><strong>Check-out:</strong> {{ $timesheet->shift->checked_out_at ? \Carbon\Carbon::parse($timesheet->shift->checked_out_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($timesheet->shift->status) }}</p>
                                        <a href="{{ route('admin.shifts.show', $timesheet->shift) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-calendar-alt me-1"></i> View Shift Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Tasks Completed</h5>
                                </div>
                                <div class="card-body">
                                    <div class="p-3 bg-light rounded">
                                        {!! nl2br(e($timesheet->tasks_completed)) ?: '<span class="text-muted">No tasks specified</span>' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Additional Notes</h5>
                                </div>
                                <div class="card-body">
                                    <div class="p-3 bg-light rounded">
                                        {!! nl2br(e($timesheet->notes)) ?: '<span class="text-muted">No additional notes</span>' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($timesheet->status == 'rejected' && $timesheet->rejection_reason)
                        <div class="card mb-4 border-danger">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">Rejection Reason</h5>
                            </div>
                            <div class="card-body">
                                <div class="p-3 bg-light rounded">
                                    {!! nl2br(e($timesheet->rejection_reason)) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="{{ route('admin.timesheets.edit', $timesheet) }}" class="btn btn-primary me-2">
                                <i class="fas fa-edit me-1"></i> Edit Timesheet
                            </a>
                            @if($timesheet->status == 'pending')
                                <form action="{{ route('admin.timesheets.approve', $timesheet) }}" method="POST" class="d-inline me-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check me-1"></i> Approve
                                    </button>
                                </form>
                                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="fas fa-times me-1"></i> Reject
                                </button>
                            @endif
                            <form action="{{ route('admin.timesheets.destroy', $timesheet) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this timesheet?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                        <a href="{{ route('admin.timesheets.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Timesheets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.timesheets.reject', $timesheet) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Timesheet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                        <div class="form-text">Please provide a clear reason for rejecting this timesheet. This will be visible to the employee.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Timesheet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
