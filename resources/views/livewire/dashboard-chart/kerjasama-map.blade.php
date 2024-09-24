<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
</head>

<body>
    <div id="map-kerjasama" style="width: 100%; height: 500px;"></div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map-kerjasama', {
                scrollWheelZoom: false
            }).setView([0.78, 113.92], 5);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // function createMarkers() {
            //     var markers = []
            //     if ({{ json_encode($dataKerjaSamaNegara) }} !== null) {
            //         @foreach ($dataKerjaSamaNegara->instansi as $instansi)
            //             if ($instansi !== null) {
            //                 markers.push([{{ $instansi->latitude }}, {{ $instansi->longitude }}]);
            //             }
            //         @endforeach

            //         markers.forEach(function(coords) {
            //             var lat = coords[0];
            //             var lng = coords[1];
            //             L.marker([lat, lng]).addTo(map);
            //         });

            //         if (markers.length > 0) { // Ensure there are markers before fitting bounds
            //             var bounds = L.latLngBounds(markers);
            //             map.fitBounds(bounds);
            //         }
            //     } else {
            //         alert("No data available for markers."); // Alert if data is null
            //     }
            // }

            Livewire.on('negaraName', function(countryName) {
                // createMarkers()
            });
        });
    </script>
</body>

</html>
