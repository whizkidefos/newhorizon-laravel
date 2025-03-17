<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create New Timesheet') }}
            </h2>
            <a href="{{ route('timesheets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Back to Timesheets
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-900 dark:text-red-200" role="alert">
                            <p class="font-bold">Error</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-900 dark:text-green-200" role="alert">
                            <p class="font-bold">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <form action="{{ route('timesheets.store') }}" method="POST">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                                        <input type="date" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('date') ring-2 ring-red-500 @enderror" id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required>
                                        @error('date')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="shift_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Related Shift (Optional)</label>
                                        <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('shift_id') ring-2 ring-red-500 @enderror" id="shift_id" name="shift_id">
                                            <option value="">No related shift</option>
                                            @foreach(auth()->user()->shifts()->whereIn('status', ['completed'])->orderBy('date', 'desc')->get() as $shift)
                                                <option value="{{ $shift->id }}" {{ old('shift_id') == $shift->id ? 'selected' : '' }}>
                                                    {{ $shift->date->format('M d, Y') }} - {{ $shift->location }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('shift_id')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time</label>
                                        <input type="time" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('start_time') ring-2 ring-red-500 @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                        @error('start_time')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time</label>
                                        <input type="time" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('end_time') ring-2 ring-red-500 @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                                        @error('end_time')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="hours_worked" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hours Worked</label>
                                        <input type="number" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('hours_worked') ring-2 ring-red-500 @enderror" id="hours_worked" name="hours_worked" value="{{ old('hours_worked') }}" required>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Total hours worked excluding breaks</p>
                                        @error('hours_worked')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="break_duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Break Duration (hours)</label>
                                        <input type="number" step="0.25" min="0" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('break_duration') ring-2 ring-red-500 @enderror" id="break_duration" name="break_duration" value="{{ old('break_duration', 0) }}" required>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Total break time in hours (e.g., 0.5 for 30 minutes)</p>
                                        @error('break_duration')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <label for="tasks_completed" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tasks Completed</label>
                                    <textarea class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('tasks_completed') ring-2 ring-red-500 @enderror" id="tasks_completed" name="tasks_completed" rows="4" placeholder="List the main tasks you completed during this time period">{{ old('tasks_completed') }}</textarea>
                                    @error('tasks_completed')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Additional Notes</label>
                                    <textarea class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('notes') ring-2 ring-red-500 @enderror" id="notes" name="notes" rows="3" placeholder="Any additional information about your work">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-between">
                                    <a href="{{ route('timesheets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                        </svg>
                                        Cancel
                                    </a>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                        </svg>
                                        Submit Timesheet
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Timesheet Guidelines</h3>
                            <ul class="list-disc pl-5 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <li>Enter the date and time period for which you are reporting your work hours.</li>
                                <li>If this timesheet is related to a specific shift, select it from the dropdown menu.</li>
                                <li>Hours worked should exclude any breaks taken during the work period.</li>
                                <li>Break duration should be entered in decimal hours (e.g., 0.5 for 30 minutes).</li>
                                <li>Provide a detailed list of tasks completed during this time period.</li>
                                <li>Submit your timesheet promptly at the end of each work period.</li>
                            </ul>
                        </div>
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
</x-app-layout>
