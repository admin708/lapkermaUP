<div>
    <form wire:submit.prevent="submit">
        <div class="container">

            <!-- Checkbox to toggle upload document -->
            <div class="col-md-12 mb-4">
                <input type="checkbox" id="uploadMoUCheckbox" wire:model="uploadDocument">
                <label for="uploadMoUCheckbox">Use Our MoU Document Template</label>
            </div>

            <div class="row">
                <!-- Basic -->
                <div class="col-12 {{ $idEdit == false ? 'd-none' : '' }} ">
                    <button class="btn btn-primary my-3 form-control" wire:click="saveEdit('{{ $idEdit }}')">Simpan
                        Perubahan</button>
                </div>

                <div class="col-md-4">
                    <div class="card mb-1">
                        <h5 class="card-header text-primary"><i class="bx bx-link me-3"></i>Jenis Kerjasama</h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <div class="col-auto my-2">
                                <label class="form-label">Pilih Jenis Kerjasama <i class="text-danger">*</i></label>
                                <div wire:loading wire:target="jenisKerjasamaField"
                                    class="mx-1 spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <select required wire:model="jenisKerjasamaField" id="jk"
                                    class="form-select form-select-sm
                            @error('jenisKerjasamaField') is-invalid @enderror ">
                                    @foreach ($jenisKerjasama as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('jenisKerjasamaField')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="{{ $jenisKerjasamaField == 1 ? 'd-none' : '' }}">
                                <label class="form-label">Negara <i class="small text-danger">*</i> </label>
                                <select wire:model="negara" id="select2-negara" class="form-select form-select-sm">
                                    <option></option>
                                    @foreach ($negaraKerjasama as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('negara')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="{{ $jenisKerjasamaField == 1 ? 'd-none' : '' }}">
                                <label class="form-label">Region <i class="text-danger">*</i></label>
                                <select wire:model="region" style="display: block"
                                    class="form-select form-select-sm
                        @error('region') is-invalid @enderror">
                                    <option></option>
                                    @foreach ($regionKerjasama as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Tempat Pelaksana <i class="text-danger">*</i></label>
                                <input required wire:model.defer="tempat_pelaksanaan" type="text"
                                    class="form-control form-control-sm @error('tempat_pelaksanaan') is-invalid @enderror">
                                @error('tempat_pelaksanaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @unless ($uploadDocument)
                                <div>
                                    <label class="form-label">Dokumen
                                        <i class="small text-warning">* max 1 mb</i>
                                    </label><br>
                                    <input class="form-control form-control-sm @error('files') is-invalid @enderror"
                                        type="file" wire:model="files" id="uploadFiles2" multiple accept=".pdf"
                                        onchange="checkFileUploadExt2(this);" />
                                    @if ($showLoadFiles)
                                        <div wire:loading wire:target="files">
                                            @include('livewire._includeLoading')
                                        </div>
                                    @endif
                                    @error('files')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endunless
                            @if ($uploadDocument)
                                <div>
                                    <label class="form-label">Scope <i class="text-danger">*</i></label>
                                    <ul>
                                        @foreach ($scopeList as $index => $scopeItem)
                                            <li>
                                                {{ $scopeItem }}
                                                <i class="text-danger bx bx-trash-alt" style="cursor:pointer;"
                                                    wire:click="removeScope({{ $index }})"></i>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="input-group mb-2">
                                        <input type="text" wire:model="newScopeItem"
                                            class="form-control form-control-sm @error('newScopeItem') is-invalid @enderror"
                                            placeholder="Add new scope">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            wire:click="addScope">Add</button>
                                    </div>
                                    <small class="text-muted mt-2">You can add, remove, or edit the scope as
                                        needed.</small>
                                </div>
                                @error('scopeList')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                        {{-- <div class="col-auto my-2">
                    
                </div> --}}
                        {{-- <div class="card-body demo-vertical-spacing demo-only-element">
                    
                </div> --}}
                    </div>
                </div>

                <!-- Merged -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <h5 class="card-header text-primary"><i class="bx bx-file me-3"></i>Jenis Dokumen Kerjasama</h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <div class="col-auto my-2">
                                <label class="form-label">Nomor Dok. Unhas <i class="text-danger">*</i></label>
                                <input wire:model.defer="nomor_unhas" type="text"
                                    class="form-control form-control-sm 
                            {{ $nomorSistem == 1 ? 'd-none' : 'd-block' }}
                            @error('nomor_unhas') is-invalid @enderror">
                                @error('nomor_unhas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div
                                    class="form-check form-switch mb-2 {{ $idEdit ? 'd-none' : ($jenisKerjasamaField == 2 ? 'd-block' : 'd-none') }}">
                                    <input class="form-check-input" type="checkbox" wire:model="nomorSistem">
                                    <label class="form-check-label">
                                        <i class="small"> <i class="text-danger">*</i>gunakan nomor sistem jika nomor
                                            dokumen tidak ada</i>
                                    </label>
                                    @error('nomorSistem')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="{{ $jenisKerjasamaField == 2 ? 'd-none' : '' }}">
                                <label class="form-label">Nomor Dok. Mitra <i class="text-danger">*</i></label>
                                <input required wire:model.defer="nomor_mitra" type="text"
                                    class="form-control form-control-sm 
                            @error('nomor_mitra') is-invalid @enderror">
                                @error('nomor_mitra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Judul Kerjasama <i class="text-danger">*</i></label>
                                <input required wire:model.defer="judul_kerjasama" type="text"
                                    class="form-control form-control-sm @error('judul_kerjasama') is-invalid @enderror">
                                @error('judul_kerjasama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Deskripsi <i class="text-danger">*</i><label>
                                        <i class="small text-danger">
                                            Ringkasan singkat terkait cakupan atau kegiatan kerja
                                        </i>
                                    </label>
                                    <textarea required wire:model.defer="deskripsi"
                                        class="form-control form-control-sm @error('deskripsi') is-invalid @enderror" cols="30" rows="5"></textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                <label class="form-label">Tanggal TTD <i class="text-danger">*</i></label>
                                <input required wire:model.defer="tanggal_ttd" type="date"
                                    class="form-control form-control-sm @error('tanggal_ttd') is-invalid @enderror">
                                @error('tanggal_ttd')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Tanggal Awal <i class="text-danger">*</i></label>
                                <input required wire:model.defer="tanggal_awal" type="date"
                                    class="form-control form-control-sm @error('tanggal_awal') is-invalid @enderror">
                                @error('tanggal_awal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Tanggal Berakhir <i class="text-danger">*</i></label>
                                <input required wire:model.defer="tanggal_berakhir" type="date"
                                    class="form-control form-control-sm @error('tanggal_berakhir') is-invalid @enderror">
                                @error('tanggal_berakhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Status <i class="text-danger">*</i></label>
                                <select required wire:model.defer="status_kerjasama"
                                    class="form-select form-select-sm @error('status_kerjasama') is-invalid @enderror">
                                    <option></option>
                                    @foreach ($statusKerjasama as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('status_kerjasama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Jangka Waktu <i class="small">(Tahun)</i> <i
                                        class="text-danger">*</i></label>
                                <select required wire:model.defer="jangka_waktu"
                                    class="form-control form-control-sm @error('jangka_waktu') is-invalid @enderror">
                                    <option value="">Pilih Jangka Waktu</option>
                                    @foreach (range(1, 5) as $year)
                                        <option value="{{ $year }}">{{ $year }} Tahun</option>
                                    @endforeach
                                </select>
                                @error('jangka_waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 col-lg-7">
                    @foreach ($inputs as $key => $value)
                        <div class="col-md-12">
                            <div class="card mb-4" style="display: {{ $value <= $arrayJawaban ? 'block' : 'none' }}">
                                <h5 class="card-header text-primary"><i class="bx bx-link me-3"></i>Pihak
                                    {{ $value + 1 }} {{ $value == 0 ? '(UNHAS)' : '(PARTNER)' }}
                                    @if ($arrayJawaban != 0 && $arrayJawaban == $value)
                                        <button type="button" wire:click="takeArray" class="btn-sm btn"
                                            style="float: right"><i
                                                class="bx bx-layer-plus h3 text-primary"></i></button>
                                    @endif
                                    @if ($arrayJawaban != 1 && $arrayJawaban == $value)
                                        <button type="button" wire:click="minArrayPihak({{ $key }})"
                                            class="btn-sm btn" style="float: right"><i
                                                class="bx bx-layer-minus h3 text-danger"></i></button>
                                    @endif
                                </h5>
                                <div class="card-body mt-0">
                                    <div class="col-auto my-2">
                                        <label class="mr-sm-2 mt-2 "><strong>Penggiat Kerjasama</strong> </label>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-5 my-2">
                                                <label class="mr-sm-2">Status <i class="text-danger">*</i></label>
                                                <div wire:loading wire:target="status.{{ $value }}"
                                                    class="mx-1 spinner-border spinner-border-sm text-primary"
                                                    role="status">
                                                    @error('status.{{ $value }}')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div wire:loading wire:target="badanKemitraan.{{ $value }}"
                                                    class="mx-1 spinner-border spinner-border-sm text-primary"
                                                    role="status">
                                                    @error('badanKemitraan.{{ $value }}')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <select wire:model="status.{{ $value }}"
                                                    class="form-select form-select-sm mr-sm-2 @error('status.' . $value) is-invalid @enderror">
                                                    <option></option>
                                                    <option value="1">Perguruan Tinggi Negeri</option>
                                                    <option value="2">Perguruan Tinggi Swasta</option>
                                                    <option value="4">Perguruan Tinggi Luar Negeri</option>
                                                    <option value="3">Mitra</option>
                                                </select>
                                                @error('status.' . $value)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-sm-12 col-lg-7 my-2">
                                                <label class="mr-sm-2">Nama Instansi <i
                                                        class="text-danger">*</i></label>
                                                <input wire:model="nama_pihak.{{ $value }}" type="text"
                                                    class="form-control form-control-sm @error('nama_pihak.' . $value) is-invalid @enderror">
                                                @error('nama_pihak.' . $value)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-sm-12 col-lg-5 my-2 {{ optional($status)[$value] == 1 ? 'd-block' : (optional($status)[$value] == 4 ? 'd-block' : '') }}"
                                                style="display: none">
                                                <label class="mr-sm-2">PTQS 100</label>
                                                <select wire:model="ptqs.{{ $value }}"
                                                    class="@error('ptqs.' . $value) is-invalid @enderror form-select form-select-sm mr-sm-2">
                                                    <option value=""></option>
                                                    <option value="1">Ya</option>
                                                    <option value="2">Tidak</option>
                                                </select>
                                                @error('ptqs.' . $value)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-sm-12 col-lg-7 my-2 {{ optional($status)[$value] == 1 ? 'd-block' : (optional($status)[$value] == 4 ? 'd-block' : '') }}"
                                                style="display: none">
                                                <label class="mr-sm-2">Cek Ranking</label>
                                                <a href="https://www.topuniversities.com/subject-rankings/2022"
                                                    target="blank"
                                                    class="form-control btn btn-sm btn-secondary">click</a>
                                            </div>

                                            <div class="col-sm-12 col-lg-5 my-2 {{ optional($status)[$value] == 3 ? 'd-block' : '' }}"
                                                style="display: none">
                                                <select wire:model="badanKemitraan.{{ $value }}"
                                                    class="form-select form-select-sm mr-sm-2 @error('badanKemitraan.' . $value) is-invalid @enderror">
                                                    <option value=""></option>
                                                    @foreach ($badanKemitraanOptions as $option)
                                                        <option value="{{ $option->id }}">{{ $option->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('badanKemitraan.{{ $value }}')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="col-12 my-2 {{ optional($status)[$value] == 3 ? (optional($badanKemitraan)[$value] == 99 ? 'd-block' : '') : '' }}"
                                                style="display: none">
                                                <input wire:model="lainnya.{{ $value }}" type="text"
                                                    placeholder="sebutkan"
                                                    class="form-control form-control-sm @error('lainnya.' . $value) is-invalid @enderror">
                                                @error('lainnya.{{ $value }}')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto my-2">
                                        <div
                                            class="
                                    @switch($status[$value]??null)
                                        @case(3)
                                            d-none
                                            @break
                                        @default
                                    @endswitch
                                ">
                                            <label class="mr-sm-2">Universitas/Fakultas <i
                                                    class="text-danger">*</i></label>
                                            <select wire:model="fakultas_pihak.{{ $value }}"
                                                class="form-select form-select-sm mr-sm-2 @error('fakultas_pihak.' . $value) is-invalid @enderror"
                                                id="status{{ $value }}">
                                                <option></option>
                                                @foreach ($fakultas as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama_fakultas }}
                                                    </option>
                                                @endforeach
                                                @error('fakultas_pihak.' . $value)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-auto my-2">
                                        <label class="mr-sm-2">Alamat Instansi <i class="text-danger">*</i></label>
                                        <input wire:model.defer="alamat_pihak.{{ $value }}" type="text"
                                            class="form-control form-control-sm @error('alamat_pihak.' . $value) is-invalid @enderror">
                                        @error('alamat_pihak.' . $value)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-auto my-2">
                                        <label class="mr-sm-2 mt-2 "><strong>Penandatangan</strong></label>&nbsp;
                                        <i class="small text-danger">
                                            *Pejabat yang menandatangani dokumen
                                        </i>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6">
                                                <label class="mr-sm-2">Nama <i class="text-danger">*</i></label>
                                                <input wire:model.defer="nama_pejabat_pihak.{{ $value }}"
                                                    type="text"
                                                    class="form-control form-control-sm @error('nama_pejabat_pihak.' . $value) is-invalid @enderror">
                                                @error('nama_pejabat_pihak.{{ $value }}')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-12 col-lg-6">

                                                <label class="mr-sm-2">Jabatan <i class="text-danger">*</i></label>
                                                <input wire:model.defer="jabatan_pejabat_pihak.{{ $value }}"
                                                    type="text" class="form-control form-control-sm">
                                                @error('jabatan_pejabat_pihak.{{ $value }}')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto my-2">
                                        <label class="mr-sm-2 mt-2 "><strong>Penanggung Jawab</strong> </label>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6">
                                                <label class="mr-sm-2">Nama <i class="text-danger">*</i></label>
                                                <input required wire:model.defer="pj_pihak.{{ $value }}"
                                                    type="text"
                                                    class="form-control form-control-sm @error('pj_pihak.' . $value) is-invalid @enderror">
                                                @error('pj_pihak.{{ $value }}')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-12 col-lg-6">
                                                <label class="mr-sm-2">Jabatan <i class="text-danger">*</i></label>
                                                <input wire:model.defer="jabatan_pj_pihak.{{ $value }}"
                                                    type="text" class="form-control form-control-sm">
                                                @error('jabatan_pj_pihak.{{ $value }}')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6">
                                                <label class="mr-sm-2 mt-1">Email <i class="text-danger">*</i></label>
                                                <input wire:model.defer="email_pj_pihak.{{ $value }}"
                                                    type="email"
                                                    class="form-control form-control-sm @error('email_pj_pihak.' . $value) is-invalid @enderror">
                                                @error('email_pj_pihak.{{ $value }}')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-12 col-lg-6">
                                                <label class="mr-sm-2 mt-1">No. HP <i
                                                        class="text-danger">*</i></label>
                                                <input wire:model.defer="hp_pj_pihak.{{ $value }}"
                                                    type="text" onkeypress="return /[0-9()+\-]/.test(event.key)"
                                                    class="form-control form-control-sm @error('hp_pj_pihak.' . $value) is-invalid @enderror">
                                                @error('hp_pj_pihak.{{ $value }}')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-sm-12 col-lg-5">
                    @if ($uploadDocument)
                        <div class="card mb-4">
                            <h5 class="card-header text-primary">
                                <i class="bx bx-image me-3"></i>University Logo
                            </h5>
                            <div class="card-body demo-vertical-spacing demo-only-element">
                                <label class="form-label">Logo (PNG format)
                                    <i class="text-danger">*</i>
                                    <i class="small text-warning">* Maximum dimensions: 1024x1024 pixels, PNG format
                                        only</i>
                                </label>
                                <input required wire:model="logo" type="file"
                                    class="form-control form-control-sm @error('logo') is-invalid @enderror"
                                    accept="image/png" id="logoInput" onchange="validateImage(this)">
                                @error('logo')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div id="imageError" class="text-danger d-none">Image must be in PNG format and under
                                    1024x1024 pixels.</div>
                            </div>
                        </div>
                    @endif
                    <div class="card mb-4">
                        <h5 class="card-header text-primary"><i class="bx bx-unite me-3"></i>Bentuk Kegiatan
                            <div wire:loading wire:target="bentukKegiatan"
                                class="mx-1 spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </h5>
                        <div class="card-body">
                            <div class="col-auto my-2">
                                <select wire:model="bentukKegiatan"
                                    class="form-select form-select-sm mr-sm-2 @error('arrayBentukKegiatan') is-invalid @enderror">
                                    <option value="0">Pilih Bentuk Kegiatan</option>
                                    @foreach ($getBentukKegiatan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('bentukKegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @forelse ($arrayBentukKegiatan as $key => $item)
                                <div class="card my-1">
                                    <label class="m-1">
                                        <button type="button" wire:click="minArrayBentuk({{ $key }})"
                                            class="btn-sm btn text-danger" style="float: right"><i
                                                class="bx bx-layer-minus"></i></button>
                                    </label>
                                    <label class="mx-3"><i
                                            class="bx bx-bullseye me-2"></i>{{ $getBentukKegiatan->find($item)->nama }}
                                    </label>

                                    <div class="card-body">
                                        <div class="col-auto my-1">
                                            <div class="col-sm-12">
                                                <label
                                                    class="@error('nilai_kontrak.' . $key) text-danger @enderror">Nilai
                                                    kontrak</label>
                                                <div class="text-muted small m-b-xs mb-1">Nominal nilai kontrak
                                                    proposal</div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="text"
                                                        wire:model.lazy="nilai_kontrak.{{ $key }}"
                                                        class="form-control form-control-sm" id="{{ $key }}"
                                                        placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto my-1">
                                            <div class="col-sm-12"><label>Luaran</label></div>
                                            <div class="col-sm-12">
                                                <div class="input-group input-group-merge">
                                                    <span
                                                        class="input-group-text @error('volume_luaran.' . $key) text-danger @enderror">Volume</span>
                                                    <input type="number" class="form-control form-control-sm"
                                                        wire:model.lazy="volume_luaran.{{ $key }}"
                                                        placeholder="0">
                                                    <span
                                                        class="input-group-text @error('volume_satuan.' . $key) text-danger @enderror">@</span>
                                                    <input type="text" class="form-control form-control-sm"
                                                        wire:model.lazy="volume_satuan.{{ $key }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto my-1">
                                            <div class="col-sm-12">
                                                <label
                                                    class="@error('keterangan.' . $key) text-danger @enderror">Keterangan</label>
                                                <div class="text-muted small m-b-xs mb-1">Ringkasan luaran dari
                                                    kegiatan</div>
                                            </div>
                                            <div class="col-sm-12">
                                                <textarea wire:model.lazy="keterangan.{{ $key }}" rows="3" class="form-control form-control-sm"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="col-sm-12">
                                                <label
                                                    class="@error('arraySasaran.' . $key) text-danger @enderror"s>Sasaran</label>
                                                <div wire:loading wire:target="arraySasaran.{{ $key }}"
                                                    class="mx-1 spinner-border spinner-border-sm text-primary"
                                                    role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <select wire:model="arraySasaran.{{ $key }}"
                                                    class="form-select form-select-sm" aria-hidden="true">
                                                    <option></option>
                                                    @foreach ($getSasaranKegiatan as $items)
                                                        <option value="{{ $items->id }}">{{ $items->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="col-sm-12">
                                                <label
                                                    class="@error('arrayKinerja.' . $key) text-danger @enderror">Indikator
                                                    Kinerja</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <select class="form-select form-select-sm" aria-hidden="true"
                                                    wire:model="arrayKinerja.{{ $key }}">
                                                    <option></option>
                                                    @foreach ($getIndikatorKinerja->where('id_sasaran_kegiatan', $arraySasaran[$key] ?? null) as $itemz)
                                                        <option value="{{ $itemz->id }}">{{ $itemz->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    var tanpa_rupiah = document.getElementById('{{ $key }}');
                                    tanpa_rupiah.addEventListener('keyup', function(e) {
                                        tanpa_rupiah.value = formatRupiah(this.value);
                                    });
                                </script>
                            @empty
                                <label class="my-2 text-warning">Belum Memilih Bentuk Kegiatan</label>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Upload MoU Document -->
                <div id="uploadDocument" class="col-md-4 d-none">
                    <div class="card mb-4">
                        <h5 class="card-header text-primary"><i class="bx bx-upload me-3"></i>Upload MoU Document
                        </h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <label class="form-label">MoU Document (PDF/DOC)</label>
                            <input wire:ignore="mou_document" type="file"
                                class="form-control form-control-sm @error('mou_document') is-invalid @enderror"
                                accept=".pdf,.doc,.docx" id="mouDocumentInput">
                            @error('mou_document')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Notification Modal -->
                <div class="modal fade" id="submissionModal" tabindex="-1" aria-labelledby="submissionModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary" id="submissionModalLabel">Submission Received
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    Your MoU submission has been received and will be processed within 5 working days.
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="d-flex justify-content-end">
                        <button wire:click="save" type="button" class="btn btn-primary">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm"
                                role="status" aria-hidden="true"></span>
                            <span wire:loading.remove wire:target="save">Submit</span>
                        </button>
                    </div>
                </div>
            </div>
    </form>
</div>

<script></script>
@push('custom-scripts')
    <script>
        /* Fungsi */
        function formatRupiah(angka) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        function validateImage(input) {
            const file = input.files[0];
            const imageError = document.getElementById('imageError');

            if (file) {
                const fileSize = file.size / 1024 / 1024; // size in MB
                const allowedExtensions = /(\.png)$/i;

                if (!allowedExtensions.exec(file.name) || fileSize > 1) { // 1 MB limit
                    imageError.classList.remove('d-none');
                    input.value = ''; // Clear the input
                } else {
                    imageError.classList.add('d-none');
                }
            }
        }

        function validateImage(input) {
            const file = input.files[0];
            const imageError = document.getElementById('imageError');

            if (file) {
                const fileSize = file.size / 5120 / 5120; // size in MB
                const allowedExtensions = /(\.png)$/i;

                if (!allowedExtensions.exec(file.name) || fileSize > 1) { // 1 MB limit
                    imageError.classList.remove('d-none');
                    input.value = ''; // Clear the input
                } else {
                    imageError.classList.add('d-none');
                }
            }
        }
        window.addEventListener('show-alert', event => {
            alert(`${event.detail.title}\n\n${event.detail.message}`);
        });

        document.addEventListener('livewire:load', function() {
            Livewire.on('formSubmitted', () => {
                // Trigger the success modal
                var submissionModal = new bootstrap.Modal(document.getElementById('submissionModal'));
                submissionModal.show();
            });

            Livewire.on('formFailed', (errors) => {
                // Display errors in the modal
                let errorHtml = '<ul>';
                errors.forEach(error => {
                    errorHtml += `<li>${error}</li>`;
                });
                errorHtml += '</ul>';

                // Update the modal content with errors
                document.querySelector('#submissionModal .modal-body').innerHTML = errorHtml;

                // Show the modal
                var submissionModal = new bootstrap.Modal(document.getElementById('submissionModal'));
                submissionModal.show();
            });
        });
    </script>
@endpush
