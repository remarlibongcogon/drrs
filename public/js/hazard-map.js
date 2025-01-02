function initializeHazardMap(hazardData, shelterData, incidentData, mapContainerId) {
    var map = L.map(mapContainerId).setView([10.728, 123.826], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
    }).addTo(map);

    map.addControl(new L.Control.FullScreen());

    var hazardLayers = [];
    var shelterLayers = [];
    var incidentLayers = [];
    
    // store original names
    var originalPopups = new Map();

    function clearAllPopups() {
        hazardLayers.forEach(layer => layer.closePopup());
        shelterLayers.forEach(layer => layer.closePopup());
        incidentLayers.forEach(layer => layer.closePopup());
    }

    function createPopupAndOpen(layer, content) {
        var popup = L.popup({
            autoClose: false,
            closeOnClick: false
        })
        .setContent(content);
        
        layer.bindPopup(popup);
        setTimeout(() => layer.openPopup(), 100);
    }

    function calculateDistance(point1, point2) {
        return L.latLng(point1[0], point1[1]).distanceTo(L.latLng(point2[0], point2[1]));
    }

    function findNearbyShelters(hazardCoordinates, shelterData) {
        const MAX_DISTANCE = 500;
        let nearbyShelters = [];

        shelterData.forEach(function(shelter) {
            try {
                var shelterCoordinatesString = shelter.shelterCoordinates;
                if (shelterCoordinatesString.startsWith('"') && shelterCoordinatesString.endsWith('"')) {
                    shelterCoordinatesString = shelterCoordinatesString.slice(1, -1);
                }
                var shelterCoordinates = JSON.parse(shelterCoordinatesString);

                if (Array.isArray(shelterCoordinates) && shelterCoordinates.length === 2) {
                    let minDistance = Infinity;
                    hazardCoordinates.forEach(point => {
                        const distance = calculateDistance(point, shelterCoordinates);
                        minDistance = Math.min(minDistance, distance);
                    });

                    if (minDistance <= MAX_DISTANCE) {
                        nearbyShelters.push({
                            shelter: shelter,
                            distance: (minDistance / 1000).toFixed(2)
                        });
                    }
                }
            } catch (e) {
                console.error('Error processing shelter:', shelter.shelterName, e);
            }
        });

        return nearbyShelters.sort((a, b) => parseFloat(a.distance) - parseFloat(b.distance));
    }

    function restoreOriginalPopups() {
        originalPopups.forEach((popup, layer) => {
            layer.bindPopup(popup);
        });
    }

    let markersToOpen = [];

    hazardData.forEach(function (hazard) {
        try {
            var coordinatesString = hazard.coordinates;
            if (coordinatesString.startsWith('"') && coordinatesString.endsWith('"')) {
                coordinatesString = coordinatesString.slice(1, -1);
            }

            var coordinates = JSON.parse(coordinatesString);

            if (Array.isArray(coordinates) && coordinates.length > 0 && Array.isArray(coordinates[0])) {
                var hazardPolygon = L.polygon(coordinates, {
                    color: 'red',
                    fillColor: 'red',
                    fillOpacity: 0.5
                }).addTo(map);

                var originalPopup = L.popup({
                    autoClose: false,
                    closeOnClick: false
                })
                .setContent(`Hazard: ${hazard.hazardName}`);
                
                hazardPolygon.bindPopup(originalPopup);
                originalPopups.set(hazardPolygon, originalPopup);
                markersToOpen.push(hazardPolygon);

                hazardPolygon.on('click', function() {
                    hazardLayers.forEach(layer => map.removeLayer(layer));
                    shelterLayers.forEach(layer => map.removeLayer(layer));

                    hazardPolygon.addTo(map);
                    createPopupAndOpen(hazardPolygon, `Hazard: ${hazard.hazardName}`);

                    const nearbyShelters = findNearbyShelters(coordinates, shelterData);
                    
                    if (nearbyShelters.length > 0) {
                        nearbyShelters.forEach(nearbyInfo => {
                            try {
                                var shelterCoords = JSON.parse(
                                    nearbyInfo.shelter.shelterCoordinates.replace(/^"|"$/g, '')
                                );
                                var shelterMarker = L.marker(shelterCoords).addTo(map);
                                createPopupAndOpen(shelterMarker, 
                                    `
                                    <div class="text-center">
                                        <h6>Nearby Shelter: ${nearbyInfo.shelter.shelterName}</h6>
                                        ${nearbyInfo.shelter.shelterImagePath ? 
                                            `<img src="/storage/${nearbyInfo.shelter.shelterImagePath}" 
                                                 alt="${nearbyInfo.shelter.shelterName}" 
                                                 class="img-fluid" 
                                                 style="max-width: 200px; max-height: 200px; object-fit: cover;">` 
                                            : ''}
                                        <p>Distance: ${nearbyInfo.distance} km</p>
                                    </div>
                                    `
                                );
                                shelterLayers.push(shelterMarker);
                            } catch (e) {
                                console.error('Error creating shelter marker:', e);
                            }
                        });
                    }
                });

                hazardLayers.push(hazardPolygon);
            }
        } catch (e) {
            console.error('Error parsing coordinates for hazard:', hazard.hazardName, e);
        }
    });

    shelterData.forEach(function (shelter) {
        try {
            var coordinatesString = shelter.shelterCoordinates;
            if (coordinatesString.startsWith('"') && coordinatesString.endsWith('"')) {
                coordinatesString = coordinatesString.slice(1, -1);
            }

            var coordinates = JSON.parse(coordinatesString);

            if (Array.isArray(coordinates) && coordinates.length === 2) {
                var shelterMarker = L.marker([coordinates[0], coordinates[1]]).addTo(map);
                var originalPopup = L.popup({
                    autoClose: false,
                    closeOnClick: false
                })
                .setContent(`
                    <div class="text-center">
                        <h6>${shelter.shelterName}</h6>
                        ${shelter.shelterImagePath ? 
                            `<img src="/storage/${shelter.shelterImagePath}" 
                                 alt="${shelter.shelterName}" 
                                 class="img-fluid" 
                                 style="max-width: 160px; max-height: 160px; object-fit: cover;">` 
                            : ''}
                    </div>
                `);
                
                shelterMarker.bindPopup(originalPopup);
                originalPopups.set(shelterMarker, originalPopup);
                markersToOpen.push(shelterMarker);
                shelterLayers.push(shelterMarker);
            }
        } catch (e) {
            console.error('Error parsing coordinates for shelter:', shelter.shelterName, e);
        }
    });

    incidentData.forEach(function (incident) {
        try {
            
            var coordinatesString = incident;
            var redMarkerIcon = L.divIcon({
                className: 'custom-div-icon', 
                html: `
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="50" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 4.97 5 11 7 13 2-2 7-8.03 7-13 0-3.87-3.13-7-7-7z"></path>
                        <circle cx="12" cy="9" r="2.5"></circle>
                    </svg>
                `,
                iconSize: [30, 50],
                iconAnchor: [15, 50],
                popupAnchor: [0, -50]
            });
            
            if (coordinatesString.startsWith('"') && coordinatesString.endsWith('"')) {
                coordinatesString = coordinatesString.slice(1, -1);
            }
        
            var coordinates = JSON.parse(coordinatesString);

            if (Array.isArray(coordinates) && coordinates.length === 2) {
                var incidentMarker = L.marker([coordinates[0], coordinates[1]], { icon: redMarkerIcon }).addTo(map);
                var originalPopup = L.popup({
                    autoClose: false,
                    closeOnClick: false
                })
                .setContent(`
                    <div class="text-center">
                        <h6>Accident Prone Area</h6>
                    </div>
                `);
                
                incidentMarker.bindPopup(originalPopup);
                originalPopups.set(incidentMarker, originalPopup);
                markersToOpen.push(incidentMarker);
                incidentLayers.push(incidentMarker);
            }
        } catch (e) {
            console.error('Error parsing coordinates for accidents', e);
        }
    });

    function showAll() {
        clearAllPopups();
        hazardLayers.forEach(layer => layer.addTo(map));
        shelterLayers.forEach(layer => layer.addTo(map));
        incidentLayers.forEach(layer => layer.addTo(map));
        restoreOriginalPopups();
    }

    function showHazards() {
        clearAllPopups();
        hazardLayers.forEach(layer => layer.addTo(map));
        shelterLayers.forEach(layer => map.removeLayer(layer));
        incidentLayers.forEach(layer => map.removeLayer(layer));
        restoreOriginalPopups();
    }

    function showShelters() {
        clearAllPopups();
        shelterLayers.forEach(layer => layer.addTo(map));
        hazardLayers.forEach(layer => map.removeLayer(layer));
        incidentLayers.forEach(layer => map.removeLayer(layer));
        restoreOriginalPopups();
    }

    function showIncidents() {
        clearAllPopups();
        incidentLayers.forEach(layer => layer.addTo(map));
        shelterLayers.forEach(layer => map.removeLayer(layer));
        hazardLayers.forEach(layer => map.removeLayer(layer));
        restoreOriginalPopups();
    }

    var FilterControl = L.Control.extend({
        onAdd: function (map) {
            var div = L.DomUtil.create('div', 'btn-group btn-group-sm');
            div.innerHTML = `
                <button id="show-all" class="btn btn-secondary">Show All</button>
                <button id="show-hazards" class="btn btn-secondary">Hazards</button>
                <button id="show-shelters" class="btn btn-secondary">Shelters</button>
                <button id="show-incidents" class="btn btn-secondary">Accidents</button>
            `;
            L.DomEvent.on(div, 'click', function (e) {
                L.DomEvent.stopPropagation(e);
            });
            return div;
        },
        onRemove: function (map) { }
    });

    var filterControl = new FilterControl();
    filterControl.addTo(map);

    document.getElementById('show-all').addEventListener('click', showAll);
    document.getElementById('show-hazards').addEventListener('click', showHazards);
    document.getElementById('show-shelters').addEventListener('click', showShelters);
    document.getElementById('show-incidents').addEventListener('click', showIncidents);

    function findNearbyHazards(userCoordinates, hazardData) {
        const MAX_DISTANCE = 1000; // 1 km in meters
        let nearbyHazards = [];
    
        hazardData.forEach(function (hazard) {
            try {
                let hazardCoordinatesString = hazard.coordinates;
    
                if (hazardCoordinatesString.startsWith('"') && hazardCoordinatesString.endsWith('"')) {
                    hazardCoordinatesString = hazardCoordinatesString.slice(1, -1);
                }
    
                let hazardCoordinates = JSON.parse(hazardCoordinatesString);
    
                if (Array.isArray(hazardCoordinates) && hazardCoordinates.length > 0 && Array.isArray(hazardCoordinates[0])) {
                    let hazardLat = hazardCoordinates[0][0];
                    let hazardLon = hazardCoordinates[0][1];
    
                    const distance = calculateDistance([userCoordinates[0], userCoordinates[1]], [hazardLat, hazardLon]);
    
                    if (distance <= MAX_DISTANCE) {
                        nearbyHazards.push({
                            hazard: hazard,
                            distance: (distance / 1000).toFixed(2) // Convert meters to km
                        });
                    }
                }
            } catch (e) {
                console.error('Error processing hazard:', hazard.hazardName, e);
            }
        });
    
        return nearbyHazards.sort((a, b) => parseFloat(a.distance) - parseFloat(b.distance));
    }
    
    function getUserLocationAndCheckHazards() {
        fetch('http://ip-api.com/json/')
            .then(response => response.json())
            .then(data => {
                const userLat = data.lat;
                const userLon = data.lon;
                console.log('User location:', userLat, userLon);
    
                const userCoordinates = [userLat, userLon];
                const nearbyHazards = findNearbyHazards(userCoordinates, hazardData);
    
                if (nearbyHazards.length > 0) {
                    let hazardNames = nearbyHazards.map(h => h.hazard.hazardName).join(', ');
                    document.getElementById('nearAlert').innerHTML = `
                    <div class="mt-4 alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill p-2"></i>
                        <span>Hazard Alert: ${hazardNames} has been detected within 1 km of your location. Please remain vigilant and take necessary precautions. Stay safe!</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                } else {
                    console.log("No nearby hazards detected.");
                }
            })
            .catch(error => {
                console.error('Error fetching user location:', error);
            });
    }
    
    function calculateDistance(point1, point2) {
        return L.latLng(point1[0], point1[1]).distanceTo(L.latLng(point2[0], point2[1]));
    }
    
    getUserLocationAndCheckHazards();
}
