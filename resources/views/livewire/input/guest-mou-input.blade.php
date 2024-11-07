<div>
    <form wire:submit.prevent="submit">
        <div class="container">

            <!-- Checkbox to toggle upload document -->
            <div class="col-md-12 mb-4">
                <input type="checkbox" id="uploadMoUCheckbox" wire:model="uploadDocument">
                <label for="uploadMoUCheckbox">Use Our MoU Document Template</label>
            </div>

            <div class="row">
                <!-- MoU Details -->
                <div id="mouDetails" class="col-md-4">
                    <div class="card mb-4">
                        <h5 class="card-header text-primary"><i class="bx bx-link me-3"></i>MoU Details</h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <div class="col-auto my-2">
                                <label class="form-label">University / Company Name</label>
                                <input required wire:model.defer="university_name" type="text"
                                    class="form-control form-control-sm @error('university_name') is-invalid @enderror">
                            </div>

                            <div class="col-auto my-2">
                                <label class="form-label">Collaboration Type</label>
                                <select required wire:model="type_collaboration"
                                    class="form-select form-select-sm @error('type_collaboration') is-invalid @enderror">
                                    <option value="">Select Collaboration Type</option>
                                    <option value="1">Domestic Collaboration</option>
                                    <option value="2">International Collaboration</option>
                                </select>
                                @error('type_collaboration')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Tampilkan input tambahan jika showCountryInput bernilai true -->
                            @if ($showCountryInput)
    <div class="col-auto my-2">
        <label class="form-label">Country of Origin</label>
        <select required wire:model="country_of_origin" class="form-select form-select-sm">
            <option value="">Select Country</option>
            @foreach ($negaras as $negara)
                <option value="{{ $negara->id }}">{{ $negara->name }}</option>
            @endforeach
        </select>
        @error('country_of_origin')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-auto my-2">
        <label class="form-label">Region</label>
        <select required wire:model="region" class="form-select form-select-sm">
            <option value="">Select Region</option>
            @foreach ($regions as $region)
                <option value="{{ $region->id }}">{{ $region->nama }}</option>
            @endforeach
        </select>
        @error('region')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
@endif

                            

                            @if ($uploadDocument)
                                <div class="col-auto my-2">
                                    <label class="form-label">Scope</label>
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
                            @else
                                <div class="col-auto my-2">
                                    <label class="form-label">MoU Document (PDF/DOC)</label>
                                    <input type="file" wire:model="mou_document"
                                        class="form-control form-control-sm @error('mou_document') is-invalid @enderror"
                                        accept=".pdf,.doc,.docx">
                                    @error('mou_document')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">* Accepts PDF, DOC, or DOCX format only.</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

               
                <!-- PIC-Mitra (Person in Charge) Information -->
                <div id="picInfo" class="col-md-4">
                    <div class="card mb-4">
                        <h5 class="card-header text-primary"><i class="bx bx-user me-3"></i>Person in Charge (PIC) Partner</h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <div class="col-auto my-2">
                                <label class="form-label">Name</label>
                                <input required wire:model.defer="pic_name" type="text"
                                    class="form-control form-control-sm @error('pic_name') is-invalid @enderror">
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Position</label>
                                <input required wire:model.defer="pic_designation" type="text"
                                    class="form-control form-control-sm @error('pic_designation') is-invalid @enderror">
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Address</label>
                                <input required wire:model.defer="pic_address" type="text"
                                    class="form-control form-control-sm @error('pic_address') is-invalid @enderror">
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Email</label>
                                <input required wire:model.defer="pic_email" type="email"
                                    class="form-control form-control-sm @error('pic_email') is-invalid @enderror">
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Phone Number</label>
                                <input required wire:model.defer="pic_phone" type="text"
                                    class="form-control form-control-sm @error('pic_phone') is-invalid @enderror">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PIC-Unhas (Person in Charge) Information -->
                <div id="picInfo" class="col-md-4">
                    <div class="card mb-4">
                        <h5 class="card-header text-primary"><i class="bx bx-user me-3"></i>Person in Charge (PIC) UNHAS</h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <div class="col-auto my-2">
                                <label class="form-label">Name</label>
                                <input required wire:model.defer="pic_name" type="text"
                                    class="form-control form-control-sm @error('pic_name') is-invalid @enderror">
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Position</label>
                                <input required wire:model.defer="pic_designation" type="text"
                                    class="form-control form-control-sm @error('pic_designation') is-invalid @enderror">
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Address</label>
                                <input required wire:model.defer="pic_address" type="text"
                                    class="form-control form-control-sm @error('pic_address') is-invalid @enderror">
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Email</label>
                                <input required wire:model.defer="pic_email" type="email"
                                    class="form-control form-control-sm @error('pic_email') is-invalid @enderror">
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Phone Number</label>
                                <input required wire:model.defer="pic_phone" type="text"
                                    class="form-control form-control-sm @error('pic_phone') is-invalid @enderror">
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-sm-12 col-lg-5">
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
                                                <label class="@error('nilai_kontrak.' . $key) text-danger @enderror">Nilai
                                                    kontrak</label>
                                                <div class="text-muted small m-b-xs mb-1">Nominal nilai kontrak proposal</div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="text" wire:model.lazy="nilai_kontrak.{{ $key }}"
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
                                                        wire:model.lazy="volume_luaran.{{ $key }}" placeholder="0">
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
                                                <div class="text-muted small m-b-xs mb-1">Ringkasan luaran dari kegiatan</div>
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
                                                    class="mx-1 spinner-border spinner-border-sm text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <select wire:model="arraySasaran.{{ $key }}"
                                                    class="form-select form-select-sm" aria-hidden="true">
                                                    <option></option>
                                                    @foreach ($getSasaranKegiatan as $items)
                                                        <option value="{{ $items->id }}">{{ $items->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="col-sm-12">
                                                <label class="@error('arrayKinerja.' . $key) text-danger @enderror">Indikator
                                                    Kinerja</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <select class="form-select form-select-sm" aria-hidden="true"
                                                    wire:model="arrayKinerja.{{ $key }}">
                                                    <option></option>
                                                    @foreach ($getIndikatorKinerja->where('id_sasaran_kegiatan', $arraySasaran[$key] ?? null) as $itemz)
                                                        <option value="{{ $itemz->id }}">{{ $itemz->nama }}</option>
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
                
         <!-- Signing Information -->
         <div id="signingInfo" class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header text-primary"><i class="bx bx-calendar me-3"></i>Signing Information</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="col-auto my-2">
                        <label class="form-label">MoU Activation Date / Signing Date</label>
                        <input required wire:model.defer="signing_date" type="date"
                            class="form-control form-control-sm @error('signing_date') is-invalid @enderror">
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">MoU Duration (in years)</label>
                        <select required wire:model.defer="duration_years"
                            class="form-select form-select-sm @error('duration_years') is-invalid @enderror">
                            <option value="">Select Duration</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}
                                    year{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                        @error('duration_years')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>


                <!-- Signing Representative -->
                <div id="signingRep" class="col-md-4">
                    <div class="card mb-4">
                        <h5 class="card-header text-primary"><i class="bx bx-id-card me-3"></i>Signing Representative
                        </h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <div class="col-auto my-2">
                                <label class="form-label">Name</label>
                                <input required wire:model.defer="rep_name" type="text"
                                    class="form-control form-control-sm @error('rep_name') is-invalid @enderror">
                            </div>
                            <div class="col-auto my-2">
                                <label class="form-label">Position</label>
                                <input required wire:model.defer="rep_designation" type="text"
                                    class="form-control form-control-sm @error('rep_designation') is-invalid @enderror">
                            </div>
                        </div>
                    </div>
                </div>
            

                <!-- University Logo -->
                @if ($uploadDocument)
                    <div id="universityLogo" class="col-md-4">
                        <div class="card mb-4">
                            <h5 class="card-header text-primary">
                                <i class="bx bx-image me-3"></i>University Logo
                            </h5>
                            <div class="card-body demo-vertical-spacing demo-only-element">
                                <label class="form-label">Logo (PNG format)
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
                    </div>
                @endif

                <!-- Upload MoU Document -->
                <div id="uploadDocument" class="col-md-4 d-none">
                    <div class="card mb-4">
                        <h5 class="card-header text-primary"><i class="bx bx-upload me-3"></i>Upload MoU Document</h5>
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
            </div>

            <div class="row">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading wire:target="submit" class="spinner-border spinner-border-sm"
                            role="status" aria-hidden="true"></span>
                        <span wire:loading.remove wire:target="submit">Submit</span></button>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
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
</script>
