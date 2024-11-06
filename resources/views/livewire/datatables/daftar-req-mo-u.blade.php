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
                            <td>{{ $item->nama_instansi }} - {{ $item->tanggal_ttd }}</td>
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
                                                wire:click="deleteMouRequest({{ $item->id }})">
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
    <div class="modal fade show" id="fullscreenModal" tabindex="-1"
        style="display: {{ $showModalsEdit == true ? 'block' : 'none' }};" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header container">
                    <h4 class="modal-title h4" id="modalFullTitle">{{ $showModalsEdit == true ? 'Detail' : '' }} Data
                        MoU
                    </h4>
                    <div class="demo-inline-spacing">
                        <button type="button" wire:click="closeEdit" class="btn btn-secondary btn-sm">
                            <span class="tf-icons bx bx-chevron-left"></span>&nbsp; Close
                        </button>
                        @if (auth()->user()->role_id == 1)
                            <button type="button" wire:click="emitEdit" class="btn btn-primary btn-sm">
                                <span class="tf-icons bx bx-save"></span>&nbsp; Update
                            </button>
                        @endif
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @livewire('input.mou')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
