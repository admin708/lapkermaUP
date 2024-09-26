<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
</head>

<body>
    <div>
        <div id="map-kerjasama" style="width: 100%; height: 500px; z-index: 0;"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map-kerjasama', {
                scrollWheelZoom: false
            }).setView([0.78, 113.92], 5);
            alert(@json($dataKerjaSamaNegara))

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            updateMap(dataKerjaSamaNegara);

            var markers = []; // Properly scoped markers array

            function clearMarkers() {
                markers.forEach(function(marker) {
                    map.removeLayer(marker);
                });
                markers = []; // Clear the markers array
            }

            function updateMap(dataKerjaSamaNegara) {
                console.log('Updating map with:', dataKerjaSamaNegara); // Debugging line
                clearMarkers(); // Clear previous markers

                dataKerjaSamaNegara.forEach(function(instansi) {
                    var latitude = parseFloat(instansi.latitude);
                    var longitude = parseFloat(instansi.longitude);

                    console.log(
                        `Instansi: ${instansi.name}, Latitude: ${latitude}, Longitude: ${longitude}`
                    ); // Debugging line

                    if (!isNaN(latitude) && !isNaN(longitude)) {
                        var marker = L.marker([latitude, longitude])
                            .addTo(map)
                            .bindPopup(
                                `<b>${instansi.name}</b><br>Latitude: ${latitude}<br>Longitude: ${longitude}`
                            );
                        markers.push(marker);
                    } else {
                        console.warn('Invalid latitude or longitude for instansi:', instansi);
                    }
                });

                // Optionally adjust the map to fit all markers
                if (markers.length > 0) {
                    var group = new L.featureGroup(markers);
                    map.fitBounds(group.getBounds()); // Fit the map to the markers
                }
            }

            document.addEventListener('livewire:load', function() {
                Livewire.on('negaraDataUpdated', function(dataKerjaSamaNegara) {
                    console.log('New data received:', dataKerjaSamaNegara); // Debugging line
                    updateMap(dataKerjaSamaNegara);
                });
            });
        });
    </script>
</body>

</html>
