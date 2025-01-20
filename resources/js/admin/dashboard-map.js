function initMap() {
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: { lat: 53.1, lng: -3 }, // Center on North Wales
    });

    // Add markers for active users
    activeUsers.forEach(user => {
        if (user.currentShift && user.currentShift.last_tracked_location) {
            const marker = new google.maps.Marker({
                position: {
                    lat: user.currentShift.last_tracked_location.latitude,
                    lng: user.currentShift.last_tracked_location.longitude
                },
                map: map,
                title: `${user.first_name} ${user.last_name}`
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div class="p-2">
                        <h3 class="font-semibold">${user.first_name} ${user.last_name}</h3>
                        <p class="text-sm">Location: ${user.currentShift.location}</p>
                        <p class="text-sm">Since: ${new Date(user.currentShift.start_datetime).toLocaleTimeString()}</p>
                    </div>
                `
            });

            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });
        }
    });
}