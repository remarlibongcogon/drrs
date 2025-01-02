function initializeHazardMapDraw(mapContainerId, coordinatesInputId) {
    // Initialize the map
    var map = L.map(mapContainerId).setView([10.728, 123.826], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {  
    }).addTo(map);

    // Initialize the feature group for drawing
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
        edit: { featureGroup: drawnItems, remove: true },
        draw: { polygon: true, polyline: false, rectangle: false, circle: false, marker: false }
    });
    map.addControl(drawControl);

    // Event listener for when a drawing is completed
    map.on('draw:created', function(event) {
        var layer = event.layer;
        drawnItems.clearLayers();
        drawnItems.addLayer(layer);

        var data = layer.getLatLngs()[0];
        const coordinates = data.map(item => [item.lat, item.lng]);

        // Store coordinates in the input field
        document.getElementById(coordinatesInputId).value = JSON.stringify(coordinates);
    });
}

window.initializeHazardMapDraw = initializeHazardMapDraw;