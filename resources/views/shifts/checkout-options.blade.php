@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Shift Completed - Next Steps</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i> You have successfully checked out from your shift.
                    </div>

                    <h5 class="mt-4 mb-3">Shift Details</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Date:</strong> {{ $shift->date }}</p>
                            <p><strong>Location:</strong> {{ $shift->location }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Check-in Time:</strong> {{ \Carbon\Carbon::parse($shift->checked_in_at)->format('h:i A') }}</p>
                            <p><strong>Check-out Time:</strong> {{ \Carbon\Carbon::parse($shift->checked_out_at)->format('h:i A') }}</p>
                            <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($shift->checked_in_at)->diffForHumans(\Carbon\Carbon::parse($shift->checked_out_at), true) }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4 h-100">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Submit Timesheet</h5>
                                </div>
                                <div class="card-body">
                                    <p>Submit your timesheet for this shift to record your hours worked and get paid.</p>
                                    
                                    <form action="{{ route('shifts.quick-timesheet', $shift) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="break_duration" class="form-label">Break Duration (hours)</label>
                                            <input type="number" class="form-control" id="break_duration" name="break_duration" step="0.25" min="0" value="0" required>
                                            <div class="form-text">Enter your total break time in hours (e.g., 0.5 for 30 minutes)</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="tasks_completed" class="form-label">Tasks Completed</label>
                                            <textarea class="form-control" id="tasks_completed" name="tasks_completed" rows="3" placeholder="List the main tasks you completed during this shift"></textarea>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">Additional Notes</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any additional information about your shift"></textarea>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-clock me-1"></i> Submit Timesheet
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-4 h-100">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0">Report an Issue</h5>
                                </div>
                                <div class="card-body">
                                    <p>If you experienced any issues during your shift, please submit a complaint.</p>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('complaints.create-from-shift', $shift) }}" class="btn btn-warning">
                                            <i class="fas fa-exclamation-triangle me-1"></i> File a Complaint
                                        </a>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <p><strong>When to file a complaint:</strong></p>
                                        <ul>
                                            <li>Safety concerns at the workplace</li>
                                            <li>Issues with equipment or facilities</li>
                                            <li>Scheduling or staffing problems</li>
                                            <li>Workplace conflicts</li>
                                            <li>Any other concerns that affected your work</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('shifts.my') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to My Shifts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
