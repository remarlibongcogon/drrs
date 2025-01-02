document.addEventListener('DOMContentLoaded', function () {

    // document.getElementById('exactLocationBtn').addEventListener('click', getUserCoordinates);
    document.getElementById('exactLocationBtn').addEventListener('click', function () {
        getUserCoordinates();
        alert('Your current location has been automatically pinned.');
    });

    const mapModal = document.getElementById('mapModal');
    mapModal.addEventListener('shown.bs.modal', function () {
        initializeHazardMapPin('map', 'latitude', 'longitude');
    });
});


function fallbackGeolocation() {
    fetch('http://ip-api.com/json/')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            document.getElementById('latitude').value = data.lat;
            document.getElementById('longitude').value = data.lon;
          
        })
        .catch(err => {
            alert("Fallback geolocation failed.");
            console.error(err);
        });
}

function getUserCoordinates() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {

                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                console.log(position.coords);
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

            },
            function(error) {
                fallbackGeolocation();
            },
            {
                enableHighAccuracy: true,  // Use GPS for higher accuracy
                maximumAge: 0            
            }
        );
    } else {
     
        alert("Geolocation is not supported by this browser.");
    }
}

// Function to initialize the map
function initializeHazardMapPin(mapContainerId, latInputId, lngInputId) {
    const map = L.map(mapContainerId).setView([10.728, 123.826], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    let marker = null;

    // Add marker on map click
    map.on('click', function (e) {
        const latLng = e.latlng;

        // Remove existing marker
        if (marker) {
            map.removeLayer(marker);
        }

        // Place new marker
        marker = L.marker(latLng).addTo(map);

        // Update hidden inputs
        document.getElementById(latInputId).value = latLng.lat.toFixed(5);
        document.getElementById(lngInputId).value = latLng.lng.toFixed(5);

        // Bind a popup with the coordinates
        marker.bindPopup(`Coordinates: ${latLng.lat.toFixed(5)}, ${latLng.lng.toFixed(5)}`).openPopup();
    });
}
