@push('custom-scripts')
    <script>
        function reloadPage() {
            location.reload();
        }
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
            $('#submissionModal').on('hidden.bs.modal', function() {
                location.reload();
            })
            Livewire.on('formSubmitted', () => {
                // Trigger the success modal
                var submissionModal = new bootstrap.Modal(document.getElementById('submissionModal'));
                submissionModal.show();
            });

            Livewire.on('formFailed', () => {
                var submissionModal = new bootstrap.Modal(document.getElementById('submissionFailedModal'));
                submissionModal.show();
            });
        });
    </script>
@endpush

<div>
    <form wire:submit.prevent="submit">
        <div class="container">

            @if (session()->has('message'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
            @endif
            <!-- Checkbox to toggle upload document -->
            <div class="col-md-12 mb-4">
                <input type="checkbox" id="uploadMoUCheckbox" wire:model="uploadDocument">
                <label for="uploadMoUCheckbox" class="text-primary">Use Our MoU Document Template</label>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-1">
                        <h5 class="card-header text-primary"><i class="bx bx-link me-3"></i>Jenis Kerjasama /
                            Cooperation Type</h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <div class="col-auto my-2">
                                <label class="form-label">Pilih Jenis Kerjasama / Select Partnership Type <i
                                        class="text-danger">*</i></label>
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
                                <label class="form-label">Negara <i class="small text-danger">*</i></label>
                                <select wire:model="negara" id="select2-negara"
                                    class="form-select form-select-sm @error('negara') is-invalid @enderror">
                                    <option value=""></option>
                                    @foreach ($negaraKerjasama as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('negara')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="{{ $jenisKerjasamaField == 1 ? 'd-none' : '' }}">
                                <label class="form-label">Region <i class="text-danger">*</i></label>
                                <select wire:model="region"
                                    class="form-select form-select-sm @error('region') is-invalid @enderror">
                                    <option value=""></option>
                                    @foreach ($regionKerjasama as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Tempat Pelaksana / Location of Cooperation<i
                                        class="text-danger">*</i></label>
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
                    </div>
                </div>

                <!-- Merged -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <h5 class="card-header text-primary"><i class="bx bx-file me-3"></i>Jenis Dokumen Kerjasama /
                            Types of Cooperation Documents</h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <div class="col-auto my-2">
                                <label class="form-label">Nomor Dok. Unhas / Unhas Document Number<i
                                        class="text-danger">*</i></label>
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
                                            dokumen tidak ada / use system number if document number is not
                                            available</i>
                                    </label>
                                    @error('nomorSistem')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="{{ $jenisKerjasamaField == 2 ? 'd-none' : '' }}">
                                <label class="form-label">Nomor Dok. Mitra / Partner Document Number<i
                                        class="text-danger">*</i></label>
                                <input required wire:model.defer="nomor_mitra" type="text"
                                    class="form-control form-control-sm 
                            @error('nomor_mitra') is-invalid @enderror">
                                @error('nomor_mitra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Judul Kerjasama / Partnership Title<i
                                        class="text-danger">*</i></label>
                                <input required wire:model.defer="judul_kerjasama" type="text"
                                    class="form-control form-control-sm @error('judul_kerjasama') is-invalid @enderror">
                                @error('judul_kerjasama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Deskripsi / Partnership Description <i
                                        class="text-danger">*</i><label>
                                        <i class="small text-danger">
                                            Ringkasan singkat terkait cakupan atau kegiatan kerja /
                                            Short summary of the scope and activity of partnership
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
                        <h5 class="card-header text-primary"><i class="bx bx-calendar me-3"></i>Masa Berlaku /
                            Validity Period</h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <div class="col-auto my-2">
                                <label class="form-label">Tanggal TTD / Signing Date<i
                                        class="text-danger">*</i></label>
                                <input required wire:model.defer="tanggal_ttd" type="date"
                                    class="form-control form-control-sm @error('tanggal_ttd') is-invalid @enderror">
                                @error('tanggal_ttd')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Tanggal Awal / Start Date<i
                                        class="text-danger">*</i></label>
                                <input required wire:model.defer="tanggal_awal" type="date"
                                    class="form-control form-control-sm @error('tanggal_awal') is-invalid @enderror">
                                @error('tanggal_awal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Tanggal Berakhir / End Date<i
                                        class="text-danger">*</i></label>
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
                                <label class="form-label">Jangka Waktu / Time Period<i class="small">(Tahun /
                                        Year)</i> <i class="text-danger">*</i></label>
                                <select required wire:model.defer="jangka_waktu"
                                    class="form-control form-control-sm @error('jangka_waktu') is-invalid @enderror">
                                    <option value="">Pilih Jangka Waktu / Choose the period</option>
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
                                    {{ $value + 1 }}
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
                                        <label class="mr-sm-2 mt-2 "><strong>Penggiat Kerjasama / Partner Data</strong>
                                        </label>
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
                                                    <option value="1">Perguruan Tinggi Negeri / Public University
                                                    </option>
                                                    <option value="2">Perguruan Tinggi Swasta / Private University
                                                    </option>
                                                    <option value="4">Perguruan Tinggi Luar Negeri / Overseas
                                                        University</option>
                                                    <option value="3">Mitra / Partner</option>
                                                </select>
                                                @error('status.' . $value)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-sm-12 col-lg-7 my-2">
                                                <label class="mr-sm-2">Instansi / Universitas (Institute /
                                                    University)<i class="small text-danger">*</i>
                                                </label>

                                                <div wire:loading wire:target="nama_pihak.{{ $key }}"
                                                    class="mx-1 spinner-border spinner-border-sm text-primary"
                                                    role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>

                                                <div class="btn-group col-12">
                                                    <div class="input-group input-group-sm" data-bs-display="static"
                                                        aria-haspopup="true" aria-expanded="true">
                                                        <input placeholder="Ketik Untuk Mencari / Type to search"
                                                            wire:model="nama_pihak.{{ $key }}"
                                                            type="text"
                                                            class="form-control form-control-sm @error('nama_pihak.' . $value) is-invalid @enderror">
                                                        @error('nama_pihak.' . $value)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start {{ isset($searchInstansiList[$key]) && count($searchInstansiList[$key]) > 0 ? 'show' : '' }}"
                                                        data-bs-popper="static">
                                                        @foreach ($searchInstansiList[$key] ?? [] as $instansi)
                                                            {{-- {{ dd($instansi) }} --}}
                                                            <li>
                                                                <button
                                                                    wire:click="selectInstansi({{ $key }}, {{ $instansi['id'] }} ,'{{ $instansi['name'] }}', '{{ $instansi['address'] }}', {{ $instansi['negara_id'] }}, '{{ $instansi['coordinates'] }}', '{{ $instansi['ptqs'] }}', {{ $instansi['status'] }}, '{{ $instansi['badan_kemitraan'] }}')"
                                                                    class="small dropdown-item"
                                                                    type="button">{{ strtoupper($instansi['name']) }}
                                                                </button>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-lg-5 my-2 {{ optional($status)[$value] == 1 ? 'd-block' : (optional($status)[$value] == 4 ? 'd-block' : '') }}"
                                                style="display: none">
                                                <label class="mr-sm-2">PTQS 100<i class="text-danger">*</i></label>
                                                <select wire:model="ptqs.{{ $value }}"
                                                    class="@error('ptqs.' . $value) is-invalid @enderror form-select form-select-sm mr-sm-2">
                                                    <option value=""></option>
                                                    <option value="1">Ya / Yes</option>
                                                    <option value="2">Tidak / No</option>
                                                </select>
                                                @error('ptqs.' . $value)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-sm-12 col-lg-7 my-2 {{ optional($status)[$value] == 1 ? 'd-block' : (optional($status)[$value] == 4 ? 'd-block' : '') }}"
                                                style="display: none">
                                                <label class="mr-sm-2">Cek Ranking / Ranking Check</label>
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
                                                    placeholder="sebutkan / type it here"
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
                                            <label class="mr-sm-2">Universitas/Fakultas (University / Faculty)<i
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
                                        <label class="mr-sm-2">Alamat Instansi / Institute Address<i
                                                class="text-danger">*</i></label>
                                        <input wire:model.defer="alamat_pihak.{{ $value }}" type="text"
                                            class="form-control form-control-sm @error('alamat_pihak.' . $value) is-invalid @enderror">
                                        @error('alamat_pihak.' . $value)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-auto my-2">
                                        <label class="mr-sm-2">Negara Instansi / Institute Country</label>
                                        <select wire:model="negara_pihak.{{ $value }}"
                                            class="form-control form-control-sm @error('negara_pihak.' . $value) is-invalid @enderror">
                                            <option></option>
                                            @foreach ($negaraKerjasama as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto my-2">
                                        <label class="mr-sm-2">Cek Koordinat / Coordinates Check</label>
                                        <a href="https://www.google.com/maps?q={{ urlencode($nama_pihak[$value] ?? '') }}"
                                            target="blank" class="form-control btn btn-sm btn-secondary">click</a>
                                    </div>
                                    <div class="col-auto my-2">
                                        <label class="mr-sm-2">Koordinat Instansi / Institute
                                            Coordinates</label>
                                        <input required wire:model="koordinat_pihak.{{ $value }}"
                                            type="text"
                                            class="form-control form-control-sm @error('koordinat_pihak.' . $value) is-invalid @enderror">
                                        @error('koordinat_pihak.' . $value)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-auto my-2">
                                        <label class="mr-sm-2 mt-2 "><strong>Penandatangan /
                                                Signator</strong></label>&nbsp;
                                        <i class="small text-danger">
                                            *Pejabat yang menandatangani dokumen (Official that signed the document)
                                        </i>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6">
                                                <label class="mr-sm-2">Nama / Name<i class="text-danger">*</i></label>
                                                <div wire:loading wire:target="nama_pejabat_pihak.{{ $key }}"
                                                    class="mx-1 spinner-border spinner-border-sm text-primary"
                                                    role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="btn-group col-12">
                                                    <div class="input-group input-group-sm" data-bs-display="static"
                                                        aria-haspopup="true" aria-expanded="true">
                                                        <input placeholder="Ketik Untuk Mencari"
                                                            wire:model="nama_pejabat_pihak.{{ $key }}"
                                                            type="text"
                                                            class="form-control form-control-sm @error('nama_pejabat_pihak.' . $value) is-invalid @enderror">
                                                        @error('nama_pejabat_pihak.' . $value)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start {{ isset($searchPejabatList[$key]) && count($searchPejabatList[$key]) > 0 ? 'show' : '' }}"
                                                        data-bs-popper="static">
                                                        @foreach ($searchPejabatList[$key] ?? [] as $pejabat)
                                                            <li>
                                                                <button
                                                                    wire:click="updatePejabatPihak({{ $key }}, {{ $pejabat['id'] }} ,'{{ $pejabat['nama'] }}', '{{ $pejabat['jabatan'] }}')"
                                                                    class="small dropdown-item"
                                                                    type="button">{{ strtoupper($pejabat['nama']) }}
                                                                </button>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-lg-6">

                                                <label class="mr-sm-2">Jabatan / Designation<i
                                                        class="text-danger">*</i></label>
                                                <input wire:model.defer="jabatan_pejabat_pihak.{{ $value }}"
                                                    type="text"
                                                    class="form-control form-control-sm @error('jabatan_pejabat_pihak.' . $value) is-invalid @enderror">
                                                @error('jabatan_pejabat_pihak.' . $value)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto my-2">
                                        <label class="mr-sm-2 mt-2 "><strong>Penanggung Jawab / Person In
                                                Charge</strong> </label>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6">
                                                <label class="mr-sm-2">Nama / Name<i class="text-danger">*</i></label>
                                                <div wire:loading wire:target="pj_pihak.{{ $key }}"
                                                    class="mx-1 spinner-border spinner-border-sm text-primary"
                                                    role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="btn-group col-12">
                                                    <div class="input-group input-group-sm" data-bs-display="static"
                                                        aria-haspopup="true" aria-expanded="true">
                                                        <input placeholder="Ketik Untuk Mencari / Type here to search"
                                                            wire:model="pj_pihak.{{ $key }}" type="text"
                                                            class="form-control form-control-sm @error('pj_pihak.' . $value) is-invalid @enderror">
                                                        @error('pj_pihak.{{ $value }}')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start {{ isset($searchPenanggungJawab[$key]) && count($searchPenanggungJawab[$key]) > 0 ? 'show' : '' }}"
                                                        data-bs-popper="static">
                                                        @foreach ($searchPenanggungJawab[$key] ?? [] as $pj)
                                                            <li>
                                                                <button
                                                                    wire:click="setPJData({{ $key }}, {{ $pj['id'] }} ,'{{ $pj['name'] }}', '{{ $pj['designation'] }}', '{{ $pj['phone_number'] }}','{{ $pj['email'] }}')"
                                                                    class="small dropdown-item"
                                                                    type="button">{{ strtoupper($pj['name']) }}
                                                                </button>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-lg-6">
                                                <label class="mr-sm-2">Jabatan / Designation<i
                                                        class="text-danger">*</i></label>
                                                <input wire:model.defer="jabatan_pj_pihak.{{ $value }}"
                                                    type="text"
                                                    class="form-control form-control-sm @error('jabatan_pj_pihak.' . $value) is-invalid @enderror">
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
                                                <label class="mr-sm-2 mt-1">No. HP / Phone Number<i
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
                        <h5 class="card-header text-primary"><i class="bx bx-unite me-3"></i>Form of Activity
                            <div wire:loading wire:target="bentukKegiatan"
                                class="mx-1 spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </h5>
                        <div class="card-body">
                            <div class="col-auto my-2">
                                <select wire:model="bentukKegiatan"
                                    class="form-select form-select-sm mr-sm-2 @error('arrayBentukKegiatan') is-invalid @enderror">
                                    <option value="0">Pilih Bentuk Kegiatan / Choose Form of Activity</option>
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
                                                    kontrak / Contract Value</label>
                                                <div class="text-muted small m-b-xs mb-1">Nominal nilai kontrak
                                                    proposal / Contract Value Nominal Value</div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="text"
                                                        wire:model.lazy="nilai_kontrak.{{ $key }}"
                                                        class="form-control form-control-sm"
                                                        id="{{ $key }}" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto my-1">
                                            <div class="col-sm-12"><label>Contribution</label></div>
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
                                                    kegiatan / Summary of Activity's Contribution</div>
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
                                <label class="my-2 text-warning">Belum Memilih Bentuk Kegiatan / Haven't chosen the
                                    activity forms</label>
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
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    {{-- onclick="reloadPage()" --}}></button>
                            </div>
                            <div class="modal-body">
                                Your MoU submission has been received and will be processed within 5 working days.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" {{-- onclick="reloadPage()" --}}
                                    data-bs-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="submissionFailedModal" tabindex="-1"
                    aria-labelledby="submissionFailedModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary" id="submissionModalLabel">Submission Denied
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{-- This MoU request already exists --}}
                                @if ($errors->any())
                                    <ul class="text-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No errors found.</p>
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
