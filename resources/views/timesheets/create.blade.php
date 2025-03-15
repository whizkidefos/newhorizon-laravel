@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create New Timesheet</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('timesheets.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="shift_id" class="form-label">Related Shift (Optional)</label>
                                <select class="form-select @error('shift_id') is-invalid @enderror" id="shift_id" name="shift_id">
                                    <option value="">No related shift</option>
                                    @foreach(auth()->user()->shifts()->whereIn('status', ['completed'])->orderBy('date', 'desc')->get() as $shift)
                                        <option value="{{ $shift->id }}" {{ old('shift_id') == $shift->id ? 'selected' : '' }}>
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
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="hours_worked" class="form-label">Hours Worked</label>
                                <input type="number" step="0.01" min="0" class="form-control @error('hours_worked') is-invalid @enderror" id="hours_worked" name="hours_worked" value="{{ old('hours_worked') }}" required>
                                <div class="form-text">Total hours worked excluding breaks</div>
                                @error('hours_worked')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="break_duration" class="form-label">Break Duration (hours)</label>
                                <input type="number" step="0.25" min="0" class="form-control @error('break_duration') is-invalid @enderror" id="break_duration" name="break_duration" value="{{ old('break_duration', 0) }}" required>
                                <div class="form-text">Total break time in hours (e.g., 0.5 for 30 minutes)</div>
                                @error('break_duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tasks_completed" class="form-label">Tasks Completed</label>
                            <textarea class="form-control @error('tasks_completed') is-invalid @enderror" id="tasks_completed" name="tasks_completed" rows="4" placeholder="List the main tasks you completed during this time period">{{ old('tasks_completed') }}</textarea>
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
                            <a href="{{ route('timesheets.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Submit Timesheet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Timesheet Guidelines</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li><strong>Accuracy</strong> - Ensure all times and hours are accurate and match your actual work.</li>
                        <li><strong>Completeness</strong> - Include all tasks completed during your work period.</li>
                        <li><strong>Timeliness</strong> - Submit your timesheet as soon as possible after completing work.</li>
                        <li><strong>Breaks</strong> - Always include any breaks taken during your work period.</li>
                        <li><strong>Notes</strong> - Include any relevant information that may affect your work hours or performance.</li>
                    </ul>
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
        
        // Auto-fill from shift if selected
        const shiftSelect = document.getElementById('shift_id');
        
        shiftSelect.addEventListener('change', function() {
            if (this.value) {
                // You would need to implement an AJAX call to get shift details
                // This is a placeholder for that functionality
                fetch(`/shifts/${this.value}/details`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.checked_in_at) {
                            const checkinTime = new Date(data.checked_in_at);
                            startTimeInput.value = checkinTime.getHours().toString().padStart(2, '0') + ':' + 
                                                  checkinTime.getMinutes().toString().padStart(2, '0');
                        }
                        
                        if (data.checked_out_at) {
                            const checkoutTime = new Date(data.checked_out_at);
                            endTimeInput.value = checkoutTime.getHours().toString().padStart(2, '0') + ':' + 
                                                checkoutTime.getMinutes().toString().padStart(2, '0');
                        }
                        
                        calculateHours();
                    });
            }
        });
    });
</script>
@endpush
@endsection
