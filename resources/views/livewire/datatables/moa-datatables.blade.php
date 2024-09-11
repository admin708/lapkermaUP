<div class="card">
    <h5 class="card-header bg-primary p-3 text-white">Data Table</h5>
    <div class="card-body">
      @if ($showModalsEdit == false)
      <div class="table-responsive text-nowrap mt-3">
        <button wire:click="download()" type="button" class="btn btn-sm mb-3 btn-outline-primary">
            <span class="tf-icons bx bx-download"></span>&nbsp; Download Exel
          </button>
        <table class="table table-bordered table-hover table-sm" style="font-size: 13px">
          <thead>
            <tr>
              <th rowspan="2">
                <button class="btn btn-sm btn-warning mb-3" wire:click="rezet">Reset</button>
              </th>
              <th>Tanggal TTD</th>
              <th>No. Dokumen</th>
              <th>Level Kerjasama</th>

              <th>Penggiat Kerjasama</th>
              <th>Fakultas/Unit Kerja</th>
              {{-- @if (auth()->user()->role_id != 5) --}}
              <th>Prodi/Sub Unit Kerja</th>
              {{-- @endif --}}
              <th>Negara</th>
              <th>Jenis Kerjasama</th>
              <th>Judul</th>
              <th>Status</th>
              
            </tr>
            <tr>
              <th>
                <select class="form-select form-select-sm" wire:model.lazy="cariTahun">
                  <option value="">Tahun</option>
                  @foreach ($getTahun as $key => $item)
                  <option value="{{ $key }}">{{ $key}}</option>
                  @endforeach
                </select>
                <select class="form-select form-select-sm mt-1" wire:model.lazy="sortData">
                  <option value="">Sort By</option>
                  <option value="1">Tanggal TTD</option>
                  <option value="2">Create</option>
                </select>
              </th>
              <th>
                <input type="text" class="form-control form-control-sm" wire:model.lazy="cariNomorDokumen">
              </th>
              <th>
                <select class="form-select form-select-sm" wire:model.lazy="cariTingkat">
                  <option value="">All</option>
                  <option value="1">Nasional</option>
                  <option value="2">Provensi/Regional</option>
                  <option value="3">Lokal/Kabupaten</option>
                  <option value="4">Internasional</option>
                </select>
              </th>
              <th>
                <input type="text" class="form-control form-control-sm" wire:model.lazy="cariMitra">
              </th>
              <th>
                <select class="form-select form-select-sm" wire:model.lazy="cariFakultas" {{ auth()->user()->role_id == 1
                  ? '':'disabled' }}>
                  <option value="">All</option>
                  @foreach ($getFakultas->sortBy('nama_fakultas') as $item)
                  <option value="{{ $item->id }}">{{ $item->nama_fakultas }}</option>
                  @endforeach
                </select>                
              </th>
              {{-- @if (auth()->user()->role_id != 5) --}}
              <th>
                <select class="form-select form-select-sm" wire:model.lazy="cariNamaProdi" {{ auth()->user()->role_id == 1
                    ? '': (auth()->user()->role_id == 4 ? '':'disabled') }}>
                  <option value="">All</option>
                  @foreach ($getProdi as $item)
                  <option value="{{ $item->nama_resmi }}">{{ $item->nama_resmi }}</option>
                  @endforeach
                </select>
              </th>
              {{-- @endif --}}
              <th>
                <input type="text" class="form-control form-control-sm" wire:model.lazy="cariNegara">
              </th>
              <th>
                <select class="form-select form-select-sm" wire:model.lazy="cariKerjasama">
                  <option value="">All</option>
                  @foreach ($getJenis as $item)
                  <option value="{{ $item->id }}">{{ $item->nama }}</option>
                  @endforeach
                </select>
              </th>
              <th>
                <input type="text" class="form-control form-control-sm" wire:model.lazy="cariJudul">
              </th>
              <th>
                <select class="form-select form-select-sm" wire:model.lazy="cariStatus">
                  <option value=""></option>
                  @foreach ($getStatus as $item)
                  <option value="{{ $item->id }}">{{ $item->nama }}</option>
                  @endforeach
                </select>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($DataMoa as $item)
            <tr style="font-size: 11px">
              <td style="background-color: {{$item->laporan ? '':'#95092c26'}}">
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu" style="">
                    {{-- @if ($item->level == 1)
                    <a class="dropdown-item text-primary" role="button" href="{{ route('edit-data',['MoA',$item->id]) }}"><i
                      class="bx bx-show me-1"></i> View</a>
                    @else
                    <a class="dropdown-item text-primary" role="button" wire:click="getEdit2({{ $item->id }})"><i
                      class="bx bx-show me-1"></i> View</a>
                    @endif --}}

                    @if ($modeData)
                    <a class="dropdown-item text-primary" role="button" href="{{ route('edit-data',['MoA',$item->id,'np']) }}"><i
                      class="bx bx-show me-1"></i> View</a>
                    @else
                    <a class="dropdown-item text-primary" role="button" href="{{ route('edit-data',['MoA',$item->id]) }}"><i
                      class="bx bx-show me-1"></i> View</a>
                    @endif
                    @if (auth()->user()->role_id != 1)
                    <a class="dropdown-item text-primary small" role="button" wire:click="toInput('{{ $item->uuid }}')"><i class="bx bx-file me-1"></i>
                      Buat Ia</a>
                    @endif
                    <a href="{{route('laporan', ['MOA', $item->id])}}" class="dropdown-item text-primary small" role="button"><i class="bx bx-news me-1"></i>
                      Laporan</a>
                    @if (auth()->user()->role_id == 5)
                      @if (App\Models\NonProdiDataMoa::where('nomor_dok_unhas', $item->nomor_dok_unhas)->count('id') == 1)
                        <a class="dropdown-item text-danger small" role="button" wire:click="delete({{ $item->id }})"><i class="bx bx-trash me-1"></i>
                          Delete</a>
                      @endif
                    @else
                      @if (App\Models\DataMoa::where('nomor_dok_unhas', $item->nomor_dok_unhas)->count('id') == 1)
                      <a class="dropdown-item text-danger small" role="button" wire:click="delete({{ $item->id }})"><i class="bx bx-trash me-1"></i>
                        Delete</a>
                      @endif
                    @endif

                  </div>
                </div>
              </td>
              <td>
                <i class="fab fa-angular fa-lg text-danger"></i> <strong>{{ $item->tanggal_ttd }}</strong>
              </td>
              <td>{{ $item->nomor_dok_unhas }}</td>
              <td>{{ $item->tingkat == 1 ? 'Nasional':($item->tingkat == 2 ? 'Provensi/Regional':($item->tingkat == 3 ? 'Lokal/Kabupaten':($item->tingkat == 4 ? 'Internasional':''))) }}</td>
              <td class="text-wrap" style="font-size: 11px">
                @php
                    $shows = strtoupper(str_replace(str_split('[]"'), '', $item->penggiat));
                $shows= strtoupper(str_replace(',', ' / ', $shows))
                @endphp
                {{ substr($shows, 0, 70) }}
              </td>
              <td>
                {{ $item->getFakultas->nama_fakultas }}
              </td>
              {{-- @if (auth()->user()->role_id != 5) --}}
              <td class="text-wrap" style="font-size: 11px">
                @php
                    $show = strtoupper(str_replace(str_split('[]"'), '', $item->nama_prodi));
                $show = strtoupper(str_replace(',', ' / ', $show))
                @endphp
                {{ $show }}
                {{-- -----------------------
                {{ $item->nama_prodi }} --}}
              </td>
              {{-- @endif --}}
              <td>{{ $item->negara }}</td>
              <td>{{ $item->getJenisKerjasama->nama }}</td>
              <td class="text-wrap" style="font-size: 11px">
                {{ substr($item->judul, 0, 33) }}
              </td>
              <td>
                {{ $item->getStatusKerjasama->nama }}
              </td>
              
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="my-3">
          {{ $DataMoa->links() }}
        </div>
      </div>
      @endif
    </div>


  </div>
