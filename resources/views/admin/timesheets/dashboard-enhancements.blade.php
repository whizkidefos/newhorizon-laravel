{{-- This file contains the new sections to be added to the admin timesheet dashboard --}}

{{-- Enhanced Filters Section --}}
<div class="mb-6 bg-white dark:bg-gray-700 shadow-md rounded-lg overflow-hidden">
    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
            </svg>
            Advanced Filters
        </h3>
    </div>
    <form action="{{ route('admin.timesheets.dashboard') }}" method="GET" class="p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Date Range (existing) --}}
            <div>
                <label for="date_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date Range</label>
                <select id="date_range" name="date_range" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" onchange="updateDateFields()">
                    <option value="this_month" {{ request('date_range', 'this_month') == 'this_month' ? 'selected' : '' }}>This Month</option>
                    <option value="last_month" {{ request('date_range') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                    <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>This Week</option>
                    <option value="last_week" {{ request('date_range') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                    <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="yesterday" {{ request('date_range') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                    <option value="this_year" {{ request('date_range') == 'this_year' ? 'selected' : '' }}>This Year</option>
                    <option value="custom" {{ request('date_range') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>
            
            {{-- Location Filter (new) --}}
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                <select id="location" name="location" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                    <option value="">All Locations</option>
                    @foreach($locations as $location)
                        <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- Department Filter (new) --}}
            <div>
                <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                <select id="department" name="department" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                    <option value="">All Departments</option>
                    @foreach($departments as $department)
                        <option value="{{ $department }}" {{ request('department') == $department ? 'selected' : '' }}>{{ $department }}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- Apply Button --}}
            <div class="flex items-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:bg-indigo-700 dark:focus:bg-indigo-600 active:bg-indigo-900 dark:active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 w-full justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Apply Filters
                </button>
            </div>
        </div>
        
        {{-- Custom Date Range Fields (existing) --}}
        <div id="custom-date-range" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 {{ request('date_range') == 'custom' ? '' : 'hidden' }}">
            <div id="custom-date-from">
                <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From Date</label>
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
            </div>
            <div id="custom-date-to">
                <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">To Date</label>
                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
            </div>
        </div>
    </form>
</div>

{{-- Additional Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    {{-- Total Hours Worked --}}
    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Total Hours Worked
                        </dt>
                        <dd>
                            <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ number_format($totalHoursWorked, 1) }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-800 px-5 py-3">
            <div class="text-sm">
                <span class="font-medium {{ $hoursChange >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    {{ $hoursChange >= 0 ? '+' : '' }}{{ $hoursChange }}%
                </span>
                <span class="text-gray-500 dark:text-gray-400">from previous period</span>
            </div>
        </div>
    </div>

    {{-- Average Hours Per Timesheet --}}
    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Avg Hours Per Timesheet
                        </dt>
                        <dd>
                            <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ $avgHoursPerTimesheet }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-800 px-5 py-3">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Based on {{ $totalTimesheets }} timesheets
            </div>
        </div>
    </div>
</div>

{{-- Top Employees Section --}}
<div class="mb-6 bg-white dark:bg-gray-700 shadow-md rounded-lg overflow-hidden">
    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
            </svg>
            Top Performing Employees
        </h3>
    </div>
    <div class="p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Employee</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hours Worked</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Timesheets</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Avg Hours/Timesheet</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($topEmployees as $employee)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($employee->user->profile_photo_path)
                                            <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $employee->user->profile_photo_path) }}" alt="{{ $employee->user->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                                <span class="text-lg font-medium text-indigo-800 dark:text-indigo-200">{{ substr($employee->user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $employee->user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $employee->user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ number_format($employee->total_hours, 1) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ $employee->timesheet_count }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ number_format($employee->total_hours / $employee->timesheet_count, 1) }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                No data available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Hours by Location Chart --}}
<div class="mb-6 bg-white dark:bg-gray-700 shadow-md rounded-lg overflow-hidden">
    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
            </svg>
            Hours by Location
        </h3>
    </div>
    <div class="p-4">
        <div class="h-80">
            <canvas id="hoursByLocationChart"></canvas>
        </div>
    </div>
</div>

{{-- Additional Chart Scripts --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update date fields based on date range selection
        function updateDateFields() {
            const dateRange = document.getElementById('date_range').value;
            const customDateRange = document.getElementById('custom-date-range');
            
            if (dateRange === 'custom') {
                customDateRange.classList.remove('hidden');
            } else {
                customDateRange.classList.add('hidden');
            }
        }
        
        document.getElementById('date_range').addEventListener('change', updateDateFields);
        
        // Hours by location chart
        const locationCtx = document.getElementById('hoursByLocationChart').getContext('2d');
        const locationChart = new Chart(locationCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($locationLabels) !!},
                datasets: [{
                    label: 'Hours Worked',
                    data: {!! json_encode($locationValues) !!},
                    backgroundColor: 'rgba(79, 70, 229, 0.6)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Hours'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Location'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endpush
