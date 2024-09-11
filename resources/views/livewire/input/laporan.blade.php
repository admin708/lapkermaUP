<div class="row">
    <div class="col-12">
        <button class="btn btn-secondary my-3" onclick="javascript:history.go(-1)">Back</button>
    </div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    @if ($lapor != null)
       <div class="col-md-6">
            <div class="card mb-1">
                <h5 class="card-header text-primary"><i class="bx bx-link me-3"></i>Laporan Terupload</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Dokumen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <a target="blank" href="{{asset('storage/Laporan/'.$val.'/'.$kerjasama->laporan)}}">Laporan Kerjasama</a>
                                </td>
                                <td>
                                    <button wire:click="ubah" class="btn btn-sm btn-primary">Ganti Laporan</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    @else
        <div class="col-md-6">
            <div class="card mb-1">
                <h5 class="card-header text-primary"><i class="bx bx-link me-3"></i>Upload Laporan Kerjasanma</h5>
                
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <label class="text-warning text-small">
                        Upload laporan dalam format PDF dengan ukuran maksimal 3MB.
                    </label>
                    <label class="form-label">Dokumen
                        <i class="small text-warning">* max 3MB</i>
                    </label><br>
                    <input class="form-control form-control-sm " type="file" wire:model="file" accept=".pdf">
                    <br>
                    <i class="text-small text-danger">
                        @error('file')
                            {{$message}}
                        @enderror
                    </i>
                    <hr>
                    @if ($kerjasama->laporan != null)
                    <button wire:click="$set('lapor', {{$kerjasama}})" class="btn btn-sm btn-primary">Cancel</button>
                    @endif
                    <button wire:click='uploadFile' class="btn btn-sm btn-primary">Upload Laporan</button>
                </div>
            </div>
        </div>
    @endif
    
    <div class="col-md-6">
        <div class="card mb-1">
            <h5 class="card-header text-primary"><i class="bx bx-link me-3"></i>Format Laporan Kerjasanma</h5>
            <div class="card-body demo-vertical-spacing demo-only-element d-flex justify-content-center">
                <button wire:click="download" class="btn btn-sm btn-primary">Download Format</button>
            </div>
        </div>
    </div>
</div>
