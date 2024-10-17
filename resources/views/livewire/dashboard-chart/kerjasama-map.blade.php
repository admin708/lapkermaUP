<div>
    <button wire:click="setMapVisibility">
        {{ $mapVisibility ? 'Hide Map' : 'Show Map' }}
    </button>
    <div id="map-kerjasama"
        style="width: 100%; height: 500px; z-index: 0; display: {{ $mapVisibility ? 'block' : 'none' }};"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let map = null;
        let markers = [];

        function initializeMap() {
            if (map !== null) {
                map.invalidateSize(); // Ensure map size is updated
                return; // Map already initialized
            }

            // Initialize the map
            map = L.map('map-kerjasama', {
                scrollWheelZoom: false,
                fullscreenControl: true,
            }).setView([0.78, 113.92], 5);

            // Set tile layer for the map
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Enable zoom when mouse is over the map
            const mapElement = document.getElementById('map-kerjasama');
            mapElement.addEventListener('mouseenter', function() {
                map.scrollWheelZoom.enable(); // Aktifkan zoom saat mouse over
                map.dragging.enable(); // Aktifkan dragging (geser peta)
            });

            // Event untuk menonaktifkan zoom ketika mouse keluar dari peta
            mapElement.addEventListener('mouseleave', function() {
                map.scrollWheelZoom.disable(); // Nonaktifkan zoom saat mouse keluar
                map.dragging.disable(); // Nonaktifkan dragging
            });
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
            clearMarkers();

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
            } else {
                alert("Masih belum ada kerjasama dengan negara ini");
            }
        }

        // Initialize the map and update with data
        initializeMap();
        updateMap(@json($dataKerjaSamaNegara));

        // Listen for the map visibility change
        Livewire.on('mapVisibilityChanged', function (isVisible) {
            const mapElement = document.getElementById('map-kerjasama');
            mapElement.style.display = isVisible ? 'block' : 'none'; // Toggle map visibility
            if (isVisible) {
                map.invalidateSize(); // Update map size
            }
        });
    });
</script>
