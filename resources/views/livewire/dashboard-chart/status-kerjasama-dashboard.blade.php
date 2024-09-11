<div>

    <div class="card">
        <div class="card-header">
        <div class="card-title">
            <div class="text-xs text-primary text-uppercase mb-1">
            Status Kerjasama
            </div>
            <span class="text-primary card-subtitle">Proporsi kerjasama berdasarkan status / masa berlaku dokumen</span>
        </div>
        </div>
        <div class="card-body">
            <div id="statusKerjasamaChart">
        </div>
        </div>
    </div>

    @push('chart-statusKerjasama')
        <script>
            var dataStatusKerjasama = {{$countStatus}};
            var optionStatusKerjasama = {
                chart: {
                width: 400,
                type: 'donut',
                // dataLabels: {
                // position: 'bottom'
                // }
                },
                fill: {
                    type: 'gradient',
                },
                series: dataStatusKerjasama,
                labels: ['Aktif', 'Dalam Perpanjangan', 'Kadaluarsa', 'Tidak Aktif'],

            }
            var chartStatusKerjasama = new ApexCharts(document.querySelector("#statusKerjasamaChart"), optionStatusKerjasama);

            chartStatusKerjasama.render();
        </script>
    @endpush


</div>
