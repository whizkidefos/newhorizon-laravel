@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Timesheet</h4>
                    <div>
                        <a href="{{ route('admin.timesheets.show', $timesheet) }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-1"></i> Back to Timesheet
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.timesheets.update', $timesheet) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="user_id" class="form-label">Employee</label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                    <option value="">Select Employee</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $timesheet->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="shift_id" class="form-label">Related Shift (Optional)</label>
                                <select class="form-select @error('shift_id') is-invalid @enderror" id="shift_id" name="shift_id">
                                    <option value="">No related shift</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}" {{ old('shift_id', $timesheet->shift_id) == $shift->id ? 'selected' : '' }}>
                                            {{ $shift->date->format('M d, Y') }} - {{ $shift->location }} ({{ $shift->user->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('shift_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $timesheet->date->format('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($timesheet->start_time)->format('H:i')) }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($timesheet->end_time)->format('H:i')) }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="break_duration" class="form-label">Break Duration (hours)</label>
                                <input type="number" class="form-control @error('break_duration') is-invalid @enderror" id="break_duration" name="break_duration" value="{{ old('break_duration', $timesheet->break_duration) }}" step="0.01" min="0" required>
                                @error('break_duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="hours_worked" class="form-label">Hours Worked</label>
                                <input type="number" class="form-control @error('hours_worked') is-invalid @enderror" id="hours_worked" name="hours_worked" value="{{ old('hours_worked', $timesheet->hours_worked) }}" step="0.01" min="0" required>
                                @error('hours_worked')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="pending" {{ old('status', $timesheet->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status', $timesheet->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('status', $timesheet->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tasks_completed" class="form-label">Tasks Completed</label>
                            <textarea class="form-control @error('tasks_completed') is-invalid @enderror" id="tasks_completed" name="tasks_completed" rows="4">{{ old('tasks_completed', $timesheet->tasks_completed) }}</textarea>
                            @error('tasks_completed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4">{{ old('notes', $timesheet->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div id="rejection-reason-container" class="mb-3" style="{{ old('status', $timesheet->status) == 'rejected' ? '' : 'display: none;' }}">
                            <label for="rejection_reason" class="form-label">Rejection Reason</label>
                            <textarea class="form-control @error('rejection_reason') is-invalid @enderror" id="rejection_reason" name="rejection_reason" rows="3">{{ old('rejection_reason', $timesheet->rejection_reason) }}</textarea>
                            <div class="form-text">Please provide a clear reason for rejecting this timesheet. This will be visible to the employee.</div>
                            @error('rejection_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.timesheets.show', $timesheet) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Timesheet
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
        // Auto-calculate hours worked
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const breakDurationInput = document.getElementById('break_duration');
        const hoursWorkedInput = document.getElementById('hours_worked');
        
        function calculateHoursWorked() {
            if (startTimeInput.value && endTimeInput.value) {
                const startTime = new Date(`2000-01-01T${startTimeInput.value}:00`);
                const endTime = new Date(`2000-01-01T${endTimeInput.value}:00`);
                
                // If end time is before start time, assume it's the next day
                let diff = endTime - startTime;
                if (diff < 0) {
                    diff += 24 * 60 * 60 * 1000; // Add a day in milliseconds
                }
                
                // Convert to hours and subtract break duration
                let hours = diff / (1000 * 60 * 60);
                const breakDuration = parseFloat(breakDurationInput.value) || 0;
                hours = Math.max(0, hours - breakDuration);
                
                // Round to 2 decimal places
                hoursWorkedInput.value = Math.round(hours * 100) / 100;
            }
        }
        
        startTimeInput.addEventListener('change', calculateHoursWorked);
        endTimeInput.addEventListener('change', calculateHoursWorked);
        breakDurationInput.addEventListener('input', calculateHoursWorked);
        
        // Show/hide rejection reason based on status
        const statusSelect = document.getElementById('status');
        const rejectionReasonContainer = document.getElementById('rejection-reason-container');
        
        statusSelect.addEventListener('change', function() {
            if (this.value === 'rejected') {
                rejectionReasonContainer.style.display = '';
                document.getElementById('rejection_reason').setAttribute('required', 'required');
            } else {
                rejectionReasonContainer.style.display = 'none';
                document.getElementById('rejection_reason').removeAttribute('required');
            }
        });
    });
</script>
@endpush
@endsection
