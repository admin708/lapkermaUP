<style>
    #map-container {
        width: 100%;
        height: 500px;
        position: relative;
    }

    #map-kerjasama {
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    #toggle-map-btn {
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    #toggle-map-btn:hover {
        background-color: #0056b3;
    }
</style>

<div>
   @if($mapVisible)
   <div id="map-container">
       <div id="map-kerjasama" style="display: block;"></div>
   </div> 
   @endif
   <button wire:click="toggleMapVisibility" id="toggle-map-btn">
       {{ $mapVisible ? 'Close Map' : 'Open Map' }}
   </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
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
            mapElement.addEventListener('mouseenter', function () {
                map.scrollWheelZoom.enable(); // Enable zoom on mouse over
                map.dragging.enable();        // Enable dragging
            });

            // Disable zoom when mouse leaves the map
            mapElement.addEventListener('mouseleave', function () {
                map.scrollWheelZoom.disable(); // Disable zoom on mouse leave
                map.dragging.disable();        // Disable dragging
            });
        }

        // Function to clear all markers from the map
        function clearMarkers() {
            markers.forEach(function (marker) {
                map.removeLayer(marker);
            });
            markers = [];
        }

        Livewire.on('dataKerjaSamaNegaraUpdate', function (dataKerjaSamaNegara) {
            updateMap(dataKerjaSamaNegara);
        });

        // Function to update the map with new data
        function updateMap(dataKerjaSamaNegara) {
            clearMarkers();

            dataKerjaSamaNegara.forEach(function (instansi) {
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
            document.getElementById('map-container').style.display = isVisible ? 'block' : 'none'; // Toggle map visibility
        });
    });
</script>
