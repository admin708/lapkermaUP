<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="text-xs text-primary text-uppercase mb-1">
                Riwayat Kerjasama
                </div>
            </div>
            </div>
        <div class="card-body">
            @if ($reRenderChart == true)
                <div id="riwayatKerjasamaChartRerender"></div>
            @else
                <div id="riwayatKerjasamaChart"></div>
            @endif
          
        </div>
    </div>

        @push('chart-riwayatKerjasama')
                <script>
                    window.addEventListener('contentChanged', event => {
                        var dataMoU = JSON.parse(event.detail.mou);
                        var dataMoA = JSON.parse(event.detail.moa);
                        var dataIA = JSON.parse(event.detail.ia);
                        var optionRiwayatKerjasama = {
                            chart: {
                            height: 280,
                            type: "area"
                            },
                            dataLabels: {
                            enabled: false
                            },
                            series: [
                            {
                                name: "MoU",
                                data: dataMoU
                            },
                            {
                                name: "MoA",
                                data: dataMoA
                            },
                            {
                                name: "IA",
                                data: dataIA
                            }
                            ],
                            fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.7,
                                opacityTo: 0.9,
                                stops: [0, 90, 100]
                            }
                            },
                            xaxis: {
                            categories: [
                                "Jan",
                                "Feb",
                                "Mar",
                                "Apr",
                                "Mei",
                                "Jun",
                                "Jul",
                                "Agu",
                                "Sep",
                                "Okt",
                                "Nov",
                                "Des"
                            ]
                            }
                        };
                        var chartRiwayatKerjasama = new ApexCharts(document.querySelector("#riwayatKerjasamaChartRerender"), optionRiwayatKerjasama);

                        chartRiwayatKerjasama.render();
                    });

                </script>
                <script>
                    var dataMoU = {{$countMOUByJenisPerMonth}};
                    var dataMoA = {{$countMOAByJenisPerMonth}};
                    var dataIA = {{$countIAByJenisPerMonth}};
                    var optionRiwayatKerjasama = {
                        chart: {
                        height: 280,
                        type: "area"
                        },
                        dataLabels: {
                        enabled: false
                        },
                        series: [
                        {
                            name: "MoU",
                            data: dataMoU
                        },
                        {
                            name: "MoA",
                            data: dataMoA
                        },
                        {
                            name: "IA",
                            data: dataIA
                        }
                        ],
                        fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.9,
                            stops: [0, 90, 100]
                        }
                        },
                        xaxis: {
                        categories: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "Mei",
                            "Jun",
                            "Jul",
                            "Agu",
                            "Sep",
                            "Okt",
                            "Nov",
                            "Des"
                        ]
                        }
                    };
                    var chartRiwayatKerjasama = new ApexCharts(document.querySelector("#riwayatKerjasamaChart"), optionRiwayatKerjasama);
                    chartRiwayatKerjasama.render();
                </script>
        @endpush
</div>
