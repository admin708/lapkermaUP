<div>
    <button wire:click="setMapVisibility" style="
        background-color: #4A90E2; /* Blue color similar to the example */
        border: none;
        color: white;
        padding: 6px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 10px; /* More rounded corners for a circular appearance */
        transition: background-color 0.3s ease;">
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

        // Initialize the map only when it becomes visible
        Livewire.on('mapVisibilityChanged', function (isVisible) {
            const mapElement = document.getElementById('map-kerjasama');
            mapElement.style.display = isVisible ? 'block' : 'none';

            if (isVisible) {
                if (!map) {
                    initializeMap();
                }
                setTimeout(() => {
                    map.invalidateSize(); // Update map size after making it visible
                }, 300);
            }
        });

        // Initialize the map and update with data only if map is initially visible
        if ({{ $mapVisibility }}) {
            initializeMap();
            updateMap(@json($dataKerjaSamaNegara));
        }
    });
</script>
