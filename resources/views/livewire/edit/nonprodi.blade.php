<div>
    <div wire:loading>
        @include('livewire._includeLoading')
    </div>
    <div class="row">
        {{-- <div class="col-6 {{ auth()->user()->role_id == 4 ? 'd-block':'d-none' }}">
        </div> --}}
        <div class="col-6">
            <button class="btn btn-secondary my-3 form-control" onclick="javascript:history.go(-1)" >Back</button>
        </div>
        <div class="col-6">
            @if ($valz == 'MoA')
            <button class="btn btn-primary my-3 form-control" wire:click="update({{ $idEdit }})" >Update</button>
            @else
            <button class="btn btn-primary my-3 form-control" wire:click="updates({{ $idEdit }})" >Update</button>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card mb-1">
                <h5 class="card-header text-primary"><i class="bx bx-link me-3"></i>Jenis Kerjasama</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="col-auto my-2">
                        <label class="form-label">Pilih Jenis Kerjasama</label>
                        <select required wire:model="jenisKerjasamaField" id="jk" class="form-select form-select-sm
                            @error('jenisKerjasamaField') is-invalid @enderror ">
                            @foreach ($jenisKerjasama as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="{{ $jenisKerjasamaField == 2 ? 'd-none':'' }}">
                        <label class="form-label">Tingkat <i class="small text-danger">*</i> </label>
                        <select wire:model="tingkat" class="form-select form-select-sm @error('tingkat') is-invalid @enderror">
                            <option></option>
                            <option value="1">Nasional</option>
                            <option value="2">Provensi/Regional</option>
                            <option value="3">Lokal/Kabupaten</option>
                        </select>
                    </div>
                    <div class="{{ $jenisKerjasamaField == 1 ? 'd-none':'' }}">
                        <label class="form-label">Negara <i class="small text-danger">*</i> </label>
                        <select wire:model="negara" id="select2-negara" class="form-select form-select-sm">
                            <option></option>
                            @foreach ($negaraKerjasama as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="{{ $jenisKerjasamaField == 1 ? 'd-none':'' }}">
                        <label class="form-label">Region</label>
                        <select wire:model="region" style="display: block" class="form-select form-select-sm
                        @error('region') is-invalid @enderror">
                            <option></option>
                            @foreach ($regionKerjasama as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Tempat Pelaksana</label>
                        <input required wire:model.lazy="tempat_pelaksanaan" type="text"
                            class="form-control form-control-sm @error('tempat_pelaksanaan') is-invalid @enderror">
                    </div>
                </div>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <label class="form-label">Dokumen
                        <i class="small text-warning">* max 1 mb</i>
                    </label><br>
                    <input class="form-control form-control-sm @error('files') is-invalid @enderror" type="file"
                        wire:model="files" id="uploadFiles" multiple accept=".pdf"
                        onchange="checkFileUploadExt(this);" />
                    @if ($idEdit)
                    <ul>
                        @foreach ($findDokumen as $item)
                        <li>
                            <a class="m-1" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasStart{{ $loop->iteration }}" aria-controls="offcanvasStart">
                                Dokumen#{{ $loop->iteration }}
                            </a>
                        </li>
                        <div class="offcanvas offcanvas-start" style="width: 50%" tabindex="-1"
                            id="offcanvasStart{{ $loop->iteration }}" aria-labelledby="offcanvasStartLabel"
                            aria-hidden="true" style="visibility: hidden;">
                            <div class="offcanvas-header">
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                                <p>
                                    @if ($valz == 'MoA')
                                    <iframe src="{{ asset('storage/DokumenMoA/'.$item->url) }}"
                                        style="position:absolute;top:0;left:0;width:100%;height:100%;border:0"></iframe>
                                    @else
                                    <iframe src="{{ asset('storage/DokumenIA/'.$item->url) }}"
                                        style="position:absolute;top:0;left:0;width:100%;height:100%;border:0"></iframe>
                                    @endif

                                </p>
                            </div>
                        </div>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Merged -->
        <div class="col-md-4">
          <div class="card mb-4">
            <h5 class="card-header text-primary"><i class="bx bx-file me-3"></i>Jenis Dokumen Kerjasama</h5>
            <div class="card-body demo-vertical-spacing demo-only-element">
                <div wire:ignore>
                    <div class="{{ $jenis_dokumen_kerjasama == 2 ? 'd-block':'d-none'}}">
                        <div>
                            <label class="form-label" for="">Dasar Dokumen Kerjasama <i class="small text-danger">*</i></label>
                            <div >{{ $dasar_dokumen_kerjasama }}
                                <select wire:model="dasar_dokumen_kerjasama" style="width: 100%" class="form-select form-select-sm" id="select2-dropdown" >
                                    <option selected></option>
                                    <optgroup label="MoU">
                                        @foreach ($dasarDokKerjasama->sortBy('nomor_dok_unhas') as $item)
                                        @if ($item->id != 42)
                                        <option value="{{ $item->uuid }}">{{ $item->nomor_dok_unhas }} | {{ $item->judul }}</option>
                                        @endif
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="{{ $jenis_dokumen_kerjasama == 3 ? 'd-block':'d-none'}}">
                        <div>
                            <label class="form-label" for="">Dasar Dokumen Kerjasama <i class="small text-danger">*</i></label>
                            <div >
                                {{-- {{ $dasar_dokumen_kerjasama }} --}}
                                <select wire:model="dasar_dokumen_kerjasama" style="width: 100%" class="form-select form-select-sm" id="select2-dropdowns" >
                                    <option selected></option>
                                    <optgroup label="MoU">
                                        @foreach ($dasarDokKerjasama->sortBy('nomor_dok_unhas') as $item)
                                        @if ($item->id != 42)
                                        <option value="{{ $item->uuid }}">{{ $item->nomor_dok_unhas }} | {{ $item->judul }}</option>
                                        @endif
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="MoA">
                                        @foreach ($dasarDokKerjasama2->sortBy('nomor_dok_unhas') as $item)
                                        <option value="{{ $item->uuid }}">{{ $item->nomor_dok_unhas }} | {{ $item->judul }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto my-2">
                    <label class="form-label">Nomor Dok. Unhas</label>
                    {{-- <input wire:model.lazy="nomor_unhas" type="text" --}}
                    <input disabled wire:model.lazy="nomor_unhas" type="text"
                        class="form-control form-control-sm @error('nomor_unhas') is-invalid @enderror">
                </div>
                <div class="{{ $jenisKerjasamaField == 2 ? 'd-none':'' }}">
                    <label class="form-label">Nomor Dok. Mitra </label>
                    <input wire:model.lazy="nomor_mitra" type="text"
                        class="form-control form-control-sm @error('nomor_mitra') is-invalid @enderror">
                </div>
                <div>
                    <label class="form-label">Judul Kerjasama</label>
                    <input wire:model.lazy="judul_kerjasama" type="text"
                        class="form-control form-control-sm @error('judul_kerjasama') is-invalid @enderror">
                </div>
                <div>
                    <label class="form-label">Deskripsi <label>
                            <i class="small text-danger">
                                Ringkasan singkat terkait cakupan atau kegiatan kerja
                            </i>
                        </label>
                        <textarea wire:model.lazy="deskripsi"
                            class="form-control form-control-sm @error('deskripsi') is-invalid @enderror" cols="30"
                            rows="5"></textarea>
                </div>

            <div wire:ignore>
                <label class="mr-sm-2" for="inlineFormCustomSelect">Anggaran</label>
                <input wire:model.lazy="anggaran" id="anggaranz" type="text" class="form-control form-control-sm">
            </div>
            <script>
                var tanpa_rupiah2 = document.getElementById('anggaranz');
                    tanpa_rupiah2.addEventListener('keyup', function(e)
                    {
                        tanpa_rupiah2.value = formatRupiah(this.value);
                    });
            </script>
            <div>
                <label class="mr-sm-2">Sumber Dana</label>
                <select class="form-select form-select-sm" wire:model.lazy="sumber_dana">
                    <option></option>
                    @foreach ($sumberDana as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
                </select>
            </div>
            </div>
          </div>
        </div>

         <!-- Sizing -->
         <div class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header text-primary"><i class="bx bx-calendar me-3"></i>Masa Berlaku</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="col-auto my-2">
                        <label class="form-label">Tanggal TTD </label>
                        <input required wire:model.="tanggal_ttd" type="date"
                            class="form-control form-control-sm @error('tanggal_ttd') is-invalid @enderror">
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">Tanggal Awal</label>
                        <input required wire:model.lazy="tanggal_awal" type="date"
                            class="form-control form-control-sm @error('tanggal_awal') is-invalid @enderror">
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">Tanggal Berakhir</label>
                        <input required wire:model.lazy="tanggal_berakhir" type="date"
                            class="form-control form-control-sm @error('tanggal_berakhir') is-invalid @enderror">
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">Status</label>
                        <select required wire:model.lazy="status_kerjasama"
                            class="form-select form-select-sm @error('status_kerjasama') is-invalid @enderror">
                            <option></option>
                            @foreach ($statusKerjasama as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">Jangka Waktu <i class="small">(Tahun)</i></label>
                        <input required wire:model.lazy="jangka_waktu" type="number"
                            class="form-control form-control-sm @error('jangka_waktu') is-invalid @enderror">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-7 row">
            @foreach($inputs as $key => $value)
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header text-primary"><i class="bx bx-link me-3"></i>Pihak {{ $value+1 }}
                        @if ($key != 0 && end($inputs) == $key )
                        <button type="button" wire:click="takeArray({{ $key+1 }})" class="btn-sm btn" style="float: right"><i
                                class="bx bx-layer-plus h3 text-primary"></i></button>
                        @endif
                        @if ($key != 0 && $key != 1 && end($inputs) == $key)
                        <button type="button" wire:click="minArrayPihak({{ $key }})" class="btn-sm btn"
                            style="float: right"><i class="bx bx-layer-minus h3 text-danger"></i></button>
                        @endif
                    </h5>
                    <div class="card-body mt-0">
                        <div class="col-auto my-2">
                            <label class="mr-sm-2 mt-2 "><strong>Penggiat Kerjasama</strong> </label>
                            <div class="row">

                                <div class="col-sm-12 col-lg-7 my-2">
                                    <label class="mr-sm-2">Instansi <i class="small text-danger">*</i>
                                         @error('nama_pihak.'.$value) <i class="text-sm text-danger">* required</i> @enderror
                                    </label>
                                    <div wire:loading wire:target="nama_pihak.{{ $value }}" class="mx-1 spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                        <div class="btn-group col-12">
                                            <div class="input-group input-group-sm" data-bs-display="static" aria-haspopup="true" aria-expanded="true">
                                            <input placeholder="Ketik Untuk Mencari " {{ optional($lockInstansi)[$value] == 1 ? 'disabled':'' }}
                                                 wire:model="nama_pihak.{{ $key }}" type="text" class="form-control form-control-sm">
                                                 <span wire:click="clearLockInstansi({{ $key }})" class="input-group-text cursor-pointer {{ optional($lockInstansi)[$value] == 1 ? 'd-block':'d-none' }} "><i class="bx bx-x"></i></span>
                                                 <span onclick="addInstansi()" class="input-group-text cursor-pointer {{ optional($lockInstansi)[$value] == 1 ? 'd-none':'d-block' }}"><i class="bx bx-plus"></i></span>
                                            </div>
                                            @php
                                                $instansi = \App\Models\Intansi::where('nama_instansi', 'LIKE', '%'.optional($nama_pihak)[$value].'%')->paginate(10);
                                            @endphp
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start {{ optional($nama_pihak)[$value] ? (optional($lockInstansi)[$value] ? '':'show'):'' }}" data-bs-popper="static">
                                                @forelse($instansi as $item)
                                                <li><button wire:click="pushNamaInstansi({{ $key }},{{ $item->id }},'{{ $item->nama_instansi }}',{{ $item->status }})" class="small dropdown-item" type="button">{{ strtoupper($item->nama_instansi) }}</button></li>
                                                @empty
                                                <li role="button" onclick="addInstansi()" class="p-2 small">Instansi Belum tersedia, Klik untuk menambahkan</li>
                                                @endforelse
                                            </ul>
                                        </div>
                                </div>

                                <div class="col-sm-12 col-lg-5 my-2">
                                    <label class="mr-sm-2">Status</label>
                                    <select wire:model="status.{{ $value }}" disabled
                                        class="form-select form-select-sm mr-sm-2 ">
                                        <option></option>
                                        <option value="1">Perguruan Tinggi Negeri</option>
                                        <option value="2">Perguruan Tinggi Swasta</option>
                                        <option value="4">Perguruan Tinggi Luar Negeri</option>
                                        <option value="3">Mitra</option>
                                    </select>
                                </div>


                                <div class="col-sm-12 col-lg-5 my-2 {{ optional($status)[$value] == 1 ? 'd-block':(optional($status)[$value] == 4 ? 'd-block':'') }}" style="display: none">
                                    <label class="mr-sm-2">PTQS <i class="small text-danger">*</i>
                                        @error('ptqs.'.$value) <i class="text-sm text-danger">* required</i> @enderror
                                    </label>
                                    <select wire:model="ptqs.{{ $value }}" class="form-select form-select-sm mr-sm-2">
                                        <option value=""></option>
                                        <option value="0">Tidak</option>
                                        <option value="1">PTQS 100</option>
                                        <option value="2">PTQS 200</option>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-lg-7 my-2 {{ optional($status)[$value] == 1 ? 'd-block':(optional($status)[$value] == 4 ? 'd-block':'') }}" style="display: none">
                                    <label class="mr-sm-2">Cek Ranking</label>
                                    <a href="https://www.topuniversities.com/subject-rankings/2022" target="blank" class="form-control btn btn-sm btn-secondary">click</a>
                                </div>

                                <div class="col-sm-12 col-lg-5 my-2 {{ optional($status)[$value] == 3 ? 'd-block':'' }}" style="display: none">
                                    <select wire:model="badanKemitraan.{{ $value }}" class="form-select form-select-sm mr-sm-2 @error('badanKemitraan.'.$value) is-invalid @enderror">
                                        <option value=""></option>
                                        <option value="1">Perusahaan Nasional</option>
                                        <option value="2">Perusahaan Multinasional</option>
                                        <option value="3">Institusi Pemerintahan (kementrian)</option>
                                        <option value="4">Pemerintah Daerah (Provinsi/Kabupaten)</option>
                                        <option value="5">BUMN / BUMD</option>
                                        <option value="99">Lainnya</option>
                                    </select>
                                </div>

                                <div class="col-12 my-2 {{ optional($status)[$value] == 3 ? (optional($badanKemitraan)[$value] == 99 ? 'd-block':''):''  }}" style="display: none">
                                    <input wire:model="lainnya.{{ $value }}" type="text" placeholder="sebutkan"
                                        class="form-control form-control-sm @error('lainnya.'.$value) is-invalid @enderror">
                                </div>
                            </div>
                        </div>
                        @if (optional($nama_pihak)[$key] == 'Universitas Hasanuddin')
                            <label class="mr-sm-2">Fakultas <i class="small text-danger">*</i></label>
                            <select wire:model="fakultas_pihak.{{ $value }}" class="form-select form-select-sm mr-sm-2" disabled>
                                <option></option>
                                @foreach ($fakultas as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_fakultas }}</option>
                                @endforeach
                            </select>
                            <div class="col-auto my-2">
                                <div>
                                    <label class="mr-sm-2">Prodi <i class="small text-danger">*</i>
                                        @error('prodiPihak.'.$value) <i class="text-sm text-danger">* required</i> @enderror
                                    </label>

                                    <div class="row col-12">
                                        @php
                                            // if (auth()->user()->role_id != 1) {
                                                $prodiMitras = \App\Models\Prodi::where('id_fakultas', auth()->user()->fakultas_id)->get();
                                            // } else {
                                            //     $prodiMitras = \App\Models\ProdiMitra::where('nama_resmi', 'LIKE', '%'.optional($searchProdiMitra)[$value].'%')->paginate(10);
                                            // }
                                        @endphp
                                        <div class="btn-group col-12">
                                            <div class="input-group input-group-sm" data-bs-display="static" aria-haspopup="true" aria-expanded="true">
                                            <input placeholder="Ketik Untuk Mencari "
                                                 wire:model.debounce.1s="searchProdiMitra.{{ $value }}" type="text" class="form-control form-control-sm">
                                            </div>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start {{ optional($searchProdiMitra)[$value] ? 'show':'' }}" data-bs-popper="static">
                                                @foreach($prodiMitras as $item)
                                                <li><button wire:click="pushProdiMitra({{ $key }},{{ $item->id }},'{{ $item->nama_resmi }}')" class="small dropdown-item
                                                    " type="button">{{ strtoupper($item->nama_resmi) }}</button></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-12 row">
                                            @if (isset($prodiPihak[$key]))
                                            @foreach($prodiAll->whereIn('id',$prodiPihak[$key]) as $item)
                                            {{-- @foreach($getProdiMitras->whereIn('id',$prodiPihak[$key]) as $item) --}}
                                            <div class="input-group input-group-sm my-1" style="width: 50%">
                                                {{-- <span role="button" wire:click="unsetFakultas({{ $key }},{{ $item->id }})" class=" small input-group-text
                                                    {{ $item->id == auth()->user()->prodi_id ? 'd-none':($item->id == $prodiEx ? 'd-none':'') }}">X</span> --}}
                                                <span role="button" wire:click="unsetFakultas({{ $key }},{{ $item->id }})" class=" small input-group-text">X</span>
                                                <input type="text" class="form-control form-control-sm" disabled placeholder="{{ $item->nama_resmi }}">
                                              </div>
                                            @endforeach
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                        <div class="col-auto my-2">
                            <div class="
                                    @switch($status[$value]??null)
                                        @case(3)
                                            d-none
                                            @break
                                        @default
                                    @endswitch
                                ">

                                <label class="mr-sm-2">Fakultas <i class="small text-danger">*</i>
                                    @error('fakultas_pihak.'.$value) <i class="text-sm text-danger">* required</i> @enderror
                               </label>
                                   <div class="btn-group col-12">
                                       <div class="input-group input-group-sm" data-bs-display="static" aria-haspopup="true" aria-expanded="true">
                                       <input placeholder="Ketik Untuk Mencari " {{ optional($lockFakultas)[$value] == 1 ? 'disabled':'' }}
                                            wire:model="nama_fakultas.{{ $key }}" type="text" class="form-control form-control-sm">
                                            <span wire:click="clearLockFakultas({{ $key }})" class="input-group-text cursor-pointer {{ optional($lockFakultas)[$value] == 1 ? 'd-block':'d-none' }} "><i class="bx bx-x"></i></span>
                                            <span onclick="addFakultasMitra()" class="input-group-text cursor-pointer {{ optional($lockFakultas)[$value] == 1 ? 'd-none':'d-block' }}"><i class="bx bx-plus"></i></span>
                                       </div>
                                       @php
                                           $fakultas22 = \App\Models\FakultasPihak::where('nama_fakultas', 'LIKE', '%'.optional($nama_fakultas)[$value].'%')->paginate(10);
                                       @endphp
                                       <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start {{ optional($nama_fakultas)[$value] ? (optional($lockFakultas)[$value] ? '':'show'):'' }}" data-bs-popper="static">
                                           @forelse($fakultas22 as $item)
                                           <li><button wire:click="pushNamaFakultas({{ $key }},{{ $item->id }},'{{ $item->nama_fakultas }}')" class="small dropdown-item" type="button">{{ strtoupper($item->nama_fakultas) }}</button></li>
                                           @empty
                                           <li role="button" onclick="addFakultas()" class="p-2 small">Fakultas Belum tersedia, Klik untuk menambahkan</li>
                                           @endforelse
                                       </ul>
                                   </div>
                            </div>
                        </div>
                        <div class="col-auto my-2">
                            <div class="
                                    @switch($status[$value]??null)
                                        @case(3)
                                            d-none
                                            @break
                                        @default
                                    @endswitch
                                ">
                                <label class="mr-sm-2">Prodi <i class="small text-danger">*</i>
                                    @error('prodiPihak.'.$value) <i class="text-sm text-danger">* required</i> @enderror
                                </label>

                                <div class="row col-12">
                                    @php
                                        $prodiMitras = \App\Models\ProdiMitra::where('nama_resmi', 'LIKE', '%'.optional($searchProdiMitra)[$value].'%')->paginate(10);
                                    @endphp
                                    <div class="btn-group col-12">
                                        <div class="input-group input-group-sm" data-bs-display="static" aria-haspopup="true" aria-expanded="true">
                                        <input placeholder="Ketik Untuk Mencari "
                                             wire:model="searchProdiMitra.{{ $value }}" type="text" class="form-control form-control-sm">
                                        <span onclick="addProdiMitra()" class="input-group-text cursor-pointer"><i class="bx bx-plus"></i></span>
                                        </div>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start {{ optional($searchProdiMitra)[$value] ? 'show':'' }}" data-bs-popper="static">
                                                    @foreach($prodiMitras as $item)
                                                    <li><button wire:click="pushProdiMitra({{ $key }},{{ $item->id }},'{{ $item->nama_resmi }}')" class="small dropdown-item" type="button">{{ strtoupper($item->nama_resmi) }}</button></li>
                                                    @endforeach

                                        </ul>
                                    </div>
                                    <div class="col-12 row">
                                        @if (isset($prodiPihak[$key]))
                                        @foreach($getProdiMitras->whereIn('id',$prodiPihak[$key]) as $item)
                                        <div class="input-group input-group-sm my-1" style="width: 50%">
                                            <span role="button" wire:click="unsetFakultas({{ $key }},{{ $item->id }})" class=" small input-group-text">X</span>
                                            <input type="text" class="form-control form-control-sm" disabled placeholder="{{ $item->nama_resmi }}">
                                          </div>
                                        @endforeach
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-auto my-2">
                            <label class="mr-sm-2">Alamat Instansi <i class="small text-danger">*</i>
                                @error('alamat_pihak.'.$value) <i class="text-sm text-danger">* required</i> @enderror
                            </label>
                            <input wire:model.defer="alamat_pihak.{{ $value }}" type="text"
                                class="form-control form-control-sm">
                        </div>
                        <div class="col-auto my-2">
                            <label class="mr-sm-2 mt-2 "><strong>Penandatangan</strong></label>&nbsp;
                            <i class="small text-danger">
                                *Pejabat yang menandatangani dokumen
                            </i>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <label class="mr-sm-2">Nama <i class="small text-danger">*</i>
                                        @error('nama_pejabat_pihak.'.$value) <i class="text-sm text-danger">* required</i> @enderror
                                    </label>
                                    <input wire:model.defer="nama_pejabat_pihak.{{ $value }}" type="text"
                                        class="form-control form-control-sm">
                                </div>
                                <div class="col-sm-12 col-lg-6">

                                    <label class="mr-sm-2">Jabatan</label>
                                    <input wire:model.defer="jabatan_pejabat_pihak.{{ $value }}" type="text"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto my-2">
                            <label class="mr-sm-2 mt-2 "><strong>Penanggung Jawab</strong> </label>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <label class="mr-sm-2">Nama
                                        @error('pj_pihak.'.$value) <i class="text-sm text-danger">* required</i> @enderror
                                    </label>
                                    <input wire:model.defer="pj_pihak.{{ $value }}" type="text"
                                        class="form-control form-control-sm">
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <label class="mr-sm-2">Jabatan</label>
                                    <input wire:model.defer="jabatan_pj_pihak.{{ $value }}" type="text"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <label class="mr-sm-2 mt-1">Email
                                        @error('email_pj_pihak.'.$value) <i class="text-sm text-danger">* required</i> @enderror
                                    </label>
                                    <input wire:model.defer="email_pj_pihak.{{ $value }}" type="email"
                                        class="form-control form-control-sm">
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <label class="mr-sm-2 mt-1">No. HP
                                        @error('hp_pj_pihak.'.$value) <i class="text-sm text-danger">* required</i> @enderror
                                    </label>
                                    <input wire:model.defer="hp_pj_pihak.{{ $value }}" type="number"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
</div>
<div class="col-sm-12 col-lg-5">
    <div class="card mb-4">
        <h5 class="card-header text-primary"><i class="bx bx-unite me-3"></i>Bentuk Kegiatan

    </h5>
        <div class="card-body">
            <div class="col-auto my-2">
                <div class="col-sm-12">
                    <label>SDGS @error('arraySdgs') <i class="small text-danger">*{{$message}}</i> @enderror</label>
                </div>
                <div class="col-sm-12">
                    <select class="form-select form-select-sm" aria-hidden="true" wire:model="sdgs">
                        <option></option>
                        @foreach ($getSdgs as $itemz)
                            {{-- <option value="{{ $itemz->uuid }}">{{ $itemz->id }} | {{ rtrim(Str::words($itemz->nama, 9)) . '...' }}</option> --}}
                            <option value="{{ $itemz->id }}">{{ $itemz->id }} | {{ $itemz->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if ($arraySdgs)
                @foreach ($arraySdgs as $key => $item)
                    <p><i class="bx bx-x btn btn-sm btn-secondary" wire:click="minArraySdgs('{{$key}}')" role="button"></i> {{$item}} | {{$getSdgs->find($item)->nama}}</p>
                @endforeach
            @endif
            <div class="col-auto my-2">
                <div class="col-sm-12">
                    <label class="@error('arrayBentukKegiatan') text-danger @enderror">Bentuk Kegiatan Kerjasama <i class="small text-danger">*</i></label>
                </div>
                <select wire:model="bentukKegiatan" class="form-select form-select-sm mr-sm-2 @error('arrayBentukKegiatan') is-invalid @enderror">
                    <option value="0"></option>
                    @foreach ($getBentukKegiatan as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            @forelse ($arrayBentukKegiatan as $key => $item)
            <div class="card my-1">
                <label class="m-1">
                    <button type="button" wire:click="minArrayBentuk({{ $key }})" class="btn-sm btn text-danger"
                        style="float: right"><i class="bx bx-layer-minus"></i></button>
                </label>
                <label class="mx-3"><i class="bx bx-bullseye me-2"></i>{{ $getBentukKegiatan->find($item)->nama
                    }}
                </label>

                <div class="card-body">
                    <div class="col-auto my-1">
                        <div class="col-sm-12">
                            <label class="@error('nilai_kontrak.'.$key) text-danger @enderror">Nilai kontrak</label>
                            <div class="text-muted small m-b-xs mb-1">Nominal nilai kontrak proposal</div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">Rp.</span>
                                <input type="text" wire:model.lazy="nilai_kontrak.{{ $key }}" class="form-control form-control-sm" id="format{{ $key }}" placeholder="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-auto my-1">
                        <div class="col-sm-12"><label>Luaran</label></div>
                        <div class="col-sm-12">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text @error('volume_luaran.'.$key) text-danger @enderror">Volume</span>
                                <input type="number" class="form-control form-control-sm" wire:model.lazy="volume_luaran.{{ $key }}" placeholder="0">
                                <span class="input-group-text @error('volume_satuan.'.$key) text-danger @enderror">@</span>
                                <input type="text" class="form-control form-control-sm" wire:model.lazy="volume_satuan.{{ $key }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-auto my-1">
                        <div class="col-sm-12">
                            <label class="@error('keterangan.'.$key) text-danger @enderror">Keterangan</label>
                            <div class="text-muted small m-b-xs mb-1">Ringkasan luaran dari kegiatan</div>
                        </div>
                        <div class="col-sm-12">
                            <textarea wire:model.lazy="keterangan.{{ $key }}" rows="3" class="form-control form-control-sm"></textarea>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="col-sm-12">
                            <label class="@error('arraySasaran.'.$key) text-danger @enderror"s>Sasaran</label>

                        </div>
                        <div class="col-sm-12">
                            <select wire:model="arraySasaran.{{ $key }}" class="form-select form-select-sm" aria-hidden="true">
                                <option></option>
                                @foreach ($getSasaranKegiatan as $items)
                                <option value="{{ $items->id }}">{{ $items->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="col-sm-12">
                            <label class="@error('arrayKinerja.'.$key) text-danger @enderror">Indikator Kinerja</label>
                        </div>
                        <div class="col-sm-12">
                            <select class="form-select form-select-sm" aria-hidden="true" wire:model="arrayKinerja.{{ $key }}">
                                <option></option>
                                @foreach ($getIndikatorKinerja->where('id_sasaran_kegiatan',$arraySasaran[$key]??null) as $itemz)
                                    <option value="{{ $itemz->id }}">{{ $itemz->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-auto">
                        <div class="col-sm-12">
                            <label class="@error('arraySdgs.'.$key) text-danger @enderror">SDGS <i class="small text-danger">*</i></label>
                        </div>
                        <div class="col-sm-12">
                            <select class="form-select form-select-sm" aria-hidden="true" wire:model="arraySdgs.{{ $key }}">
                                <option></option>
                                @foreach ($getSdgs as $itemz)
                                    <option value="{{ $itemz->id }}">{{ $itemz->id }} | {{ $itemz->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                </div>
            </div>
            <script>
                var tanpa_rupiah = document.getElementById('format{{ $key }}');
                    tanpa_rupiah.addEventListener('keyup', function(e)
                    {
                        tanpa_rupiah.value = formatRupiah(this.value);
                    });
            </script>
            @empty
            <label class="my-2 text-warning">Belum Memilih Bentuk Kegiatan</label>
            @endforelse
        </div>
    </div>
</div>
<div>
    <label class="m-3">
        <ul>
            <li class="small">
                created by : {{ $upBy }}
            </li>
            <li class="small">
                last update by : {{ $editBy }}
            </li>
        </ul>
    </label>
</div>
    </div>

@push('custom-scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}

<script>
    function checkFileUploadExt(fieldObj) {
        var control = document.getElementById("uploadFiles");
        var filelength = control.files.length;

        for (var i = 0; i < control.files.length; i++) {
            var file = control.files[i];
            var FileName = file.name;
            var FileExt = FileName.substr(FileName.lastIndexOf('.') + 1); // pdf
            let ext = FileName.endsWith('.pdf') // true
            if (!ext) {
                $(uploadFiles).val(''); //for clearing with Jquery
                swal.fire('File Harus dalam Format PDF');
            } else {
                const fileSize = file.size / 1024 / 1024; // in MiB
                // console.log(fileSize);
                if (fileSize > 1) {
                    // alert('File size Maksimal Berukuran 1 MiB');
                    // alert('pesan' => 'Data Duplikat', 'icon'=>'error');
                    $(uploadFiles).val(''); //for clearing with Jquery
                    swal.fire('File size Maksimal Berukuran 1 MiB');
                } else {
                    Livewire.emit('successMe')
                    // console.log(control.value);
                }
            }

        }
    }

    window.addEventListener('bersih', event => {
        document.getElementById('bersih2').value= null;
    })

    $(document).ready(function () {
        $('#select2-negara').select2();
        $('#select2-negara').on('change', function (e) {
            var data = $('#select2-negara').select2("val");
            @this.set('negara', data);
        });
    });

    window.addEventListener('contentChanged', event => {
            $(document).ready(function () {
                $('#select2-negara').select2();
                $('#select2-negara').on('change', function (e) {
                    var data = $('#select2-negara').select2("val");
                    @this.set('negara', data);
                });
            });
        });

    $(document).ready(function () {
        $('#select2-dropdown').select2();
        $('#select2-dropdown').on('change', function (e) {
            var data = $('#select2-dropdown').select2("val");
            @this.set('dasar_dokumen_kerjasama', data);
        });
    });

    $(document).ready(function () {
        $('#select2-dropdowns').select2();
        $('#select2-dropdowns').on('change', function (e) {
            var data = $('#select2-dropdowns').select2("val");
            @this.set('dasar_dokumen_kerjasama', data);
        });
    });

    window.livewire.on('alerts', param => {
        // alert(param['pesan'])
        let timerInterval
        Swal.fire({
        icon: param['icon'],
        title: param['pesan'],
        // html: 'I will close in <b></b> milliseconds.',
        timer: 1500,
        timerProgressBar: true,
        onBeforeOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {
            const content = Swal.getContent()
            if (content) {
                const b = content.querySelector('b')
                if (b) {
                b.textContent = Swal.getTimerLeft()
                }
            }
            }, 100)
        },
        onClose: () => {
            // window.location.reload();
            // window.history.back();
            // clearInterval(timerInterval)
        }
        }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
        }
        })
    })
    window.livewire.on('alerts2', param => {
        // alert(param['pesan'])
        let timerInterval
        Swal.fire({
        icon: param['icon'],
        title: param['pesan'],
        // html: 'I will close in <b></b> milliseconds.',
        timer: 1500,
        timerProgressBar: true,
        onBeforeOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {
            const content = Swal.getContent()
            if (content) {
                const b = content.querySelector('b')
                if (b) {
                b.textContent = Swal.getTimerLeft()
                }
            }
            }, 100)
        },
        onClose: () => {
            // window.location.reload();
            window.history.back();
            // clearInterval(timerInterval)
        }
        }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
        }
        })
    })


    function addProdiMitra()
        {
            (async () => {
            const { value: prodiMitra } = await Swal.fire({
            input: 'text',
            inputLabel: 'Tambah Prodi Mitra',
            showCancelButton: true
            })

            if (prodiMitra) {
            // Swal.fire(`Entered Mitra: ${prodiMitra}`)
            Livewire.emit('addProdiMitra',prodiMitra)
            }else{
            Swal.fire(`Data Tidak Valid`)
            }
            })()
        }

        function addFakultasMitra()
        {
            (async () => {
            const { value: fakultasMitra } = await Swal.fire({
            input: 'text',
            inputLabel: 'Tambah Fakultas Mitra',
            showCancelButton: true
            })

            if (fakultasMitra) {
            // Swal.fire(`Entered Mitra: ${prodiMitra}`)
            Livewire.emit('addFakultasMitra',fakultasMitra)
            }else{
            Swal.fire(`Data Tidak Valid`)
            }
            })()
        }

        function addInstansi()
        {
            (async () => {
            const { value: instansi } = await Swal.fire({
            input: 'text',
            inputLabel: 'Tambah Nama Instansi',
            showCancelButton: true
            })

            if (instansi) {
            // Swal.fire(`Entered Mitra: ${prodiMitra}`)
            // Livewire.emit('addInstansi',instansi)
                    const { value: status } = await Swal.fire({
                    input: 'select',
                    inputLabel: 'Status Instansi',
                    inputOptions: {
                        '1': 'Perguruan Tinggi Negeri',
                        '2': 'Perguruan Tinggi Swasta',
                        '4': 'Perguruan Tinggi Luar Negeri',
                        '3': 'Mitra',
                    }
                    })

                    if (status) {
                    // Swal.fire(`Entered Mitra: ${prodiMitra}`)
                    Livewire.emit('addInstansi', instansi, status)
                    console.log(status);
                    }else{
                    Swal.fire(`Data Tidak Valid`)
                    }

            }else{
            Swal.fire(`Data Tidak Valid`)
            }
            })()
        }

    /* Fungsi */
        function formatRupiah(angka)
        {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split    = number_string.split(','),
                sisa     = split[0].length % 3,
                rupiah     = split[0].substr(0, sisa),
                ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }
    </script>



@endpush

</div>
