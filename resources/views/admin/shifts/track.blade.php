<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                Track Shift - {{ $shift->user->full_name }}
            </h2>
            <div class="flex items-center space-x-2">
                <x-shift-status :status="$shift->status" />
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Started: {{ $shift->checkin_time->format('H:i') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Map Section -->
        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div id="map" class="h-[600px] rounded-lg"></div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="space-y-6">
            <!-- Staff Info -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center mb-4">
                    <img src="{{ $shift->user->profile_photo_url }}" 
                         alt="{{ $shift->user->full_name }}"
                         class="h-12 w-12 rounded-full object-cover">
                    <div class="ml-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $shift->user->full_name }}
                        </h4>
                        <p class="text-sm text-gray-500">
                            {{ $shift->location }}
                        </p>
                    </div>
                </div>

                <dl class="grid grid-cols-1 gap-4 mt-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white" id="lastUpdated">
                            Loading...
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white" id="duration">
                            Calculating...
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Location History -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    Location History
                </h3>
                <div class="space-y-4" id="locationHistory">
                    <!-- Location history will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}"></script>
<script>
let map;
let marker;
let locationHistory = [];
const shiftId = {{ $shift->id }};

function initMap() {
    const defaultLocation = { 
        lat: {{ $shift->last_tracked_location['latitude'] ?? 53.1 }}, 
        lng: {{ $shift->last_tracked_location['longitude'] ?? -3 }} 
    };

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: defaultLocation,
        styles: isDarkMode() ? darkMapStyle : []
    });

    marker = new google.maps.Marker({
        position: defaultLocation,
        map: map,
        title: '{{ $shift->user->full_name }}'
    });

    // Start real-time tracking
    initializeTracking();
}

function initializeTracking() {
    Echo.private(`shifts.${shiftId}`)
        .listen('LocationUpdated', (e) => {
            const newPosition = {
                lat: parseFloat(e.latitude),
                lng: parseFloat(e.longitude)
            };

            // Update marker position
            marker.setPosition(newPosition);
            map.panTo(newPosition);

            // Update location history
            updateLocationHistory({
                position: newPosition,
                timestamp: new Date()
            });

            // Update last updated time
            document.getElementById('lastUpdated').textContent = 'Just now';
        });

    // Update duration every minute
    setInterval(updateDuration, 60000);
    updateDuration();
}

function updateLocationHistory(location) {
    locationHistory.unshift(location);
    
    // Keep only last 10 locations
    if (locationHistory.length > 10) {
        locationHistory.pop();
    }

    // Update UI
    const container = document.getElementById('locationHistory');
    container.innerHTML = locationHistory.map(loc => `
        <div class="flex justify-between items-center text-sm">
            <span class="text-gray-600 dark:text-gray-400">
                ${formatTime(loc.timestamp)}
            </span>
            <span class="text-gray-900 dark:text-white">
                ${formatCoordinates(loc.position)}
            </span>
        </div>
    `).join('');
}

function updateDuration() {
    const startTime = new Date('{{ $shift->checkin_time }}');
    const duration = Math.floor((new Date() - startTime) / 1000 / 60); // in minutes
    const hours = Math.floor(duration / 60);
    const minutes = duration % 60;
    
    document.getElementById('duration').textContent = 
        `${hours}h ${minutes}m`;
}

function formatTime(date) {
    return new Date(date).toLocaleTimeString('en-GB', {
        hour: '2-digit',
        minute: '2-digit'
    });
}

function formatCoordinates(pos) {
    return `${pos.lat.toFixed(6)}, ${pos.lng.toFixed(6)}`;
}

document.addEventListener('DOMContentLoaded', initMap);
</script>
@endpush