<div class="card">
    <h5 class="card-header bg-primary p-3 text-white">Data Table</h5>
    <div class="card-body">
        <div class="d-flex flex-column bd-highlight mt-3">

            <!-- Search Input for Prodi Name -->
            <div class="dropdown search_prodi d-flex justify-content-end">
                <input type="text" class="form-control" wire:model="searchProdi" placeholder="Search Instansi / Alamat"
                    style="width: 200px;">
            </div>

            <div class="d-flex flex-row-reverse bd-highlight mt-3">
                <!-- Dropdown for pagination -->
                <div class="dropdown pagination_count">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Tampilkan {{ $perPage }} per Halaman
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" wire:click="setPerPage(10)">10</a></li>
                        <li><a class="dropdown-item" wire:click="setPerPage(25)">25</a></li>
                        <li><a class="dropdown-item" wire:click="setPerPage(50)">50</a></li>
                        <li><a class="dropdown-item" wire:click="setPerPage(100)">100</a></li>
                    </ul>
                </div>

                <!-- Dropdown for sorting order -->
                <div class="dropdown order_direction px-3">
                    <button class="btn btn-outline-primary" wire:click.debounce.300ms="setOrderDirection">
                        <i
                            class="menu-icon tf-icons bx {{ $orderDirection === 'asc' ? 'bx-sort-up' : 'bx-sort-down' }}"></i>
                    </button>
                </div>

                <!-- Dropdown for Tahun -->
                <div class="dropdown tahun_kerja_sama">
                    <button class="btn btn-outline-primary dropdown-toggle width" style="width: 200px;" role="button"
                        data-bs-toggle="dropdown">
                        {{ $tahunText }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" wire:click="setTahun(null, 'Semua Tahun')">Semua Tahun</a></li>
                        @foreach ($availableYears as $year)
                            <li><a class="dropdown-item"
                                    wire:click="setTahun({{ $year }}, '{{ $year }}')">{{ $year }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Dropdown for Instansi Tipe (Dalam Negeri / Luar Negeri) -->
                <div class="dropdown instansi_jenis px-3">
                    <button class="btn btn-outline-primary dropdown-toggle" style="width: 200px;" role="button"
                        data-bs-toggle="dropdown">
                        {{ $instansiTipeText }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" wire:click="setInstansiTipe(null, 'Semua Instansi')">Semua Instansi</a></li>
                        <li><a class="dropdown-item" wire:click="setInstansiTipe('dalam_negri', 'Instansi Dalam Negeri')">Instansi Dalam Negeri</a></li>
                        <li><a class="dropdown-item" wire:click="setInstansiTipe('luar_negri', 'Instansi Luar Negeri')">Instansi Luar Negeri</a></li>
                    </ul>
                </div>

                <!-- Dropdown for Order By -->
                <div class="dropdown order_by">
                    <button class="btn btn-outline-primary dropdown-toggle" style="width: 200px;" role="button"
                        data-bs-toggle="dropdown">
                        {{ $orderByText }}
                    </button>
                    <ul class="dropdown-menu text-primary">
                        <li class="dropdown-item" wire:click="setOrderBy('name', 'Instansi')">Instansi</li>
                        <li class="dropdown-item" wire:click="setOrderBy('address', 'Alamat')">Alamat</li>
                        <li class="dropdown-item" wire:click="setOrderBy('ptqs', 'PTQS')">PTQS</li>
                        <li class="dropdown-item" wire:click="setOrderBy('badan_kemitraan', 'Badan Kemitraan')">Badan Kemitraan</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap mt-3">
            <table class="table table-bordered table-hover table-sm" style="font-size: 13px">
                <thead>
                    <tr>
                        <th>INSTANSI</th>
                        <th>ALAMAT</th>
                        <th>NEGARA</th>
                        <th>PTQS</th>
                        <th>BADAN KEMITRAAN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($referenceCounts as $referenceCount)
                    <tr style="font-size: 11px">
                        <td>{{ $referenceCount->name}}</td>
                        <td>{{ $referenceCount->address}}</td>
                        <td>{{ $referenceCount->negara_name}}</td>
                        <td>{{ $referenceCount->ptqs ?? 0}}</td>
                        <td>{{ $referenceCount->badan_kemitraan ?? 0}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Tampilkan pagination -->
            <div class="mt-4">
                {{ $referenceCounts->links() }}
            </div>
        </div>
    </div>
</div>
