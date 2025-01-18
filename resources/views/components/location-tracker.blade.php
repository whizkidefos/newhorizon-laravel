<div 
    x-data="locationTracker()"
    x-init="initializeTracker"
    class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
    
    <div id="map" class="h-96 w-full rounded-lg"></div>

    <script>
        function locationTracker() {
            return {
                map: null,
                marker: null,
                watchId: null,

                initializeTracker() {
                    // Initialize Google Maps
                    this.map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 15,
                        center: { lat: {{ $shift->last_tracked_location['latitude'] ?? 53.1 }}, 
                                lng: {{ $shift->last_tracked_location['longitude'] ?? -3 }} }
                    });

                    // Initialize marker
                    this.marker = new google.maps.Marker({
                        map: this.map,
                        position: this.map.getCenter()
                    });

                    // Set up real-time updates
                    Echo.private('shifts')
                        .listen('LocationUpdated', (e) => {
                            if (e.shiftId === {{ $shift->id }}) {
                                const newPosition = new google.maps.LatLng(
                                    e.location.latitude,
                                    e.location.longitude
                                );
                                this.marker.setPosition(newPosition);
                                this.map.panTo(newPosition);
                            }
                        });
                }
            }
        }
    </script>
</div>