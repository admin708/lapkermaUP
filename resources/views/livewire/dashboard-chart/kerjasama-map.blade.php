<div id="map" style="width: 100%; height: 400px;">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([0.78, 113.92], 5); // Default view
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        function createMarkers() {
            var markers = [
                [3.47, 13.39],
                [35, 03, 13, 58],
            ]
            markers.forEach(function(coords) {
                var lat = coords[0].toFixed(3); // Limit to 3 decimal places
                var lng = coords[1].toFixed(3); // Limit to 3 decimal places
                L.marker([lat, lng]).addTo(map);
            });
        }

        // Function to get country boundaries using Nominatim API
        function zoomToCountry(country) {
            var url = `https://nominatim.openstreetmap.org/search?country=${country}&format=json&polygon_geojson=1`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        var bounds = data[0].boundingbox;
                        var southWest = L.latLng(bounds[0], bounds[2]);
                        var northEast = L.latLng(bounds[1], bounds[3]);
                        var countryBounds = L.latLngBounds(southWest, northEast);

                        map.fitBounds(countryBounds); // Zoom map to country bounds
                    } else {
                        alert("Country not found!");
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Example: Automatically zoom to Indonesia
        zoomToCountry('Japan');
    </script>
</div>
