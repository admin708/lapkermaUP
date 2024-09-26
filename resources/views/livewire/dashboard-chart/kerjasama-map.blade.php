<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        /* Pastikan peta mengambil lebar penuh dan tinggi tetap */
        #map-kerjasama {
            width: 100%;
            height: 600px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div id="map-kerjasama" style="width: 100%; height: 500px; z-index: 0;"></div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi peta
            var map = L.map('map-kerjasama', {
                scrollWheelZoom: false,
                zoomControl: true
            }).setView([0.78, 113.92], 5);  // Pusat peta

            // Menambahkan layer dari OpenStreetMap
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            Livewire.on('negaraName', function(countryName) {
                // createMarkers()
            });
        });
    </script>
</body>

</html>
