<div class="card">
    <div id="svgMap" style="border-radius: 0.5rem; border: 0 solid #d9dee3">
    </div>
    @push('custom-scripts')
        <script>
            new svgMap({
                targetElementID: 'svgMap',
                mouseWheelZoomEnabled: false,
                mouseWheelZoomWithKey: true,
                colorMin: '#4d71a8',
                colorMax: '#a93138',
                colorNoData: '#ffffff',
                noDataText: 'Belum ada kerjasama',
                data: {
                    data: {
                        total: {
                            name: 'Jumlah Kerja Sama',
                            format: '{0}',
                        },
                    },
                    applyData: 'total',
                    values: {
                        'ID': {
                            total: 195,
                            color: '#a93138',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'TH': {
                            total: 15,
                            color: '#334869',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'MY': {
                            total: 15,
                            color: '#334869',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'IN': {
                            total: 4,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'TK': {
                            total: 4,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'AU': {
                            total: 4,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'PH': {
                            total: 4,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'VN': {
                            total: 4,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'DE': {
                            total: 3,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'TW': {
                            total: 3,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'YE': {
                            total: 2,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'SG': {
                            total: 2,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'JP': {
                            total: 2,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'KR': {
                            total: 2,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'KZ': {
                            total: 2,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'US': {
                            total: 2,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'CN': {
                            total: 2,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'PT': {
                            total: 1,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'GB': {
                            total: 1,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'RU': {
                            total: 1,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'SA': {
                            total: 1,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'TN': {
                            total: 1,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'AF': {
                            total: 1,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'NL': {
                            total: 1,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                        'PL': {
                            total: 1,
                            color: '#4d71a8',
                            link: 'https://lapkerma.unhas.ac.id',
                        },
                    }
                }
            });
        </script>
    @endpush
</div>
