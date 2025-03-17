<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Export Timesheets') }}
            </h2>
            <div>
                <a href="{{ route('admin.timesheets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Timesheets') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('admin.timesheets.export.download') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-6">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h5 class="font-medium text-lg mb-4">Filter Timesheets</h5>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <div>
                                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee</label>
                                        <select id="user_id" name="user_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            <option value="">All Employees</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            <option value="">All Statuses</option>
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date From</label>
                                        <input type="date" id="date_from" name="date_from" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    </div>
                                    
                                    <div>
                                        <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date To</label>
                                        <input type="date" id="date_to" name="date_to" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    <h5 class="font-medium text-lg mb-4">Export Format</h5>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center">
                                            <input id="format_excel" name="format" type="radio" value="excel" checked class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="format_excel" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Excel (.xlsx)
                                            </label>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            <input id="format_csv" name="format" type="radio" value="csv" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="format_csv" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                CSV (.csv)
                                            </label>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            <input id="format_pdf" name="format" type="radio" value="pdf" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <label for="format_pdf" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                PDF (.pdf)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    <h5 class="font-medium text-lg mb-4">Columns to Include</h5>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <div class="flex items-center">
                                                <input id="include_all" type="checkbox" checked class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_all" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Select All
                                                </label>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <input id="include_id" name="columns[]" type="checkbox" value="id" checked class="column-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_id" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    ID
                                                </label>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <input id="include_employee" name="columns[]" type="checkbox" value="employee" checked class="column-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_employee" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Employee Name
                                                </label>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <input id="include_date" name="columns[]" type="checkbox" value="date" checked class="column-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_date" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Date
                                                </label>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <input id="include_start_time" name="columns[]" type="checkbox" value="start_time" checked class="column-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_start_time" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Start Time
                                                </label>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <input id="include_end_time" name="columns[]" type="checkbox" value="end_time" checked class="column-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_end_time" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    End Time
                                                </label>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <input id="include_hours_worked" name="columns[]" type="checkbox" value="hours_worked" checked class="column-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_hours_worked" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Hours Worked
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-2">
                                            <div class="flex items-center invisible">
                                                <input type="checkbox" class="h-4 w-4">
                                                <label class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    &nbsp;
                                                </label>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <input id="include_break_duration" name="columns[]" type="checkbox" value="break_duration" checked class="column-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_break_duration" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Break Duration
                                                </label>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <input id="include_status" name="columns[]" type="checkbox" value="status" checked class="column-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_status" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Status
                                                </label>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <input id="include_tasks" name="columns[]" type="checkbox" value="tasks_completed" checked class="column-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_tasks" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Tasks Completed
                                                </label>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <input id="include_notes" name="columns[]" type="checkbox" value="notes" checked class="column-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_notes" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Notes
                                                </label>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <input id="include_submitted_at" name="columns[]" type="checkbox" value="created_at" checked class="column-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_submitted_at" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Submitted At
                                                </label>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <input id="include_updated_at" name="columns[]" type="checkbox" value="updated_at" checked class="column-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="include_updated_at" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Updated At
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export Timesheets
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
            // Handle "Select All" checkbox
            const selectAllCheckbox = document.getElementById('include_all');
            const columnCheckboxes = document.querySelectorAll('.column-checkbox');
            
            selectAllCheckbox.addEventListener('change', function() {
                columnCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
            
            // Update "Select All" checkbox when individual checkboxes change
            columnCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(columnCheckboxes).every(cb => cb.checked);
                    const anyChecked = Array.from(columnCheckboxes).some(cb => cb.checked);
                    
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = !allChecked && anyChecked;
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
