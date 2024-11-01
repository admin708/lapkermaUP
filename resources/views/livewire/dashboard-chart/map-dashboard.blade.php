<div class="about-area">
    <div class="container">
        <style>
            .svgMap-map-wrapper .svgMap-map-controls-wrapper {
                bottom: auto;
                top: 50px;
                left: auto;
                right: 5px;
                display: none;
            }

            .svgMap-map-wrapper .svgMap-map-controls-move,
            .svgMap-map-wrapper .svgMap-map-controls-zoom {
                flex-direction: column;
            }

            .svgMap-map-wrapper .svgMap-country {
                stroke: #999;
            }

            .svgMap-map-wrapper {
                border-radius: 0.5rem;
                background-color: white;
            }

            /* Style for markers */
            .map-marker {
                fill: red;
                stroke: black;
                stroke-width: 1px;
            }
        </style>

        @if ($reRenderChart == false)
            <div id="svgMap"></div>
        @else
            <div id="svgMapRerender"></div>
        @endif

        @push('custom-scripts')
            <script>
                function initializeSvgMap(targetElementID, values) {
                    new svgMap({
                        targetElementID: targetElementID,
                        mouseWheelZoomEnabled: false,
                        mouseWheelZoomWithKey: true,
                        colorMin: '#4d71a8',
                        colorMax: '#a93138',
                        colorNoData: '#d9ecff',
                        noDataText: 'Belum ada kerjasama',
                        data: {
                            data: {
                                total: {
                                    name: 'Jumlah Kerja Sama',
                                    format: '{0}',
                                },
                            },
                            applyData: 'total',
                            values: values
                        }
                    });
                }

                document.addEventListener('DOMContentLoaded', function() {
                    initializeSvgMap('{{ $reRenderChart == false ? 'svgMap' : 'svgMapRerender' }}',
                        @json($data2));
                    document.querySelectorAll('.svgMap-country').forEach(function(countryElement) {
                        countryElement.addEventListener('click', function() {
                            const countryName = document.querySelector('.svgMap-tooltip-title').innerText;

                            const element = document.getElementById("map-kerjasama-section");
                            element.scrollIntoView({
                                behavior: 'smooth'
                            });

                            Livewire.emit('setNegaraName', countryName);
                        });
                    });
                });

                window.addEventListener('contentChanged2', function(event) {
                    var dataX = event.detail.data2;
                    initializeSvgMap('svgMapRerender', dataX);
                });
            </script>
        @endpush
    </div>
</div>
