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
    <div>
        <div id="map-kerjasama" style="width: 100%; height: 500px; z-index: 0;"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi peta
            var map = L.map('map-kerjasama', {
                scrollWheelZoom: true, // Mengaktifkan zoom menggunakan scroll wheel
                dragging: true         // Mengaktifkan dragging (geser peta)
            }).setView([0.78, 113.92], 5);

            // Debugging: Tampilkan data kerjasama negara di konsol
            var dataKerjaSamaNegara = @json($dataKerjaSamaNegara);
            console.log('Initial data:', dataKerjaSamaNegara);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var markers = []; // Array untuk menyimpan marker

            // Fungsi untuk menghapus semua marker dari peta
            function clearMarkers() {
                markers.forEach(function (marker) {
                    map.removeLayer(marker);
                });
                markers = []; // Kosongkan array markers
            }

            // Fungsi untuk memperbarui peta dengan data kerjasama
            function updateMap(dataKerjaSamaNegara) {
                console.log('Updating map with:', dataKerjaSamaNegara); // Debugging

                clearMarkers(); // Hapus marker sebelumnya

                dataKerjaSamaNegara.forEach(function (instansi) {
                    var latitude = parseFloat(instansi.latitude);
                    var longitude = parseFloat(instansi.longitude);

                    // Debugging: Tampilkan informasi instansi di konsol
                    console.log(`Instansi: ${instansi.name}, Latitude: ${latitude}, Longitude: ${longitude}`);

                    // Validasi latitude dan longitude
                    if (!isNaN(latitude) && !isNaN(longitude)) {
                        var marker = L.marker([latitude, longitude])
                            .addTo(map)
                            .bindPopup(
                                `<b>${instansi.name}</b><br>Latitude: ${latitude}<br>Longitude: ${longitude}`
                            );
                        markers.push(marker); // Simpan marker ke array
                    } else {
                        console.warn('Invalid latitude or longitude for instansi:', instansi);
                    }
                });

                // Atur peta agar sesuai dengan semua marker
                if (markers.length > 0) {
                    var group = new L.featureGroup(markers);
                    map.fitBounds(group.getBounds()); // Fit the map to the markers
                    console.log('Map bounds updated to fit all markers.');
                }
            }

            // Panggil fungsi updateMap dengan data awal
            updateMap(dataKerjaSamaNegara);

            // Event listener untuk Livewire yang memperbarui data di peta
            document.addEventListener('livewire:load', function () {
                Livewire.on('negaraDataUpdated', function (dataKerjaSamaNegara) {
                    console.log('New data received:', dataKerjaSamaNegara); // Debugging
                    updateMap(dataKerjaSamaNegara);
                });
            });

            L.Control.geocoder({
                defaultMarkGeocode: true
            }).addTo(map);
        });
    </script>
</body>

</html>
