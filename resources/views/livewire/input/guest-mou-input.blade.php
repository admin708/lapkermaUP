<div class="container">
    <div class="row">
        <!-- MoU Details -->
        <div class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header text-primary"><i class="bx bx-link me-3"></i>MoU Details</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="col-auto my-2">
                        <label class="form-label">University / Company Name</label>
                        <input required wire:model.defer="university_name" type="text"
                            class="form-control form-control-sm @error('university_name') is-invalid @enderror">
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">Country of Origin (Negara Asal)</label>
                        <select required wire:model.defer="country_of_origin" class="form-select form-select-sm @error('country_of_origin') is-invalid @enderror">
                            <option value="">Select Country</option>
                            @foreach ($negaras as $negara)
                                <option value="{{ $negara->name }}">{{ $negara->name }}</option>
                            @endforeach
                        </select>
                        @error('country_of_origin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="form-label">Scope</label>
                        <div contenteditable="true" class="form-control form-control-sm @error('scope') is-invalid @enderror" style="text-align: justify; min-height: 120px; border: 1px solid #ced4da; padding: 0.375rem 0.75rem;">
                            <ul style="list-style-type: none; padding-left: 0;">
                                <li>-Research collaboration in areas of mutual interest</li>
                                <li>-Exchange of academic materials made available by both parties</li>
                                <li>-Exchange of scholars</li>
                                <li>-Student mobility</li>
                                <li>-Cooperative seminars, workshops, and other academic activities</li>
                            </ul>
                        </div>
                        <small class="text-muted mt-2">
                            You can add, remove, or edit the items above.
                        </small>
                    </div>
                    
                    
                </div>
            </div>
        </div>

        <!-- Signing Information -->
        <div class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header text-primary"><i class="bx bx-calendar me-3"></i>Signing Information</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="col-auto my-2">
                        <label class="form-label">Planned MoU Active Date / Signing Date</label>
                        <input required wire:model.defer="signing_date" type="date"
                            class="form-control form-control-sm @error('signing_date') is-invalid @enderror">
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">Planned MoU Duration (in years)</label>
                        <select required wire:model.defer="duration_years" class="form-select form-select-sm @error('duration_years') is-invalid @enderror">
                            <option value="">Select Duration</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} year{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- PIC (Person in Charge) Information -->
        <div class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header text-primary"><i class="bx bx-user me-3"></i>Person in Charge (PIC)</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="col-auto my-2">
                        <label class="form-label">Name</label>
                        <input required wire:model.defer="pic_name" type="text"
                            class="form-control form-control-sm @error('pic_name') is-invalid @enderror">
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">Designation / Position</label>
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
                        <label class="form-label">Telephone Number</label>
                        <input required wire:model.defer="pic_phone" type="text"
                            class="form-control form-control-sm @error('pic_phone') is-invalid @enderror">
                    </div>
                </div>
            </div>
        </div>

        <!-- Signing Authorized Representative -->
        <div class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header text-primary"><i class="bx bx-id-card me-3"></i>Signing Representative</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="col-auto my-2">
                        <label class="form-label">Nama</label>
                        <input required wire:model.defer="rep_name" type="text"
                            class="form-control form-control-sm @error('rep_name') is-invalid @enderror">
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">Designation / Position</label>
                        <input required wire:model.defer="rep_designation" type="text"
                            class="form-control form-control-sm @error('rep_designation') is-invalid @enderror">
                    </div>
                </div>
            </div>
        </div>

        <!-- University Logo -->
<div class="col-md-4">
    <div class="card mb-4">
        <h5 class="card-header text-primary">
            <i class="bx bx-image me-3"></i>University Logo
        </h5>
        <div class="card-body demo-vertical-spacing demo-only-element">
            <label class="form-label">Logo (PNG format) 
                <i class="small text-warning">* Max dimensions: 1024x1024 pixels, PNG format only</i>
            </label>
            <input required wire:model="logo" type="file" class="form-control form-control-sm @error('logo') is-invalid @enderror" accept="image/png" id="logoInput" onchange="validateImage(this)">
            @error('logo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div id="imageError" class="text-danger d-none">Image must be in PNG format and below 1024x1024 pixels.</div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>

<script>
    function validateImage(input) {
        const file = input.files[0];
        if (file) {
            const img = new Image();
            img.onload = function () {
                if (this.width > 1024 || this.height > 1024) {
                    document.getElementById('imageError').classList.remove('d-none');
                    input.value = ''; // Clear the input to prevent form submission
                } else {
                    document.getElementById('imageError').classList.add('d-none');
                }
            };
            img.src = URL.createObjectURL(file);
        }
    }
</script>

