<div class="card">
    <h5 class="card-header bg-primary p-3 text-white">Data Table</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap mt-3">
            {{-- <div class="dropdown jenis_kerja_sama">
                <button class="btn btn-outline-primary dropdown-toggle width" style="width: 200px;" role="button"
                    data-bs-toggle="dropdown">
                    Pilih Jenis Kerja Sama
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" wire:click="setKerjasamaId(null, 'Semua Kerja Sama')">PRODI</a></li>
                    <li><a class="dropdown-item" wire:click="setKerjasamaId(1, 'Dalam Negeri')">FAKULTAS</a></li>
                    <li><a class="dropdown-item" wire:click="setKerjasamaId(2, 'Luar Negeri')">UNIVERSITAS</a></li>
                </ul>
            </div> --}}
            <table class="table table-bordered table-hover table-sm text-start mt-2" style="font-size: 13px">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>PRODI</th>
                        <th>IKU SCORES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($DataSkor as $item)
                        <tr>
                            <td>{{ $item->prodi_id }}</td>
                            <td>{{ $item->nama_resmi }}</td>
                            <td>{{ $item->skor_iku }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $DataSkor->links() }} <!-- Update to use $DataIa instead of $referenceCounts -->
            </div>
        </div>
    </div>
</div>
