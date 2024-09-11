    <div class="card mb-4 ">
        <div class="card-header">
            <button type="button" wire:click="backTo" class="btn btn-sm btn-save  btn-secondary" style="float: left"><i
                    class="fa fa-arrow-left"></i> Back</button>
            <form wire:submit.prevent="create">
                <button type="submit" class="btn btn-sm btn-save  btn-primary" style="float: right"><i
                        class="fa fa-save"></i> Simpan</button>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Basic -->
                <div class="col-md-4">
                  <div class="card mb-1">
                    <h5 class="card-header"><i class="bx bx-user mr-3"></i>Tanggal</h5>
                    <div class="card-body pb-1 demo-vertical-spacing demo-only-element">
                      <div >
                        <label class="form-label" for="basic-default-password12">Tanggal TTD</label>
                        <input required wire:model.defer="tanggal_ttd" type="date" class="form-control form-control-sm">
                      </div>
                    </div>
                    <h5 class="card-header pb-2"><i class="bx bx-link mr-3"></i>Jenis Kerjasama</h5>
                    <div class="card-body demo-vertical-spacing demo-only-element">
                      <div >
                        <select required wire:model="jenis_kerjasama" id="jk" class="form-select form-select-sm" onchange="jeniskerjasama()">
                            <option></option>
                            @foreach ($jenisKerjasama as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div  wire:ignore>
                        <label class="form-label" for="basic-default-password12">Negara</label>
                        <input wire:model.defer="negara" id="myCountry" type="text" class="form-control form-control-sm">
                      </div>
                      <div  wire:ignore>
                        <label class="form-label" for="basic-default-password12">Region</label>
                        <input placeholder="ASIA" type="text" id="region1" style="display: none" class="form-control form-control-sm" readonly>
                        <select wire:model.defer="region" id="myRegion" style="display: block" class="form-select form-select-sm">
                            <option></option>
                            @foreach ($regionKerjasama as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div>
                        <label class="form-label" for="basic-default-password12">Jenis Kegiatan</label>
                        <select required wire:model.defer="kegiatan_kerjasama" class="form-select form-select-sm">
                            <option></option>
                            @foreach ($kegiatanKerjasama as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div>
                        <label class="form-label" for="basic-default-password12">Tempat Pelaksana</label>
                        <input required wire:model.defer="tempat_pelaksanaan" type="text" class="form-control form-control-sm">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Merged -->
                <div class="col-md-4">
                  <div class="card mb-4">
                    <h5 class="card-header"><i class="bx bx-file mr-3"></i>Jenis Dokumen Kerjasama</h5>
                    <div class="card-body demo-vertical-spacing demo-only-element">
                      <div>
                        <label class="form-label" for="basic-default-password32">Pilih Jenis Dokumen Kerjasama</label>
                        <div class="input-group input-group-merge">
                            <select required wire:model="jenis_dokumen_kerjasama" id="jdk" onchange="jeduk()" class="form-select form-select-sm">
                                <option></option>
                                @foreach ($jenisDokKerjasama as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                      <div id="changeMe" style="display: none" wire:ignore>
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
                    <div id="bingungMe" style="display: none" wire:ignore>
                        <label class="form-label" for="">Dasar Dokumen Kerjasama</label>
                        <div >
                            <select style="width: 100%" class="form-select form-select-sm" id="select2-dropdowns" >
                                <option selected></option>
                                @forelse ($dasarDokKerjasama2 as $item)
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

                    <div id="changeMe2" style="display: none" wire:ignore>
                        <label class="mr-sm-2" for="inlineFormCustomSelect">Anggaran</label>
                        <input wire:model.defer="anggaran" type="text" class="form-control form-control-sm">
                    </div>
                    <div id="changeMe3" style="display: none" wire:ignore>
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
                    <h5 class="card-header"><i class="bx bx-calendar mr-3"></i>Masa Berlaku</h5>
                    <div class="card-body demo-vertical-spacing demo-only-element">
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
                            <label class="form-label">Tanggal Awal </label>
                            <input required wire:model.defer="tanggal_awal" type="date" class="form-control form-control-sm">
                        </div>
                        <div class="col-auto my-2">
                            <label class="form-label">Tanggal Berakhir </label>
                            <input required wire:model.defer="tanggal_berakhir" type="date" class="form-control form-control-sm">
                        </div>
                        <div class="col-auto my-2">
                            <label class="form-label">Jangka Waktu <i class="small">(Tahun)</i></label>
                            <input required wire:model.defer="jangka_waktu" type="number" class="form-control form-control-sm">
                        </div>
                        <div class="col-auto my-2">
                            <label class="form-label" for="inlineFormCustomSelect">Dokumen 
                             <i
                                class="small text-warning">* max 1 mb</i> </label><br>
                            {{-- <input required id="bersih2" onchange="validateSize(this)" multiple type="file" accept=".pdf"> --}}
                            <input type="file" wire:model="files" id="uploadFiles" multiple onchange="checkFileUploadExt(this);" />
                            
                            @if ($showLoadFiles)
                            <div wire:loading wire:target="files">
                                @include('livewire._includeLoading')
                            </div>
                            @endif
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">List Dokumen </label>
                            <ul>
                                @foreach ($getDokumen as $itemDok)
                                <li>
                                    <a target="blank" href="{{asset('storage/DokumenLapkerma/'.$itemDok->url)}}">
                                        > {{ $itemDok->url }}
                                    </a>
                                    @if ($hapus2 == $itemDok->id)
                                    <button type="button" wire:click="deletedokumen({{ $itemDok->id }})"
                                        class="btn btn-sm btn-danger" style="float: right">Yakin Hapus ?</button>

                                    @else
                                    <button type="button" wire:click="hapusdokumen({{ $itemDok->id }})"
                                        class="btn btn-sm btn-warning" style="float: right">Hapus</button>
                                    @endif
                                </li>
                                <hr class="mt-2">

                                @endforeach
                            </ul>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-8 row">
                        @foreach($inputs as $key => $value)
                        <div class="col-md-6">
                            <div class="card mb-4" style="display: {{ $value <= $arrayJawaban ? 'block':'none' }}">
                            <h5 class="card-header"><i class="bx bx-link mr-3"></i>Pihak {{ $value+1 }}
                                @if ($arrayJawaban != 1 && $arrayJawaban == $value)
                                <button type="button" wire:click="minArrayPihak({{ $value }})" class="btn-sm btn text-danger"
                                    style="float: right">X</button>
                                @endif</h5>
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
                                    <div class="col-auto my-2">
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
                                    <div class="col-auto my-2"
                                        style="display: {{ $jenis_dokumen_kerjasama == 2 ? 'block':($jenis_dokumen_kerjasama == 3 ? 'block':'none')}}">
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
                                        <input wire:model.lazy="alamat_pihak.{{ $value }}" type="text"
                                            class="form-control form-control-sm"   >
                                    </div>
                                    <hr>
                                    <div class="col-auto my-2">
                                        <label class="mr-sm-2 mt-2" for="">Penandatangan</label><br>
                                        <i class="small text-danger">
                                            Pejabat yang menandatangani dokumen
                                        </i><br>
                                        <label class="mr-sm-2" for="">Nama</label>
                                        <input wire:model.lazy="nama_pejabat_pihak.{{ $value }}" type="text"
                                            class="form-control form-control-sm"   >
                                        <label class="mr-sm-2 mt-2" for="">Jabatan</label>
                                        <input wire:model.lazy="jabatan_pejabat_pihak.{{ $value }}" type="text"
                                            class="form-control form-control-sm">
                                    </div>
                                    <hr>
                                    <div class="col-auto my-2">
                                        <label class="mr-sm-2 mt-2" for="">Penanggung Jawab </label><br>
                                        <label class="mr-sm-2" for="">Nama</label>
                                        <input {{ $value <= $arrayJawaban ? 'required':'' }} wire:model.lazy="pj_pihak.{{ $value }}" type="text" class="form-control form-control-sm"    >
                                        <label class="mr-sm-2 mt-2" for="">Jabatan</label>
                                        <input wire:model.lazy="jabatan_pj_pihak.{{ $value }}" type="text"
                                            class="form-control form-control-sm">
                                        <label class="mr-sm-2 mt-2" for="">Email </label>
                                        <input wire:model.lazy="email_pj_pihak.{{ $value }}" type="email"
                                            class="form-control form-control-sm">
                                        <label class="mr-sm-2 mt-2" for="">No. HP</label>
                                        <input wire:model.lazy="hp_pj_pihak.{{ $value }}" type="number"
                                            class="form-control form-control-sm">
                                    </div>
                                    @if ($arrayJawaban != 0 && $arrayJawaban == $value)
                                    <button class="btn btm-sm btn-primary mt-2" type="button" wire:click="takeArray">Tambah Pihak</button>
                                            @endif
                                </div>
                            </div>
                        </div>
                      
                        @endforeach
                       
                    </form>
                    
                
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
                document.getElementById('uploadFiles').value= null;
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
                    window.history.back();
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

    
