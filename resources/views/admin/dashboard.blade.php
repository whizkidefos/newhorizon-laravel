<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Total Users Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</div>
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalUsers }}</div>
                                <div class="text-sm text-green-600">+{{ $newUsersThisMonth }} this month</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Stats Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Documents</div>
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalDocuments }}</div>
                                <div class="text-sm text-yellow-600">{{ $pendingDocuments }} pending verification</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timesheet Stats Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Timesheets</div>
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalTimesheets }}</div>
                                <div class="text-sm text-yellow-600">{{ $pendingTimesheets }} pending approval</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Complaint Stats Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Complaints</div>
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalComplaints }}</div>
                                <div class="text-sm text-red-600">{{ $openComplaints + $inProgressComplaints }} need attention</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Verification Stats Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Verification Status</div>
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $verifiedUsers }}/{{ $totalUsers }}</div>
                                <div class="text-sm text-red-600">{{ $unverifiedUsers }} unverified users</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Shifts Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Upcoming Shifts</div>
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $upcomingShifts }}</div>
                                <div class="text-sm text-blue-600">Next 7 days</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- User Registration Trend -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">User Registration Trend</h3>
                    <div class="h-64" x-data="{
                        init() {
                            const labels = {{ Js::from($userTrend->pluck('month')) }};
                            const data = {{ Js::from($userTrend->pluck('total')) }};
                            
                            new Chart(this.$refs.canvas, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'New Users',
                                        data: data,
                                        borderColor: '#3b82f6',
                                        tension: 0.3,
                                        fill: true,
                                        backgroundColor: 'rgba(59, 130, 246, 0.1)'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                stepSize: 1
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    }">
                        <canvas x-ref="canvas"></canvas>
                    </div>
                </div>

                <!-- Document Types Distribution -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Document Types Distribution</h3>
                    <div class="h-64" x-data="{
                        init() {
                            const labels = {{ Js::from($documentTypes->pluck('type')) }};
                            const data = {{ Js::from($documentTypes->pluck('total')) }};
                            
                            new Chart(this.$refs.canvas, {
                                type: 'doughnut',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        data: data,
                                        backgroundColor: [
                                            '#3b82f6',
                                            '#10b981',
                                            '#f59e0b',
                                            '#ef4444',
                                            '#8b5cf6'
                                        ]
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'right'
                                        }
                                    }
                                }
                            });
                        }
                    }">
                        <canvas x-ref="canvas"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Users Needing Attention -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Users Needing Attention</h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($usersNeedingAttention as $user)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $user->full_name }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        @if(!$user->email_verified_at)
                                            <span class="text-red-600">Email not verified</span>
                                        @endif
                                        @if(!$user->documents->where('type', 'Right to Work')->where('verified', true)->count())
                                            <span class="text-yellow-600">Right to Work document pending</span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    View Profile
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-4 text-gray-500 dark:text-gray-400">
                            No users need attention at this time
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Activities</h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentActivities as $activity)
                        <div class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($activity->user && $activity->user->profile_photo_path)
                                        <img class="h-8 w-8 rounded-full" src="{{ Storage::url($activity->user->profile_photo_path) }}" alt="">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                            <span class="text-white text-sm font-medium">
                                                {{ $activity->user ? substr($activity->user->first_name, 0, 1) . substr($activity->user->last_name, 0, 1) : 'NA' }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $activity->description }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-4 text-gray-500 dark:text-gray-400">
                            No recent activities
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Timesheet and Complaint Status -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <!-- Pending Timesheets -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pending Timesheets</h3>
                        <a href="{{ route('admin.timesheets.index') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">View All</a>
                    </div>
                    <div class="p-6">
                        @if($pendingTimesheets > 0)
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Total Pending</div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $pendingTimesheets }}</div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Approved</div>
                                    <div class="text-sm font-medium text-green-600">{{ $approvedTimesheets }}</div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Rejected</div>
                                    <div class="text-sm font-medium text-red-600">{{ $rejectedTimesheets }}</div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('admin.timesheets.export') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Export Timesheets
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-gray-500 dark:text-gray-400">No pending timesheets</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Open Complaints -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Complaints Status</h3>
                        <a href="{{ route('admin.complaints.index') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">View All</a>
                    </div>
                    <div class="p-6">
                        @if($totalComplaints > 0)
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Open</div>
                                    <div class="text-sm font-medium text-red-600">{{ $openComplaints }}</div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">In Progress</div>
                                    <div class="text-sm font-medium text-yellow-600">{{ $inProgressComplaints }}</div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Resolved</div>
                                    <div class="text-sm font-medium text-green-600">{{ $resolvedComplaints }}</div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Closed</div>
                                    <div class="text-sm font-medium text-gray-600">{{ $closedComplaints }}</div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('admin.complaints.export') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Export Complaints
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-gray-500 dark:text-gray-400">No complaints recorded</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
</x-admin-layout>