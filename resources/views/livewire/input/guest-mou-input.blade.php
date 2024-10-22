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
                        <input required wire:model.defer="country_of_origin" type="text"
                            class="form-control form-control-sm @error('country_of_origin') is-invalid @enderror">
                    </div>
                    <div>
                        <label class="form-label">Scope</label>
                        <textarea required wire:model.defer="scope" placeholder="Add scope *if any*" class="form-control form-control-sm @error('scope') is-invalid @enderror" rows="5"></textarea>
                        <ul class="small text-muted mt-2">
                            <li>Research collaboration in areas of mutual interest</li>
                            <li>Exchange of academic materials made available by both parties</li>
                            <li>Exchange of scholars</li>
                            <li>Student mobility</li>
                            <li>Cooperative seminars, workshops, and other academic activities</li>
                        </ul>
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
                <h5 class="card-header text-primary"><i class="bx bx-image me-3"></i>University Logo</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <label class="form-label">Logo (PNG format)</label>
                    <input required wire:model="logo" type="file" class="form-control form-control-sm @error('logo') is-invalid @enderror" accept="image/png">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
