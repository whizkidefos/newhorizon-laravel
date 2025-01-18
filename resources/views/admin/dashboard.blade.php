@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Dashboard Overview</h1>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <!-- User icon -->
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                Total Users
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ $stats['total_users'] }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Shifts -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <!-- Similar structure for active shifts -->
        </div>

        <!-- Total Courses -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <!-- Similar structure for total courses -->
        </div>

        <!-- Pending Verifications -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <!-- Similar structure for pending verifications -->
        </div>
    </div>

    <!-- Recent Activity and User Location -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Activity</h3>
                <div class="flow-root">
                    <ul class="-mb-8">
                        @foreach($recentActivities as $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $activity->description }}
                                                </p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-400">
                                                {{ $activity->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Active Users Map -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Active Users Location</h3>
                <div id="map" class="h-96 rounded-lg"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
<script>
    // Initialize map and plot user locations
    function initMap() {
        const map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 53.1, lng: -3 }, // Center on North Wales
            zoom: 8
        });

        // Plot active users
        @foreach($activeUsers as $user)
            new google.maps.Marker({
                position: { 
                    lat: {{ $user->last_tracked_location['latitude'] }}, 
                    lng: {{ $user->last_tracked_location['longitude'] }} 
                },
                map: map,
                title: "{{ $user->name }}"
            });
        @endforeach
    }

    document.addEventListener('DOMContentLoaded', initMap);
</script>
@endpush
@endsection