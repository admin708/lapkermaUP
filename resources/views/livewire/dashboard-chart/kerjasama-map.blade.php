<script>
    document.addEventListener('DOMContentLoaded', function() {
        let map = null;
        let markers = [];

        function initializeMap() {
            if (map !== null) {
                return; // Map already initialized
            }

            map = L.map('map-kerjasama', {
                scrollWheelZoom: false
            }).setView([0.78, 113.92], 5);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
        }

        // Function to clear all markers from the map
        function clearMarkers() {
            markers.forEach(function(marker) {
                map.removeLayer(marker);
            });
            markers = [];
        }

        Livewire.on('dataKerjaSamaNegaraUpdate', function(dataKerjaSamaNegara) {
            updateMap(dataKerjaSamaNegara);
        });

        // Function to update the map with new data
        function updateMap(dataKerjaSamaNegara) {
            clearMarkers(); // Clear old markers

            dataKerjaSamaNegara.forEach(function(instansi) {
                let latitude = parseFloat(instansi.latitude);
                let longitude = parseFloat(instansi.longitude);

                if (!isNaN(latitude) && !isNaN(longitude)) {
                    let marker = L.marker([latitude, longitude])
                        .addTo(map)
                        .bindPopup(
                            `<b>${instansi.name}</b><br>Latitude: ${latitude}<br>Longitude: ${longitude}`
                        );
                    markers.push(marker);
                }
            });

            // Adjust the map bounds to fit all markers
            if (markers.length > 0) {
                let group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds());
            }
        }

        initializeMap();

        updateMap(@json($dataKerjaSamaNegara));

    });
</script>

<div>
    <div id="map-kerjasama" style="width: 100%; height: 500px; z-index: 0;"></div>
</div>
