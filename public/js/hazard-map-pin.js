function initializeHazardMapPin(mapContainerId, coordinatesInputId) {
    // Initialize the map
    var map = L.map(mapContainerId).setView([10.728, 123.826], 16);  // Default coordinates and zoom level

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {  
    }).addTo(map);

    var marker = null;

    map.on('click', function(e) {
        var latLng = e.latlng;  // Get the clicked coordinates (latitude, longitude)

        // remove existing markers
        if (marker) {
            map.removeLayer(marker);
        }

        // Place a new marker at the clicked location
        marker = L.marker(latLng).addTo(map);

        // Store the coordinates in the input field
        document.getElementById(coordinatesInputId).value = JSON.stringify([latLng.lat, latLng.lng]);

        marker.bindPopup("Shelter Coordinates: " + latLng.lat.toFixed(5) + ", " + latLng.lng.toFixed(5)).openPopup();
    });
}

window.initializeHazardMapPin = initializeHazardMapPin;
