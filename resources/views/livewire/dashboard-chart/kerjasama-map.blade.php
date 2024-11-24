<div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let map = null;
            let markers = [];

            // Fungsi untuk inisialisasi peta
            function initializeMap() {
                if (map !== null) {
                    return; // Peta sudah diinisialisasi
                }
                map = L.map('map-kerjasama', {
                    scrollWheelZoom: false
                }).setView([0.78, 113.92], 5); // Set posisi peta awal
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
            }

            // Fungsi untuk menghapus marker yang sudah ada
            function clearMarkers() {
                markers.forEach(function(marker) {
                    map.removeLayer(marker);
                });
                markers = [];
            }

            // Fungsi untuk memperbarui peta dengan data marker baru
            function updateMap(dataKerjaSamaNegara) {
                clearMarkers(); // Hapus marker lama

                dataKerjaSamaNegara.forEach(function(instansi) {
                    if (instansi.coordinates) {
                        let coordinates = instansi.coordinates.trim().split(',');
                        if (coordinates.length === 2) {
                            let latitude = parseFloat(coordinates[0]);
                            let longitude = parseFloat(coordinates[1]);

                            if (!isNaN(latitude) && !isNaN(longitude)) {
                                let marker = L.marker([latitude, longitude])
                                    .addTo(map)
                                    .bindPopup(
                                        `
            <b>${instansi.name}</b><br>
            MoA Count: ${instansi.moa_count}<br>
            MoU Count: ${instansi.mou_count}<br>
            IA Count: ${instansi.ia_count}<br>
            Total Count: ${instansi.total_count}
        `
                                    );
                                markers.push(marker);
                            }
                        }
                    }
                });

                // Pastikan peta disesuaikan dengan marker yang ada
                if (markers.length > 0) {
                    let group = new L.featureGroup(markers);
                    map.fitBounds(group.getBounds()); // Sesuaikan tampilan peta dengan marker
                }
            }

            // Mendengarkan event 'dataKerjaSamaNegaraUpdate' dari Livewire
            Livewire.on('dataKerjaSamaNegaraUpdate', function(dataKerjaSamaNegara) {
                console.log('Data diterima:', dataKerjaSamaNegara);
                if (Array.isArray(dataKerjaSamaNegara)) {
                    updateMap(dataKerjaSamaNegara);
                } else {
                    console.error('Data yang diterima tidak valid:', dataKerjaSamaNegara);
                }
            });

            // Inisialisasi peta dan memperbarui peta dengan data
            initializeMap();

        });
    </script>


    <div>
        <div id="map-kerjasama" style="width: 100%; height: 500px; z-index: 0;"></div>
    </div>
</div>
