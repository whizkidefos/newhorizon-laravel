<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stats Cards -->
    <x-stats-card 
        title="Active Shifts"
        :value="$activeShifts"
        icon="calendar" />

    <x-stats-card 
        title="Available Staff"
        :value="$availableStaff"
        icon="users" />

    <x-stats-card 
        title="Pending Verifications"
        :value="$pendingVerifications"
        icon="clipboard-check" />

    <x-stats-card 
        title="Monthly Revenue"
        :value="$monthlyRevenue"
        prefix="£"
        icon="currency-pound" />
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Activity -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Activity</h3>
        <div class="space-y-4">
            @foreach($recentActivities as $activity)
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-500">
                            <!-- Activity Icon -->
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ $activity->description }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $activity->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Active Staff Map -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Active Staff Locations</h3>
        <div id="staff-map" class="h-96 rounded-lg"></div>
    </div>
</div>