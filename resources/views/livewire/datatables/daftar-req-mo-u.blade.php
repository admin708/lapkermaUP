<div class="card">
    <h5 class="card-header bg-primary p-3 text-white">Data Table</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap mt-3">
            <!-- Search Filters -->
            <div class="mb-3 d-flex">
                <input type="text" class="form-control form-control-sm me-2" placeholder="Cari Nama MoU"
                    wire:model="cariNamaMoU">
                <input type="text" class="form-control form-control-sm" placeholder="Cari Pengirim MoU"
                    wire:model="cariPengirimMoU">
            </div>

            <!-- Data Table -->
            <table class="table table-bordered table-hover table-sm text-start mt-2" style="font-size: 13px">
                <thead>
                    <tr>
                        <th>
                            <a href="#" wire:click.prevent="sortBy('judul')">
                                DAFTAR MoU
                                @if ($sortBy === 'judul')
                                    <span class="text-muted">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="#" wire:click.prevent="sortBy('penggiat')">
                                PENGIRIM MoU
                                @if ($sortBy === 'penggiat')
                                    <span class="text-muted">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th>DETAIL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataMoUs as $item)
                        <tr>
                            <td>{{ $item->nama_instansi }}</td>
                            <td>{{ $item->nama_pejabat_pihak }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-primary small" role="button"
                                            wire:click="showDetail({{ $item->id }})" data-bs-toggle="modal"
                                            data-bs-target="#detailModal">
                                            <i class="bx bx-show me-1"></i> View
                                        </a>
                                        @if (auth()->user()->role_id == 1)
                                            <a class="dropdown-item text-danger small" role="button"
                                                wire:click="removeItem({{ $item->id }})">
                                                <i class="bx bx-trash me-1"></i> Remove
                                            </a>
                                        @endif
                                    </div>
                                </div>
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
    <div wire:ignore.self class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header container">
                    <h5 class="modal-title h4" id="detailModalLabel">Detail Data MoU</h5>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <span class="tf-icons bx bx-chevron-left"></span>&nbsp; Close
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @livewire('input.guest-mou-input')
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
