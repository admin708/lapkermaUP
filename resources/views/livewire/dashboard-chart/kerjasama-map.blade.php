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
    <div style="display: {{ $mapVisibility ? 'block' : 'none' }};">
        <div id="map-kerjasama" style="width: 100%; height: 500px; z-index: 0;">
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let map = null;
        let markers = [];

        function initializeMap() {
            if (map !== null) {
                return; // Map already initialized
                map.invalidateSize(); // Ensure the map size is updated
                return;
            }

            // Initialize the map
            map = L.map('map-kerjasama', {
                scrollWheelZoom: false,
                fullscreenControl: true,
            }).setView([0.78, 113.92], 5);

            setTileLayer();
            setMapInteractionEvents();
        }

        function setTileLayer() {
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
        }

        function setMapInteractionEvents() {
            const mapElement = document.getElementById('map-kerjasama');

            mapElement.addEventListener('mouseenter', () => enableMapInteraction());
            mapElement.addEventListener('mouseleave', () => disableMapInteraction());
        }

        function enableMapInteraction() {
            if (map) {
                map.scrollWheelZoom.enable();
                map.dragging.enable();
            }
        }

        function disableMapInteraction() {
            if (map) {
                map.scrollWheelZoom.disable();
                map.dragging.disable();
            }
        }

        function clearMarkers() {
            markers.forEach((marker) => {
                map.removeLayer(marker);
            });
            markers = [];
        }

        function updateMap(dataKerjaSamaNegara) {
            clearMarkers();
            dataKerjaSamaNegara.forEach((instansi) => {
                addMarker(instansi);
            });
            adjustMapBounds();
        }

        function addMarker(instansi) {
            let latitude = parseFloat(instansi.latitude);
            let longitude = parseFloat(instansi.longitude);

            if (!isNaN(latitude) && !isNaN(longitude)) {
                let marker = L.marker([latitude, longitude])
                    .addTo(map)
                    .bindPopup(`<b>${instansi.name}</b><br>Latitude: ${latitude}<br>Longitude: ${longitude}`);
                markers.push(marker);
            }
        }

        function adjustMapBounds() {
            if (markers.length > 0) {
                let group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds());
            } else {
                alert("Masih belum ada kerjasama dengan negara ini");
                alert("Masih belum ada kerjasama dengan negara ini");
                alert("Masih belum ada kerjasama dengan negara ini");
            }
        }

        function invalidateMapSize() {
            if (map) {
                setTimeout(() => {
                    map.invalidateSize();
                }, 100); // Slight delay to ensure the map is visible before invalidating size
            }
        }

        function setupMutationObserver() {
            const mapElement = document.getElementById('map-kerjasama');
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'style' &&
                        mapElement.style.display === 'block') {
                        invalidateMapSize();
                    }
                });
            });

            observer.observe(mapElement, {
                attributes: true
            });
        }

        function setupLivewireListeners() {
            Livewire.on('dataKerjaSamaNegaraUpdate', (dataKerjaSamaNegara) => {
                updateMap(dataKerjaSamaNegara);
            });
        }

        function init() {
            setupMutationObserver();
            setupLivewireListeners();
            initializeMap();
            updateMap(@json($dataKerjaSamaNegara));
        }

        init();
        // Initialize the map and update with data
        initializeMap();
        updateMap(@json($dataKerjaSamaNegara));

        // Listen for the map visibility change
        Livewire.on('mapVisibilityChanged', function(isVisible) {
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
