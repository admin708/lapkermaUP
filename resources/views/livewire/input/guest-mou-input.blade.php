<div>
    <form wire:submit.prevent="submit">
        <div class="container">

            <!-- Checkbox to toggle upload document -->
            <div class="col-md-12 mb-4">
                <input type="checkbox" id="uploadMoUCheckbox" onchange="toggleMoUDetails(this)">
                <label for="uploadMoUCheckbox">Upload MoU Document Instead of Creating New MoU</label>
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
                                <select required wire:model.defer="type_collaboration"
                                    class="form-select form-select-sm @error('type_collaboration') is-invalid @enderror">
                                    <option value="">Select Collaboration Type</option>
                                    <option value="1">Domestic Collaboration</option>
                                    <option value="2">International Collaboration</option>
                                </select>
                                @error('type_collaboration')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-auto my-2">
                                <label class="form-label">Country of Origin</label>
                                <select required wire:model.defer="country_of_origin"
                                    class="form-select form-select-sm @error('country_of_origin') is-invalid @enderror">
                                    <option value="">Select Country</option>
                                    @foreach ($negaras as $negara)
                                        <option value="{{ $negara->id }}">{{ $negara->name }}</option>
                                    @endforeach
                                </select>
                                @error('country_of_origin')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
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
                                <small class="text-muted mt-2">You can add, remove, or edit the scope as needed.</small>
                            </div>
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

                <!-- PIC (Person in Charge) Information -->
                <div id="picInfo" class="col-md-4">
                    <div class="card mb-4">
                        <h5 class="card-header text-primary"><i class="bx bx-user me-3"></i>Person in Charge (PIC)</h5>
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

                <!-- Upload MoU Document -->
                <div id="uploadDocument" class="col-md-4 d-none">
                    <div class="card mb-4">
                        <h5 class="card-header text-primary"><i class="bx bx-upload me-3"></i>Upload MoU Document</h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                            <label class="form-label">MoU Document (PDF/DOC)</label>
                            <input wire:model="mou_document" type="file"
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleMoUDetails(checkbox) {
        const mouDetails = document.getElementById('mouDetails');
        const signingInfo = document.getElementById('signingInfo');
        const picInfo = document.getElementById('picInfo');
        const signingRep = document.getElementById('signingRep');
        const universityLogo = document.getElementById('universityLogo');
        const uploadDocument = document.getElementById('uploadDocument');

        if (checkbox.checked) {
            mouDetails.classList.add('d-none');
            signingInfo.classList.add('d-none');
            picInfo.classList.add('d-none');
            signingRep.classList.add('d-none');
            universityLogo.classList.add('d-none');
            uploadDocument.classList.remove('d-none');
        } else {
            mouDetails.classList.remove('d-none');
            signingInfo.classList.remove('d-none');
            picInfo.classList.remove('d-none');
            signingRep.classList.remove('d-none');
            universityLogo.classList.remove('d-none');
            uploadDocument.classList.add('d-none');
        }
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
</script>
