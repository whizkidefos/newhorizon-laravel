<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Timesheets') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('timesheets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('New Timesheet') }}
                </a>
                <button id="toggleFilters" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    {{ __('Filters') }}
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Dashboard -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Hours This Month -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Hours This Month</h3>
                    </div>
                    <div class="p-6 flex items-center">
                        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalHoursThisMonth ?? 0, 1) }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Total hours worked</div>
                        </div>
                    </div>
                </div>
                
                <!-- Approval Rate -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Approval Rate</h3>
                    </div>
                    <div class="p-6 flex items-center">
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $approvalRate ?? 0 }}%</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Timesheet approval rate</div>
                        </div>
                    </div>
                </div>
                
                <!-- Pending Submissions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Pending Submissions</h3>
                    </div>
                    <div class="p-6 flex items-center">
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $pendingCount ?? 0 }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Awaiting approval</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Filter Section -->
            <div id="filterSection" class="mb-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hidden">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter Timesheets</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('timesheets.index') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Date Range Filter -->
                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From Date</label>
                                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>
                            
                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">To Date</label>
                                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>
                            
                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <a href="{{ route('timesheets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mr-2">
                                Reset
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:bg-indigo-700 dark:focus:bg-indigo-600 active:bg-indigo-900 dark:active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Timesheets Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Shift</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hours</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Submitted</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($timesheets as $timesheet)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $timesheet->date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            @if($timesheet->shift)
                                                <span class="font-medium text-gray-900 dark:text-white">{{ $timesheet->shift->location }}</span>
                                                <span class="block text-xs text-gray-500 dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($timesheet->start_time)->format('h:i A') }} - 
                                                    {{ \Carbon\Carbon::parse($timesheet->end_time)->format('h:i A') }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">No shift attached</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ number_format($timesheet->hours_worked, 2) }}
                                        </td>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $timesheet->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('timesheets.show', $timesheet) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                    View
                                                </a>
                                                @if($timesheet->status == 'pending')
                                                    <a href="{{ route('timesheets.edit', $timesheet) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('timesheets.destroy', $timesheet) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this timesheet?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            No timesheets found. <a href="{{ route('timesheets.create') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Create one now</a>.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $timesheets->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle filter section
        const toggleFiltersBtn = document.getElementById('toggleFilters');
        const filterSection = document.getElementById('filterSection');
        
        toggleFiltersBtn.addEventListener('click', function() {
            filterSection.classList.toggle('hidden');
        });
        
        // Show filters if any are active
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('date_from') || urlParams.has('date_to') || urlParams.has('status')) {
            filterSection.classList.remove('hidden');
        }
    });
</script>
@endpush
</x-app-layout>
