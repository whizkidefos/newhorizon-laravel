<x-admin-layout>
    @section('title', 'Export Complaints')
    @section('meta_description', 'Export your complaints data in CSV format')
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                {{ __('Export Complaints') }}
            </h2>
            <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Complaints') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-900/20 dark:text-green-200" role="alert">
                            <p class="font-bold">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-900/20 dark:text-red-300" role="alert">
                            <p class="font-bold">Error</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('admin.complaints.export.download') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-6">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Filter Options</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee</label>
                                        <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="">All Employees</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                        <select id="status" name="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="">All Statuses</option>
                                            <option value="open">Open</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="resolved">Resolved</option>
                                            <option value="closed">Closed</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="severity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Severity</label>
                                        <select id="severity" name="severity" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="">All Severities</option>
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                            <option value="critical">Critical</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="date_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date Range</label>
                                        <select id="date_range" name="date_range" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="all">All Time</option>
                                            <option value="this_week">This Week</option>
                                            <option value="last_week">Last Week</option>
                                            <option value="this_month">This Month</option>
                                            <option value="last_month">Last Month</option>
                                            <option value="custom">Custom Range</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4" id="custom_date_range" style="display: none;">
                                    <div>
                                        <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date From</label>
                                        <input type="date" id="date_from" name="date_from" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    </div>
                                    <div>
                                        <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date To</label>
                                        <input type="date" id="date_to" name="date_to" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Export Format</h3>
                                </div>
                                <div class="p-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Format</label>
                                        <div class="flex flex-wrap gap-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="format" value="csv" checked class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                <span class="ml-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    CSV
                                                </span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="format" value="pdf" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                <span class="ml-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                    PDF
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Columns to Include</h3>
                                </div>
                                <div class="p-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="inline-flex items-center mb-3">
                                                <input type="checkbox" id="include_all" checked class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                <span class="ml-2 font-medium">Select All</span>
                                            </label>
                                            <div class="space-y-2">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="columns[]" id="col_id" value="id" checked class="column-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                    <span class="ml-2">ID</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="columns[]" id="col_employee" value="employee" checked class="column-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                    <span class="ml-2">Employee</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="columns[]" id="col_title" value="title" checked class="column-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                    <span class="ml-2">Title</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="columns[]" id="col_description" value="description" checked class="column-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                    <span class="ml-2">Description</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="columns[]" id="col_status" value="status" checked class="column-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                    <span class="ml-2">Status</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="space-y-2 mt-8">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="columns[]" id="col_severity" value="severity" checked class="column-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                    <span class="ml-2">Severity</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="columns[]" id="col_created_at" value="created_at" checked class="column-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                    <span class="ml-2">Created Date</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="columns[]" id="col_updated_at" value="updated_at" checked class="column-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                    <span class="ml-2">Updated Date</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="columns[]" id="col_resolved_at" value="resolved_at" checked class="column-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                    <span class="ml-2">Resolved Date</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="columns[]" id="col_resolution_notes" value="resolution_notes" checked class="column-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                                    <span class="ml-2">Resolution Notes</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export Complaints
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
            // Date range toggle
            const dateRangeSelect = document.getElementById('date_range');
            const customDateRange = document.getElementById('custom_date_range');
            
            dateRangeSelect.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customDateRange.style.display = 'grid';
                } else {
                    customDateRange.style.display = 'none';
                }
            });
            
            // Select all columns toggle
            const includeAllCheckbox = document.getElementById('include_all');
            const columnCheckboxes = document.querySelectorAll('.column-checkbox');
            
            includeAllCheckbox.addEventListener('change', function() {
                columnCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
            
            // Update "Select All" state based on individual checkboxes
            columnCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(columnCheckboxes).every(cb => cb.checked);
                    includeAllCheckbox.checked = allChecked;
                });
            });
        });
    </script>
    @endpush
</x-admin-layout>
