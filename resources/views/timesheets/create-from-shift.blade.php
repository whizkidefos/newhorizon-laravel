@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Submit Timesheet for Shift</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="alert alert-info mb-4">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading">Shift Information</h5>
                                <p class="mb-0"><strong>Date:</strong> {{ $shift->date->format('M d, Y') }}</p>
                                <p class="mb-0"><strong>Location:</strong> {{ $shift->location }}</p>
                                <p class="mb-0"><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($shift->checked_in_at)->format('h:i A') }}</p>
                                <p class="mb-0"><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($shift->checked_out_at)->format('h:i A') }}</p>
                                <p class="mb-0"><strong>Duration:</strong> {{ \Carbon\Carbon::parse($shift->checked_in_at)->diffForHumans(\Carbon\Carbon::parse($shift->checked_out_at), true) }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('timesheets.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="shift_id" value="{{ $shift->id }}">
                        <input type="hidden" name="date" value="{{ $shift->date->format('Y-m-d') }}">
                        <input type="hidden" name="start_time" value="{{ \Carbon\Carbon::parse($shift->checked_in_at)->format('H:i') }}">
                        <input type="hidden" name="end_time" value="{{ \Carbon\Carbon::parse($shift->checked_out_at)->format('H:i') }}">
                        
                        <div class="mb-3">
                            <label for="break_duration" class="form-label">Break Duration (hours)</label>
                            <input type="number" step="0.25" min="0" class="form-control @error('break_duration') is-invalid @enderror" id="break_duration" name="break_duration" value="{{ old('break_duration', 0) }}" required>
                            <div class="form-text">Total break time in hours (e.g., 0.5 for 30 minutes)</div>
                            @error('break_duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="hours_worked" class="form-label">Hours Worked</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('hours_worked') is-invalid @enderror" id="hours_worked" name="hours_worked" value="{{ old('hours_worked', $calculatedHours) }}" required>
                            <div class="form-text">Total hours worked excluding breaks (auto-calculated)</div>
                            @error('hours_worked')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="tasks_completed" class="form-label">Tasks Completed</label>
                            <textarea class="form-control @error('tasks_completed') is-invalid @enderror" id="tasks_completed" name="tasks_completed" rows="4" placeholder="List the main tasks you completed during this shift">{{ old('tasks_completed') }}</textarea>
                            @error('tasks_completed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Any additional information about your work">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('shifts.my') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Submit Timesheet
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
        // Auto-calculate hours worked based on break duration
        const breakDurationInput = document.getElementById('break_duration');
        const hoursWorkedInput = document.getElementById('hours_worked');
        
        function calculateHours() {
            // Get the total shift duration in minutes
            const shiftDuration = {{ \Carbon\Carbon::parse($shift->checked_in_at)->diffInMinutes(\Carbon\Carbon::parse($shift->checked_out_at)) }};
            
            // Convert break duration to minutes
            const breakMinutes = parseFloat(breakDurationInput.value || 0) * 60;
            
            // Calculate hours worked
            const hoursWorked = (shiftDuration - breakMinutes) / 60;
            
            hoursWorkedInput.value = Math.max(0, hoursWorked.toFixed(2));
        }
        
        breakDurationInput.addEventListener('input', calculateHours);
        
        // Initial calculation
        calculateHours();
    });
</script>
@endpush
@endsection
