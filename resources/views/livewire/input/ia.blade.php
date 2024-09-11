{{-- controller with livewire.moa --}}
<div>
    
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary my-3 form-control" wire:click="save">Simpan</button>
        </div>
        <div class="col-md-4">
            <div class="card mb-1">
                <h5 class="card-header"><i class="bx bx-link me-3"></i>Jenis Kerjasama</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="col-auto my-2">
                        <label class="form-label">Pilih Jenis Kerjasama
                            @error('jenisKerjasamaField')
                            <label class="text-danger">* required</label>
                            @enderror
                        </label>
                        <select required wire:model="jenisKerjasamaField" id="jk" class="form-select form-select-sm">
                            @foreach ($jenisKerjasama as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="{{ $jenisKerjasamaField == 1 ? 'd-none':'' }}">
                        <label class="form-label">Negara</label>
                        <input wire:model="negara" type="text" class="form-control form-control-sm">
                    </div>
                    <div class="{{ $jenisKerjasamaField == 1 ? 'd-none':'' }}">
                        <label class="form-label">Region</label>
                        <select wire:model="region" style="display: block" class="form-select form-select-sm">
                            <option></option>
                            @foreach ($regionKerjasama as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Tempat Pelaksana</label>
                        <input required wire:model.defer="tempat_pelaksanaan" type="text"
                            class="form-control form-control-sm">
                    </div>
                </div>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <label class="form-label" for="inlineFormCustomSelect">Dokumen
                        <i class="small text-warning">* max 1 mb</i> </label><br>
                    <input class="form-control form-control-sm" type="file" wire:model="files" id="uploadFiles" multiple
                        accept=".pdf" onchange="checkFileUploadExt(this);" />

                    @if ($showLoadFiles)
                    <div wire:loading wire:target="files">
                        @include('livewire._includeLoading')
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Merged -->
        <div class="col-md-4">
          <div class="card mb-4">
            <h5 class="card-header"><i class="bx bx-file me-3"></i>Jenis Dokumen Kerjasama</h5>
            <div class="card-body demo-vertical-spacing demo-only-element">
              <div wire:ignore>
                <label class="form-label" for="">Dasar Dokumen Kerjasama</label>
                <div >
                    <select style="width: 100%" class="form-select form-select-sm" id="select2-dropdown" >
                        <option selected></option>
                        @forelse ($dasarDokKerjasama as $item)
                        <option value="{{ $item->id }}">{{ $item->uuid }} | {{ $item->judul }}</option>
                        @empty
                        <i>Not Found</i>
                        @endforelse
                    </select>
                </div>
            </div>
            <div>
                <label class="form-label">Nomor Dok. Unhas</label>
                <input required wire:model.defer="nomor_unhas" type="text" class="form-control form-control-sm">
            </div>
            <div>
                <label class="form-label" for="inlineFormCustomSelect">Nomor Dok. Mitra</label>
                <input required wire:model.defer="nomor_mitra" type="text" class="form-control form-control-sm">
            </div>
            <div>
                <label class="form-label" for="inlineFormCustomSelect">Judul Kerjasama
                   </label>
                <input required wire:model.defer="judul_kerjasama" type="text" class="form-control form-control-sm">
            </div>
            <div>
                <label class="form-label" for="inlineFormCustomSelect">Deskripsi </label><br>
                <label>
                    <i class="small text-danger">
                        Ringkasan singkat terkait cakupan atau kegiatan kerja
                    </i>
                </label>
                <textarea required wire:model.defer="deskripsi" class="form-control form-control-sm" cols="30" rows="5"></textarea>
            </div>

            <div>
                <label class="mr-sm-2" for="inlineFormCustomSelect">Anggaran</label>
                <input wire:model.defer="anggaran" type="text" class="form-control form-control-sm">
            </div>
            <div>
                <label class="mr-sm-2">Sumber Dana</label>
                <select class="form-select form-select-sm" wire:model.defer="sumber_dana">
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
                <h5 class="card-header"><i class="bx bx-calendar me-3"></i>Masa Berlaku</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="col-auto my-2">
                        <label class="form-label">Tanggal TTD </label>
                        <input required wire:model.defer="tanggal_ttd" type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">Tanggal Awal </label>
                        <input required wire:model.defer="tanggal_awal" type="date"
                            class="form-control form-control-sm">
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">Tanggal Berakhir </label>
                        <input required wire:model.defer="tanggal_berakhir" type="date"
                            class="form-control form-control-sm">
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">Status </label>
                        <select required wire:model.defer="status_kerjasama" class="form-select form-select-sm">
                            <option></option>
                            @foreach ($statusKerjasama as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto my-2">
                        <label class="form-label">Jangka Waktu <i class="small">(Tahun)</i></label>
                        <input required wire:model.defer="jangka_waktu" type="number"
                            class="form-control form-control-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-8 row">
            @foreach($inputs as $key => $value)
            <div class="col-md-6">
                <div class="card mb-4" style="display: {{ $value <= $arrayJawaban ? 'block':'none' }}">
                <h5 class="card-header"><i class="bx bx-link me-3"></i>Pihak {{ $value+1 }}
                    @if ($arrayJawaban != 0 && $arrayJawaban == $value)
                    <button type="button" wire:click="takeArray" class="btn-sm btn text-primary" style="float: right"><i
                            class="bx bx-layer-plus"></i></button>
                    @endif
                    @if ($arrayJawaban != 1 && $arrayJawaban == $value)
                    <button type="button" wire:click="minArrayPihak({{ $key }})" class="btn-sm btn text-danger"
                        style="float: right"><i class="bx bx-layer-minus"></i></button>

                    @endif    
                </h5>
                    <div class="card-body">  
                        <div class="col-auto my-2">
                            <label class="mr-sm-2" for="">Status</label>
                            <select wire:model="status.{{ $value }}" class="form-select form-select-sm mr-sm-2" {{ $value == 0 ? 'disabled':'' }}>
                                <option></option>
                                <option value="1">Perguruan Tinggi Negeri</option>
                                <option value="2">Perguruan Tinggi Swasta</option>
                                <option value="3">Mitra</option>
                            </select>
                        </div>
                        <div class="col-auto my-2">
                            <label class="mr-sm-2" for="">Nama Instansi </label>
                            <input wire:model="nama_pihak.{{ $value }}" type="text"
                                class="form-control form-control-sm"  {{ $value == 0 ? 'disabled':'' }} >
                        </div>
                        
                        <div class="col-auto my-2
                            @switch($status[$value]??null)
                                @case(3)
                                    d-none
                                    @break
                                @default
                            @endswitch">
                            <div wire:ignore.selft>
                                <label class="mr-sm-2" for="">Fakultas</label>
                                <select wire:model="fakultas_pihak.{{ $value }}"
                                    class="form-select form-select-sm mr-sm-2" id="status{{ $value }}">
                                    <option></option>
                                    @foreach ($fakultas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_fakultas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-auto my-2
                        @switch($status[$value]??null)
                                @case(3)
                                    d-none
                                    @break
                                @default
                            @endswitch">
                            <label>Prodi</label>
                            <div wire:ignore.selft>
                                <select id="multiselect{{ $value }}" class="form-control" multiple wire:model="arrayProdi.{{ $value }}"
                                    style="width: 100%">
                                    @foreach($prodiAll as $item)
                                    <option value="{{$item->id}}">{{ $item->nama_resmi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-auto my-2">
                            <label class="mr-sm-2" for="">Alamat Instansi</label>
                            <input wire:model.defer="alamat_pihak.{{ $value }}" type="text"
                                class="form-control form-control-sm"   >
                        </div>
                        <hr>
                        <div class="col-auto my-2">
                            <label class="mr-sm-2 mt-2" for="">Penandatangan</label><br>
                            <i class="small text-danger">
                                Pejabat yang menandatangani dokumen
                            </i><br>
                            <label class="mr-sm-2" for="">Nama</label>
                            <input wire:model.defer="nama_pejabat_pihak.{{ $value }}" type="text"
                                class="form-control form-control-sm"   >
                            <label class="mr-sm-2 mt-2" for="">Jabatan</label>
                            <input wire:model.defer="jabatan_pejabat_pihak.{{ $value }}" type="text"
                                class="form-control form-control-sm">
                        </div>
                        <hr>
                        <div class="col-auto my-2">
                            <label class="mr-sm-2 mt-2" for="">Penanggung Jawab </label><br>
                            <label class="mr-sm-2" for="">Nama</label>
                            <input {{ $value <= $arrayJawaban ? 'required':'' }} wire:model.defer="pj_pihak.{{ $value }}" type="text" class="form-control form-control-sm"    >
                            <label class="mr-sm-2 mt-2" for="">Jabatan</label>
                            <input wire:model.defer="jabatan_pj_pihak.{{ $value }}" type="text"
                                class="form-control form-control-sm">
                            <label class="mr-sm-2 mt-2" for="">Email </label>
                            <input wire:model.defer="email_pj_pihak.{{ $value }}" type="email"
                                class="form-control form-control-sm">
                            <label class="mr-sm-2 mt-2" for="">No. HP</label>
                            <input wire:model.defer="hp_pj_pihak.{{ $value }}" type="number"
                                class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
            </div>
          
            @endforeach
           
        </form>
        
    
</div>
<div class="col-4">
    <div class="card mb-4">
        <h5 class="card-header"><i class="bx bx-unite me-3"></i>Bentuk Kegiatan</h5>
        <div class="card-body">
            <div class="col-auto my-2">
                <select wire:model.lazy="bentukKegiatan" class="form-select form-select-sm mr-sm-2" >
                    <option value="0">Pilih Bentuk Kegiatan</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                    <option value="4">D</option>
                </select>
            </div>
            @forelse ($arrayBentukKegiatan as $key => $item)
            <div class="card my-1">
                <h5 class="card-header"><i class="bx bx-bullseye me-2"></i>{{ $item }}
                    <button type="button" wire:click="minArrayBentuk({{ $key }})" class="btn-sm btn text-danger"
                    style="float: right"><i class="bx bx-layer-minus"></i></button>
                </h5>

                <div class="card-body">
                        <div class="col-auto my-1">
                            <div class="col-sm-12"> 
                                <label>Nilai kontrak</label> 
                                <div class="text-muted small m-b-xs mb-1">Nominal nilai kontrak proposal</div>
                            </div>
                            <div class="col-sm-12"> 
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" class="form-control" placeholder="100" >
                                  </div>
                            </div>
                        </div>
                        <div class="col-auto my-1">
                            <div class="col-sm-12"><label>Luaran</label></div>
                            <div class="col-sm-12">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">Volume</span>
                                    <input type="text" class="form-control">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control">
                                  </div>
                            </div>
                        </div>
                        <div class="col-auto my-1">
                            <div class="col-sm-12"> 
                                <label>Keterangan</label>
                                <div class="text-muted small m-b-xs mb-1">Ringkasan luaran dari kegiatan</div>
                            </div>
                            <div class="col-sm-12">
                                <textarea data-field="note_luaran" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="col-sm-12">
                                <label>Sasaran</label>
                            </div>
                            <div class="col-sm-12">
                                <select class="form-select form-select-sm" aria-hidden="true">
                                    <option></option>
                                    <option value="57ec65bd-e13b-4ebf-911c-a1c9097b8783">Meningkatnya kualitas lulusan pendidikan tinggi</option>
                                    <option value="e223673c-14ac-4f14-9821-a65c04a8862d">Meningkatnya inovasi perguruan tinggi dalam rangka meningkatkan mutu pendidikan</option>
                                    <option value="dcb9e13a-28c9-4ddf-803d-6abe69fa787d">Meningkatnya kualitas dosen pendidikan tinggi</option>
                                    <option value="219cfb2b-d599-4728-a4b8-8c2b2b56869a">Meningkatnya kualitas kurikulum dan pembelajaran</option>
                                    <option value="9326f685-600f-47a8-a4ea-faf237988f15">Meningkatnya program studi yang berkualitas</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="col-sm-12">
                                <label>Indikator Kinerja</label>
                            </div>
                            <div class="col-sm-12">
                                <select class="form-select form-select-sm" aria-hidden="true">
                                    <option></option>
                                    <option value="57ec65bd-e13b-4ebf-911c-a1c9097b8783">Meningkatnya kualitas lulusan pendidikan tinggi</option>
                                    <option value="e223673c-14ac-4f14-9821-a65c04a8862d">Meningkatnya inovasi perguruan tinggi dalam rangka meningkatkan mutu pendidikan</option>
                                    <option value="dcb9e13a-28c9-4ddf-803d-6abe69fa787d">Meningkatnya kualitas dosen pendidikan tinggi</option>
                                    <option value="219cfb2b-d599-4728-a4b8-8c2b2b56869a">Meningkatnya kualitas kurikulum dan pembelajaran</option>
                                    <option value="9326f685-600f-47a8-a4ea-faf237988f15">Meningkatnya program studi yang berkualitas</option>
                                </select>
                            </div>
                        </div>
                </div> 
            </div>
            @empty
                <label class="my-2 text-warning">Belum Memilih Bentuk Kegiatan</label>
            @endforelse
        </div>
    </div>
</div>
    </div>

@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
            // if ((FileExt.toUpperCase() != "PDF")) {
            //     $(uploadFiles).val(''); //for clearing with Jquery
            //     swal.fire('File Harus dalam Format PDF');
            // }else{
            //     const fileSize = file.size / 1024 / 1024; // in MiB
            //     // console.log(fileSize);
            //     if (fileSize > 1) {
            //         // alert('File size Maksimal Berukuran 1 MiB');
            //         // alert('pesan' => 'Data Duplikat', 'icon'=>'error'); 
            //         $(uploadFiles).val(''); //for clearing with Jquery
            //         swal.fire('File size Maksimal Berukuran 1 MiB');
            //     } else {
            //         Livewire.emit('successMe')
            //         // console.log(control.value);
            //     }
            // }
        }
    }

    function jeniskerjasama() {
        var cek = document.getElementById("jk").value;
        if (cek == 1) {
            document.getElementById("myCountry").placeholder = "Indonesia";
            document.querySelector('#myCountry').disabled = true; 
            document.getElementById("myRegion").style.display = 'none';
            document.getElementById("region1").style.display = 'block';
        }else{
            document.getElementById("myCountry").placeholder = "";
            document.querySelector('#myCountry').disabled = false; 
            document.getElementById("region1").style.display = 'none';
            document.getElementById("myRegion").style.display = 'block';
        }
    }
    function jeduk() {
        var tes = document.getElementById("jdk").value;
            // document.getElementById("harga").value=tes;
            console.log(tes);
            if (tes == 3) {  
                document.getElementById("bingungMe").style.display = "block";  
                document.getElementById("changeMe").style.display = "none";  
                document.getElementById("changeMe2").style.display = "block";  
                document.getElementById("changeMe3").style.display = "block";  
                document.querySelector('#select2-dropdown').required = false;  
                document.querySelector('#select2-dropdowns').required = true;  
                // document.getElementById('nama_id').setAttribute('required','required')
            } 
            if (tes == 2) {  
                document.getElementById("bingungMe").style.display = "none";  
                document.getElementById("changeMe").style.display = "block";  
                document.getElementById("changeMe2").style.display = "block";  
                document.getElementById("changeMe3").style.display = "block";  
                document.querySelector('#select2-dropdown').required = true;  
                document.querySelector('#select2-dropdowns').required = false;  
                // document.getElementById('nama_id').setAttribute('required','required')
            } 
            if (tes == 1){
                document.getElementById("bingungMe").style.display = "none";
                document.getElementById("changeMe").style.display = "none";
                document.getElementById("changeMe2").style.display = "none";
                document.getElementById("changeMe3").style.display = "none";
                document.querySelector('#select2-dropdown').required = false;  
                document.querySelector('#select2-dropdowns').required = false;  
            }
    }

    window.addEventListener('bersih', event => {
        document.getElementById('bersih2').value= null;
    })

    
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
        timer: 2500,
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
            // clearInterval(timerInterval)
        }
        }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
        }
        })
    })
</script>
@foreach ($inputs as $key => $value)
<script>
    $(document).ready(function () {
        $('#multiselect{{ $value }}').select2();
        $('#multiselect{{ $value }}').on('change', function (e) {
            let data = $(this).val();
            @this.set('arrayProdi.{{ $value }}', data);
        });
    }); 
    window.addEventListener('clearselect{{ $value }}', event => {
        $('#multiselect{{ $value }}').val(null).trigger('change');
    })
    window.addEventListener('disableSelect{{ $value }}', event => {
        document.getElementById("multiselect{{ $value }}").disabled = true;
        document.getElementById("status{{ $value }}").disabled = true;
        // document.querySelector('#status{{ $value }}').required = false;  
    })
    window.addEventListener('enableSelect{{ $value }}', event => {
        document.getElementById("multiselect{{ $value }}").disabled = false;
        document.getElementById("status{{ $value }}").disabled = false;
        // document.querySelector('#status{{ $value }}').required = true;  
    })                               
</script>
@endforeach


@endpush

</div>
