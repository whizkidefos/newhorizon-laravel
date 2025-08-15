<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Timesheet Dashboard') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.timesheets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    {{ __('View All Timesheets') }}
                </a>
                <a href="{{ route('admin.timesheets.export') }}" class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 dark:hover:bg-green-600 focus:bg-green-700 dark:focus:bg-green-600 active:bg-green-900 dark:active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    {{ __('Export Reports') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Enhanced Filters Section -->
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

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Timesheets -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Total Timesheets
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ $totalTimesheets }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.timesheets.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                View all
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pending Timesheets -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Pending Timesheets
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ $pendingTimesheets }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.timesheets.index', ['status' => 'pending']) }}" class="font-medium text-yellow-600 hover:text-yellow-500 dark:text-yellow-400 dark:hover:text-yellow-300">
                                View pending
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Approved Timesheets -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Approved
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $approvedTimesheets }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.timesheets.index', ['status' => 'approved']) }}" class="font-medium text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300">
                                View approved
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Rejected Timesheets -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Rejected
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $rejectedTimesheets }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.timesheets.index', ['status' => 'rejected']) }}" class="font-medium text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300">
                                View rejected
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Employees Section -->
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

            <!-- Charts and Tables Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Timesheet Status Chart -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg">
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Timesheet Status Distribution</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="timesheetStatusChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Hours Worked by Day Chart -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg">
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Hours Worked by Day</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="hoursWorkedChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Hours by Location Chart -->
            <div class="mb-6 bg-white dark:bg-gray-700 shadow-md rounded-lg overflow-hidden">
                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" />
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

            <!-- Recent Timesheets Table -->
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg">
                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Recent Timesheets</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Employee</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hours</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($recentTimesheets as $timesheet)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <a href="{{ route('admin.users.show', $timesheet->user_id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                {{ $timesheet->user->first_name }} {{ $timesheet->user->last_name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $timesheet->date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ number_format($timesheet->hours_worked, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($timesheet->status == 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-200 dark:text-yellow-900">
                                                    Pending
                                                </span>
                                            @elseif($timesheet->status == 'approved')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900">
                                                    Approved
                                                </span>
                                            @elseif($timesheet->status == 'rejected')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-200 dark:text-red-900">
                                                    Rejected
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.timesheets.show', $timesheet) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                                View
                                            </a>
                                            @if($timesheet->status == 'pending')
                                                <form action="{{ route('admin.timesheets.approve', $timesheet) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3">
                                                        Approve
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">No recent timesheets found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('admin.timesheets.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                            View all timesheets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            
            // Initialize charts
            const statusCtx = document.getElementById('timesheetStatusChart').getContext('2d');
            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Approved', 'Rejected'],
                    datasets: [{
                        data: [{{ $pendingTimesheets }}, {{ $approvedTimesheets }}, {{ $rejectedTimesheets }}],
                        backgroundColor: [
                            'rgba(255, 193, 7, 0.8)',
                            'rgba(40, 167, 69, 0.8)',
                            'rgba(220, 53, 69, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 193, 7, 1)',
                            'rgba(40, 167, 69, 1)',
                            'rgba(220, 53, 69, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: false,
                            text: 'Timesheet Status Distribution'
                        }
                    }
                }
            });
            
            // Hours worked by day chart
            const hoursCtx = document.getElementById('hoursWorkedChart').getContext('2d');
            const hoursChart = new Chart(hoursCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($hoursByDayLabels) !!},
                    datasets: [{
                        label: 'Hours Worked',
                        data: {!! json_encode($hoursByDayValues) !!},
                        backgroundColor: 'rgba(79, 70, 229, 0.6)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
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
                                text: 'Date'
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
            
            // Hours by location chart
            const locationCtx = document.getElementById('hoursByLocationChart').getContext('2d');
            const locationChart = new Chart(locationCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($locationLabels) !!},
                    datasets: [{
                        label: 'Hours Worked',
                        data: {!! json_encode($locationValues) !!},
                        backgroundColor: 'rgba(6, 182, 212, 0.6)',
                        borderColor: 'rgba(6, 182, 212, 1)',
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
</x-app-layout>
