<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                Reports & Analytics
            </h2>
            <div class="flex space-x-4">
                <button @click="$dispatch('open-export-modal')" 
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    Export Reports
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Monthly Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <x-stats-card 
            title="Total Shifts" 
            :value="$stats['total_shifts']"
            comparison="{{ $stats['shift_growth'] }}%"
            :is-positive="$stats['shift_growth'] > 0"
            icon="calendar" />

        <x-stats-card 
            title="Completed Shifts" 
            :value="$stats['completed_shifts']"
            :percentage="($stats['completed_shifts'] / max($stats['total_shifts'], 1)) * 100"
            icon="check-circle" />

        <x-stats-card 
            title="Total Hours" 
            :value="$stats['total_hours']"
            suffix="hrs"
            icon="clock" />

        <x-stats-card 
            title="Cancellation Rate" 
            :value="$stats['cancellation_rate']"
            suffix="%"
            :is-positive="false"
            icon="x-circle" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Shift Trends Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                Shift Trends
            </h3>
            <canvas id="shiftTrendsChart" height="300"></canvas>
        </div>

        <!-- Staff Performance Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                Staff Performance
            </h3>
            <canvas id="staffPerformanceChart" height="300"></canvas>
        </div>
    </div>

    <!-- Location Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    Popular Locations
                </h3>
                <div class="relative h-[400px]">
                    <canvas id="locationChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Performing Staff -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                Top Performing Staff
            </h3>
            <div class="space-y-4">
                @foreach($staffPerformance as $staff)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="{{ $staff->profile_photo_url }}" 
                                 alt="{{ $staff->name }}"
                                 class="h-10 w-10 rounded-full">
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $staff->name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $staff->completed_shifts }} shifts completed
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ number_format($staff->completion_rate, 1) }}%
                            </p>
                            <p class="text-xs text-gray-500">
                                Completion Rate
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <x-modal name="export-report">
        <form action="{{ route('admin.reports.export') }}" method="POST" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                Export Report
            </h2>

            <div class="space-y-4">
                <div>
                    <label for="report_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Report Type
                    </label>
                    <select name="report_type" id="report_type" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="shifts">Shifts Report</option>
                        <option value="staff">Staff Performance</option>
                        <option value="locations">Location Analysis</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Start Date
                        </label>
                        <input type="date" name="start_date" id="start_date" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            End Date
                        </label>
                        <input type="date" name="end_date" id="end_date" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <x-button type="submit" variant="primary">
                        Generate Report
                    </x-button>
                </div>
            </div>
        </form>
    </x-modal>
</x-admin-layout>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Shift Trends Chart
    new Chart(document.getElementById('shiftTrendsChart'), {
        type: 'line',
        data: {
            labels: @json($shiftTrends->pluck('date')),
            datasets: [{
                label: 'Total Shifts',
                data: @json($shiftTrends->pluck('total')),
                borderColor: '#3b82f6',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            // ... other options
        }
    });

    // Staff Performance Chart
    new Chart(document.getElementById('staffPerformanceChart'), {
        type: 'bar',
        data: {
            labels: @json($staffPerformance->pluck('name')),
            datasets: [{
                label: 'Completed Shifts',
                data: @json($staffPerformance->pluck('completed_shifts')),
                backgroundColor: '#3b82f6'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            // ... other options
        }
    });

    // Location Chart
    new Chart(document.getElementById('locationChart'), {
        type: 'pie',
        data: {
            labels: @json($topLocations->pluck('location')),
            datasets: [{
                data: @json($topLocations->pluck('total')),
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
            // ... other options
        }
    });
});
</script>
@endpush