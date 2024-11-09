<div>
    {{-- Leaftlet --}}
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        /* Ensure the map container has the correct height */
        #map-kerjasama {
            width: 100%;
            height: 600px;
            /* Make sure to set a fixed height */
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- Map container with fixed height and width -->
    <div id="map-kerjasama"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let map = null;
            let markers = []; // Store all markers

            function generateMockData(num) {
                const names = [
                    'John Doe', 'Jane Smith', 'Alex Johnson', 'Chris Lee', 'Katie Brown',
                    'David Wilson', 'Emily Davis', 'Michael Clark', 'Sarah Martinez', 'James Walker'
                ];

                const randomLatitude = () => (Math.random() * (90 - (-90)) + (-90)).toFixed(
                    4); // Latitude range from -90 to 90
                const randomLongitude = () => (Math.random() * (180 - (-180)) + (-180)).toFixed(
                    4); // Longitude range from -180 to 180

                const mockData = [];

                for (let i = 0; i < num; i++) {
                    const name = names[Math.floor(Math.random() * names.length)];
                    const latitude = randomLatitude();
                    const longitude = randomLongitude();

                    mockData.push({
                        name: name,
                        latitude: latitude,
                        longitude: longitude,
                        id: (i + 1).toString() // ID starting from 1
                    });
                }

                return mockData;
            }
            // Initialize the map
            function initializeMap() {
                if (map !== null) {
                    return; // Map already initialized
                }

                // Initialize the map with a center and zoom level
                map = L.map('map-kerjasama', {
                    scrollWheelZoom: false
                }).setView([1.3521, 103.8198], 12); // Default coordinates for Singapore

                // Add the OpenStreetMap tile layer
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
            }

            // Function to add markers from data
            function addMarkers(data) {
                markers.forEach(function(marker) {
                    map.removeLayer(marker);
                });
                markers = [];
                data.forEach(function(location) {
                    let latitude = parseFloat(location.latitude);
                    let longitude = parseFloat(location.longitude);

                    // Check if the coordinates are valid
                    if (!isNaN(latitude) && !isNaN(longitude)) {
                        let marker = L.marker([latitude, longitude])
                            .addTo(map)
                            .bindPopup(
                                `<b>${location.name}</b><br>Latitude: ${latitude}<br>Longitude: ${longitude}`
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

            function updateMapData() {
                const mockData = generateMockData(10); // Generate 10 random mock data points
                addMarkers(mockData); // Add the new markers to the map
            }

            // Pass the mock data from Livewire to the JS function
            // const mockData = @json($mockData);

            initializeMap();
            updateMapData(); // Initial call to populate the map
            setInterval(updateMapData, 10000);
            // addMarkers(mockData);
            // setInterval(function() {
            //     // You can fetch new data here by calling an endpoint if needed
            //     addMarkers(mockDataFromPHP); // This will use the same data for now
            // }, 2000);
        });
        // document.addEventListener('DOMContentLoaded', function() {
        //     let map = null;
        //     let markers = []; // Store all markers

        //     function initializeMap() {
        //         if (map !== null) {
        //             return; // Map already initialized
        //         }

        //         // Initialize the map with a center and zoom level
        //         map = L.map('map-kerjasama', {
        //             scrollWheelZoom: false
        //         }).setView([1.3521, 103.8198], 12); // Default coordinates for Singapore

        //         // Add the OpenStreetMap tile layer
        //         L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //             maxZoom: 19,
        //             attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        //         }).addTo(map);
        //     }

        //     // Function to add markers from API data
        //     function addMarkers(data) {
        //         // Loop through all locations and add them to the map
        //         data.forEach(function(location) {
        //             let latitude = parseFloat(location.latitude);
        //             let longitude = parseFloat(location.longitude);

        //             // Check if the coordinates are valid
        //             if (!isNaN(latitude) && !isNaN(longitude)) {
        //                 let marker = L.marker([latitude, longitude])
        //                     .addTo(map)
        //                     .bindPopup(
        //                         `<b>${location.name}</b><br>Latitude: ${latitude}<br>Longitude: ${longitude}`
        //                     );
        //                 markers.push(marker);
        //             }
        //         });

        //         // Adjust the map bounds to fit all markers
        //         if (markers.length > 0) {
        //             let group = new L.featureGroup(markers);
        //             map.fitBounds(group.getBounds());
        //         }
        //     }

        //     initializeMap();

        //     // Pass locations from Livewire to the map
        //     let locations = @json($locations); // Pass the PHP data to JavaScript
        //     addMarkers(locations); // Add markers based on the data
        // });
    </script>

</div>
