<div class="card">
    <h5 class="card-header bg-primary p-3 text-white">Data Table</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap mt-3">
            <!-- Search Filters -->
            <div class="mb-3 d-flex">
                <input type="text" class="form-control form-control-sm me-2" placeholder="Cari Nama MoU" wire:model="cariNamaMoU">
                <input type="text" class="form-control form-control-sm" placeholder="Cari Pengirim MoU" wire:model="cariPengirimMoU">
            </div>

            <!-- Data Table -->
            <table class="table table-bordered table-hover table-sm text-start mt-2" style="font-size: 13px">
                <thead>
                    <tr>
                        <th>
                            <a href="#" wire:click.prevent="sortBy('judul')">
                                DAFTAR MoU
                                @if($sortBy === 'judul')
                                    <span class="text-muted">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="#" wire:click.prevent="sortBy('penggiat')">
                                PENGIRIM MoU
                                @if($sortBy === 'penggiat')
                                    <span class="text-muted">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th>DETAIL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataMoUs as $item)
                    <tr>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->penggiat }}</td>
                        <td>
                            <button wire:click="showDetail({{ $item->id }})" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal">Lihat Detail</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-3">
                {{ $dataMoUs->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <!-- Modal for Details -->
    <div wire:ignore.self class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail MoU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($selectedMoU)
                        <p><strong>Judul:</strong> {{ $selectedMoU->judul }}</p>
                        <p><strong>Penggiat:</strong> {{ $selectedMoU->penggiat }}</p>
                        <p><strong>Detail Lainnya:</strong> {{ $selectedMoU->detail }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
