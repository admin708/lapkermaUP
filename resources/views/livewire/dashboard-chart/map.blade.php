<div>
    <style>
        .svgMap-map-wrapper .svgMap-map-controls-wrapper {
            bottom: auto;
            top: 50px;
            left: auto;
            right: 5px;
            display: none
        }

        .svgMap-map-wrapper .svgMap-map-controls-move,
        .svgMap-map-wrapper .svgMap-map-controls-zoom {
            flex-direction: column
        }

        .svgMap-map-wrapper .svgMap-country {
            stroke: #999
        }
        
        .svgMap-map-wrapper {
            border-radius: 0.5rem;
            background-color: white
        }

        </style>

    @if (request()->route()->getName() != 'home')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a class="fw-bold h5" style="color: black">WORLD MAP</a>
                </li>
            </ol>
        </nav>
    @endif

    

    
    <div class="card my-4"  style="min-width: 700px">
        <div id="svgMap{{$reRenderChart == true ? 'Rerender':''}}"
            style=" {{request()->route()->getName() == 'home' ? 'margin-top: 30px':'border-radius: 0.5rem; border: 0 solid #d9dee3;'}}">
        </div>
    </div>

    @push('custom-scripts')
        <script>
            new svgMap({
                        targetElementID: 'svgMap',
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
                        values: @json($data2)
                        }
                    });

        </script>
        <script>
            window.addEventListener('contentChanged2', event => {
                    var dataX = event.detail.data2

                    new svgMap({
                        targetElementID: 'svgMapRerender',
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
                        
                        values: dataX
                        }
                    });
                })
        </script>
    @endpush
</div>