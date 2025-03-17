<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Submit Timesheet for Shift') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-900 dark:text-red-200" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    <div class="mb-6 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 dark:bg-blue-900 dark:text-blue-200" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0 mr-4">
                                <svg class="h-6 w-6 text-blue-500 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium mb-2">Shift Information</h3>
                                <p class="mb-1"><strong>Date:</strong> {{ $shift->start_datetime->format('M d, Y') }}</p>
                                <p class="mb-1"><strong>Location:</strong> {{ $shift->location }}</p>
                                <p class="mb-1"><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($shift->checked_in_at)->format('h:i A') }}</p>
                                <p class="mb-1"><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($shift->checked_out_at)->format('h:i A') }}</p>
                                <p class="mb-1"><strong>Duration:</strong> {{ \Carbon\Carbon::parse($shift->checked_in_at)->diffForHumans(\Carbon\Carbon::parse($shift->checked_out_at), true) }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('timesheets.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="shift_id" value="{{ $shift->id }}">
                        <input type="hidden" name="date" value="{{ $shift->start_datetime->format('Y-m-d') }}">
                        <input type="hidden" name="start_time" value="{{ \Carbon\Carbon::parse($shift->checked_in_at)->format('H:i') }}">
                        <input type="hidden" name="end_time" value="{{ \Carbon\Carbon::parse($shift->checked_out_at)->format('H:i') }}">
                        
                        <div class="mb-4">
                            <label for="break_duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Break Duration (hours)</label>
                            <input type="number" step="0.25" min="0" 
                                class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('break_duration') border-red-500 @enderror" 
                                id="break_duration" name="break_duration" value="{{ old('break_duration', 0) }}" required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Total break time in hours (e.g., 0.5 for 30 minutes)</p>
                            @error('break_duration')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="hours_worked" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hours Worked</label>
                            @php
                                // Calculate hours worked
                                $startTime = \Carbon\Carbon::parse($shift->checked_in_at);
                                $endTime = \Carbon\Carbon::parse($shift->checked_out_at);
                                $calculatedHours = $endTime->diffInMinutes($startTime) / 60;
                            @endphp
                            <input type="number" step="0.01" min="0" 
                                class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('hours_worked') border-red-500 @enderror" 
                                id="hours_worked" name="hours_worked" value="{{ old('hours_worked', $calculatedHours) }}" required>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Total hours worked excluding breaks (auto-calculated)</p>
                            @error('hours_worked')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="tasks_completed" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tasks Completed</label>
                            <textarea 
                                class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('tasks_completed') border-red-500 @enderror" 
                                id="tasks_completed" name="tasks_completed" rows="4" 
                                placeholder="List the main tasks you completed during this shift">{{ old('tasks_completed') }}</textarea>
                            @error('tasks_completed')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Additional Notes</label>
                            <textarea 
                                class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('notes') border-red-500 @enderror" 
                                id="notes" name="notes" rows="3" 
                                placeholder="Any additional information about your work">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-between">
                            <a href="{{ route('shifts.my') }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                                Submit Timesheet
                            </button>
                        </div>
                    </form>
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
</x-app-layout>
