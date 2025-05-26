<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shift Completed - Next Steps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-900 dark:text-green-200 mb-6" role="alert">
                        <p class="font-bold">Success</p>
                        <p>You have successfully checked out from your shift.</p>
                    </div>

                    <h3 class="text-lg font-medium mb-4">Shift Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="mb-2"><strong>Date:</strong> {{ $shift->start_datetime->format('M d, Y') }}</p>
                            <p class="mb-2"><strong>Location:</strong> {{ $shift->location }}</p>
                        </div>
                        <div>
                            <p class="mb-2"><strong>Check-in Time:</strong> {{ \Carbon\Carbon::parse($shift->checked_in_at)->format('h:i A') }}</p>
                            <p class="mb-2"><strong>Check-out Time:</strong> {{ \Carbon\Carbon::parse($shift->checked_out_at)->format('h:i A') }}</p>
                            <p class="mb-2"><strong>Duration:</strong> {{ \Carbon\Carbon::parse($shift->checked_in_at)->diffForHumans(\Carbon\Carbon::parse($shift->checked_out_at), true) }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden">
                            <div class="bg-green-600 px-4 py-3">
                                <h3 class="text-lg font-medium text-white">Submit Timesheet</h3>
                            </div>
                            <div class="p-6">
                                <p class="mb-4 text-gray-700 dark:text-gray-300">Submit your timesheet for this shift to record your hours worked and get paid.</p>
                                
                                <form action="{{ route('shifts.quick-timesheet', $shift) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="break_duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Break Duration (hours)</label>
                                        <input type="number" class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                            id="break_duration" name="break_duration" step="0.25" min="0" value="0" required>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter your total break time in hours (e.g., 0.5 for 30 minutes)</p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="tasks_completed" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tasks Completed</label>
                                        <textarea class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                            id="tasks_completed" name="tasks_completed" rows="3" placeholder="List the main tasks you completed during this shift"></textarea>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Additional Notes</label>
                                        <textarea class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                            id="notes" name="notes" rows="3" placeholder="Any additional information about your shift"></textarea>
                                    </div>
                                    
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
                                        Submit Timesheet
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden">
                            <div class="bg-yellow-600 px-4 py-3">
                                <h3 class="text-lg font-medium text-white">Report an Issue</h3>
                            </div>
                            <div class="p-6">
                                <p class="mb-4 text-gray-700 dark:text-gray-300">If you experienced any issues during your shift, you can submit a quick complaint below or file a detailed report.</p>
                                
                                <!-- Quick Complaint Form -->
                                <form action="{{ route('complaints.quick-submit', $shift) }}" method="POST" class="mb-6">
                                    @csrf
                                    <input type="hidden" name="shift_id" value="{{ $shift->id }}">
                                    
                                    <div class="mb-4">
                                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Issue Title</label>
                                        <input type="text" class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                            id="title" name="title" required placeholder="Brief description of the issue">
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                        <textarea class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                            id="description" name="description" rows="3" required placeholder="Describe what happened"></textarea>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="severity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Severity</label>
                                        <select id="severity" name="severity" class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                            <option value="low">Low - Minor issue</option>
                                            <option value="medium" selected>Medium - Moderate concern</option>
                                            <option value="high">High - Serious problem</option>
                                            <option value="critical">Critical - Urgent attention needed</option>
                                        </select>
                                    </div>
                                    
                                    <button type="submit" class="inline-flex items-center justify-center w-full px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-800 focus:outline-none focus:border-yellow-800 focus:ring focus:ring-yellow-300 disabled:opacity-25 transition">
                                        Submit Quick Complaint
                                    </button>
                                </form>
                                
                                <div class="text-center mb-4">
                                    <span class="text-gray-500 dark:text-gray-400">OR</span>
                                </div>
                                
                                <div class="mb-4">
                                    <a href="{{ route('complaints.create-from-shift', $shift) }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                        File Detailed Complaint
                                    </a>
                                </div>
                                
                                <div>
                                    <p class="font-medium mb-2 text-gray-700 dark:text-gray-300">When to file a complaint:</p>
                                    <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300">
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
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('shifts.my') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                            Back to My Shifts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
