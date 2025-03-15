@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Timesheet</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('timesheets.update', $timesheet) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $timesheet->date->format('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="shift_id" class="form-label">Related Shift (Optional)</label>
                                <select class="form-select @error('shift_id') is-invalid @enderror" id="shift_id" name="shift_id">
                                    <option value="">No related shift</option>
                                    @foreach(auth()->user()->shifts()->whereIn('status', ['completed'])->orderBy('date', 'desc')->get() as $shift)
                                        <option value="{{ $shift->id }}" {{ old('shift_id', $timesheet->shift_id) == $shift->id ? 'selected' : '' }}>
                                            {{ $shift->date->format('M d, Y') }} - {{ $shift->location }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('shift_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($timesheet->start_time)->format('H:i')) }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($timesheet->end_time)->format('H:i')) }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="hours_worked" class="form-label">Hours Worked</label>
                                <input type="number" step="0.01" min="0" class="form-control @error('hours_worked') is-invalid @enderror" id="hours_worked" name="hours_worked" value="{{ old('hours_worked', $timesheet->hours_worked) }}" required>
                                <div class="form-text">Total hours worked excluding breaks</div>
                                @error('hours_worked')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="break_duration" class="form-label">Break Duration (hours)</label>
                                <input type="number" step="0.25" min="0" class="form-control @error('break_duration') is-invalid @enderror" id="break_duration" name="break_duration" value="{{ old('break_duration', $timesheet->break_duration) }}" required>
                                <div class="form-text">Total break time in hours (e.g., 0.5 for 30 minutes)</div>
                                @error('break_duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tasks_completed" class="form-label">Tasks Completed</label>
                            <textarea class="form-control @error('tasks_completed') is-invalid @enderror" id="tasks_completed" name="tasks_completed" rows="4" placeholder="List the main tasks you completed during this time period">{{ old('tasks_completed', $timesheet->tasks_completed) }}</textarea>
                            @error('tasks_completed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Any additional information about your work">{{ old('notes', $timesheet->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('timesheets.show', $timesheet) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
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
        // Auto-calculate hours worked based on start and end times
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const hoursWorkedInput = document.getElementById('hours_worked');
        const breakDurationInput = document.getElementById('break_duration');
        
        function calculateHours() {
            if (startTimeInput.value && endTimeInput.value) {
                const startParts = startTimeInput.value.split(':');
                const endParts = endTimeInput.value.split(':');
                
                let startMinutes = parseInt(startParts[0]) * 60 + parseInt(startParts[1]);
                let endMinutes = parseInt(endParts[0]) * 60 + parseInt(endParts[1]);
                
                // If end time is earlier than start time, assume it's the next day
                if (endMinutes < startMinutes) {
                    endMinutes += 24 * 60;
                }
                
                const totalMinutes = endMinutes - startMinutes;
                const breakMinutes = parseFloat(breakDurationInput.value || 0) * 60;
                
                const hoursWorked = (totalMinutes - breakMinutes) / 60;
                
                hoursWorkedInput.value = Math.max(0, hoursWorked.toFixed(2));
            }
        }
        
        startTimeInput.addEventListener('change', calculateHours);
        endTimeInput.addEventListener('change', calculateHours);
        breakDurationInput.addEventListener('input', calculateHours);
    });
</script>
@endpush
@endsection
