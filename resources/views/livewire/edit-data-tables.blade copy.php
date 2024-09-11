<div>
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
                <div class="col-4 border">
                    <div class="card-header mt-2">
                        Tanggal
                    </div>
                    <div class="card-body">
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Tanggal TTD @error('tanggal_ttd') <i
                                    class="small text-danger">* this field required</i>@enderror </label>
                            <input wire:model.defer="tanggal_ttd" type="date" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="card-header mt-2">
                        Jenis Kerjasama
                    </div>
                    <div class="card-body">
                        <div class="col-auto mb-3">
                            @error('jenis_kerjasama') <i class="small text-danger">* this field required</i>@enderror
                            <select wire:model="jenis_kerjasama" class="custom-select mr-sm-2">
                                <option></option>
                                @foreach ($jenisKerjasama as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Negara @error('negara') <i
                                    class="small text-danger">* this field required</i>@enderror</label>
                            @if ($jenis_kerjasama == 1)
                            <input placeholder="Indonesia" type="text" class="form-control form-control-sm" readonly>
                            @else
                            <input wire:model.defer="negara" type="text" class="form-control form-control-sm">
                            @endif
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Region @error('region') <i
                                    class="small text-danger">* this field required</i>@enderror</label>
                            @if ($jenis_kerjasama == 1)
                            <input placeholder="ASIA" type="text" class="form-control form-control-sm" readonly>
                            @else
                            <select wire:model.defer="region" class="custom-select mr-sm-2">
                                <option></option>
                                @foreach ($regionKerjasama as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @endif

                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="">Kegiatan @error('kegiatan_kerjasama') <i
                                    class="small text-danger">* this field required</i>@enderror</label>
                            <select wire:model.defer="kegiatan_kerjasama" class="custom-select mr-sm-2">
                                <option></option>
                                @foreach ($kegiatanKerjasama as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="">Tempat Pelaksanaan @error('tempat_pelaksanaan') <i
                                    class="small text-danger">* this field required</i>@enderror</label>
                            <input wire:model.defer="tempat_pelaksanaan" type="text"
                                class="form-control form-control-sm">
                        </div>
                    </div>

                </div>
                <div class="col-4 border">
                    <div class="card-header mt-2">
                        Jenis Dokumen Kerjasama
                    </div>
                    <div class="card-body">
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="">Pilih Jenis Dokumen Kerjasama
                                @error('jenis_dokumen_kerjasama') <i class="small text-danger">* this field
                                    required</i>@enderror</label>
                            <select wire:model="jenis_dokumen_kerjasama" class="custom-select mr-sm-2" disabled>
                                <option></option>
                                @foreach ($jenisDokKerjasama as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto mb-3"
                            style="display: {{ $jenis_dokumen_kerjasama == 2 ? 'block':( $jenis_dokumen_kerjasama == 3 ? 'block':'none' ) }}">
                            <label class="mr-sm-2" for="">Dasar Dokumen Kerjasama</label>
                            <div wire:ignore>
                                <select style="width: 100%" class="custom-select mr-sm-2"
                                    wire:model="dasar_dokumen_kerjasama" id="select2-dropdown" {{
                                    $jenis_dokumen_kerjasama==2 ? 'required' :( $jenis_dokumen_kerjasama==3 ? 'required'
                                    :'' ) }}>
                                    <option></option>
                                    @forelse ($dasarDokKerjasama as $item)
                                    <option value="{{ $item->id }}">{{ $item->nomor_dok_unhas }}</option>
                                    @empty
                                    <i>Not Found</i>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Nomor Dok. Unhas @error('nomor_unhas')
                                <i class="small text-danger">* this field required</i>@enderror</label>
                            <input wire:model.defer="nomor_unhas" type="text" class="form-control form-control-sm">
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Nomor Dok. Mitra @error('nomor_mitra')
                                <i class="small text-danger">* this field required</i>@enderror</label>
                            <input wire:model.defer="nomor_mitra" type="text" class="form-control form-control-sm">
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Judul Kerjasama
                                @error('judul_kerjasama') <i class="small text-danger">* this field
                                    required</i>@enderror</label>
                            <input wire:model.defer="judul_kerjasama" type="text" class="form-control form-control-sm">
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Deskripsi @error('deskripsi') <i
                                    class="small text-danger">* this field required</i>@enderror</label><br>
                            <label>
                                <i class="small text-danger">
                                    Ringkasan singkat terkait cakupan atau kegiatan kerja
                                </i>
                            </label>
                            <textarea wire:model.defer="deskripsi" class="form-control form-control-sm" name="" id=""
                                cols="30" rows="5"></textarea>
                        </div>

                        @if ($jenis_dokumen_kerjasama == 2 || $jenis_dokumen_kerjasama == 3)
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Anggaran</label>
                            <input wire:model.defer="anggaran" type="text" class="form-control form-control-sm">
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2">Sumber Dana</label>
                            <select class="custom-select mr-sm-2" wire:model.defer="sumber_dana">
                                <option></option>
                                @foreach ($sumberDana as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-4 border">
                    <div class="card-header mt-2">
                        Masa Berlaku
                    </div>

                    <div class="card-body">
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2">Status @error('status_kerjasama') <i class="small text-danger">* this
                                    field required</i>@enderror</label>
                            <select wire:model.defer="status_kerjasama" class="custom-select mr-sm-2">
                                <option></option>
                                @foreach ($statusKerjasama as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2">Tanggal Awal @error('tanggal_awal') <i class="small text-danger">*
                                    this field required</i>@enderror</label>
                            <input wire:model.defer="tanggal_awal" type="date" class="form-control form-control-sm">
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2">Tanggal Berakhir @error('tanggal_berakhir') <i
                                    class="small text-danger">* this field required</i>@enderror</label>
                            <input wire:model.defer="tanggal_berakhir" type="date" class="form-control form-control-sm">
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2">Jangka Waktu <i class="small">(Tahun)</i> @error('jangka_waktu') <i
                                    class="small text-danger">* this field required</i>@enderror</label>
                            <input wire:model.defer="jangka_waktu" type="number" class="form-control form-control-sm">
                        </div>
                        <div class="col-auto mb-3">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Dokumen <i class="small text-primary">*
                                    max 2 mb</i> @error('files') <i class="small text-danger">* this field
                                    required</i>@enderror</label><br>
                            <input id="bersih2" wire:model="files" type="file" multiple="" accept=".pdf">
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
                <div class="col-8 border mt-1">
                    <div class="card-header mt-2">
                        Penggiat Kerjasama
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($inputs as $key => $value)
                            <div class="col-6" style="display: {{ $value <= $arrayJawaban ? 'block':'none' }}">
                                <div class="card-header mt-2">
                                    Pihak {{ $value+1 }}
                                    @if ($arrayJawaban != 1 && $arrayJawaban == $value)
                                    <button type="button" wire:click="minArrayPihak({{ $value }})" class="btn-sm"
                                        style="float: right">X</button>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="col-auto mb-3">
                                        <label class="mr-sm-2" for="">Status</label>
                                        <select wire:model="status.{{ $value }}" class="custom-select mr-sm-2" {{ $value
                                            <=$arrayJawaban ? 'required' :'' }} {{ $value
                                            == 0 ? 'disabled' :'' }}>
                                            <option></option>
                                            <option value="1">Perguruan Tinggi Negeri</option>
                                            <option value="2">Perguruan Tinggi Swasta</option>
                                            <option value="3">Mitra</option>
                                        </select>
                                    </div>
                                    <div class="col-auto mb-3">
                                        <label class="mr-sm-2" for="">Nama Instansi</label>
                                        <input wire:model="nama_pihak.{{ $value }}" type="text"
                                            class="form-control form-control-sm" {{ $value <=$arrayJawaban ? 'required'
                                            :'' }} {{ $value == 0 ? 'disabled' :'' }}>
                                    </div>
                                    <div class="col-auto mb-3">
                                        <div wire:ignore.selft>
                                            <label class="mr-sm-2" for="">Fakultas</label>
                                            <select wire:model="fakultas_pihak.{{ $value }}"
                                                class="custom-select mr-sm-2" id="status{{ $value }}">
                                                <option></option>
                                                @foreach ($fakultas as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_fakultas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-auto mb-3"
                                        style="display: {{ $jenis_dokumen_kerjasama == 2 ? 'block':($jenis_dokumen_kerjasama == 3 ? 'block':'none')}}">
                                        <label>Prodi</label>
                                        <div wire:ignore.selft>
                                            <select id="multiselect{{ $value }}" wire:model="arrayProdi.{{ $value }}"
                                                class="form-control" multiple style="width: 100%">
                                                @foreach($prodiAll as $item)
                                                <option value="{{$item->id}}">{{ $item->nama_resmi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-auto mb-3">
                                        <label class="mr-sm-2" for="">Alamat Instansi</label>
                                        <input wire:model.defer="alamat_pihak.{{ $value }}" type="text"
                                            class="form-control form-control-sm" {{ $value <=$arrayJawaban ? 'required'
                                            :'' }}>
                                    </div>
                                    <hr>
                                    <div class="col-auto mb-3">
                                        <label class="mr-sm-2 mt-2" for="">Penandatangan</label><br>
                                        <i class="small text-danger">
                                            Pejabat yang menandatangani dokumen
                                        </i><br>
                                        <label class="mr-sm-2" for="">Nama</label>
                                        <input wire:model.defer="nama_pejabat_pihak.{{ $value }}" type="text"
                                            class="form-control form-control-sm" {{ $value <=$arrayJawaban ? 'required'
                                            :'' }}>
                                        <label class="mr-sm-2 mt-2" for="">Jabatan</label>
                                        <input wire:model.defer="jabatan_pejabat_pihak.{{ $value }}" type="text"
                                            class="form-control form-control-sm">
                                    </div>
                                    <hr>
                                    <div class="col-auto mb-3">
                                        <label class="mr-sm-2 mt-2" for="">Penanggung Jawab </label><br>
                                        <label class="mr-sm-2" for="">Nama</label>
                                        <input wire:model.defer="pj_pihak.{{ $value }}" type="text"
                                            class="form-control form-control-sm" {{ $value <=$arrayJawaban ? 'required'
                                            :'' }}>
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
                            @endforeach
                            </form>
                            <div class="col-4 mt-1">
                                <button class="btn btm-sm btn-primary" type="button" wire:click="takeArray">Tambah
                                    Pihak</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
    <script>
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
                        
            window.livewire.on('alerts', param => {
                // alert(param['pesan'])
                let timerInterval
                Swal.fire({
                icon: param['icon'],
                title: param['pesan'],
                // html: 'I will close in <b></b> milliseconds.',
                timer: 700,
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
            })
            window.addEventListener('enableSelect{{ $value }}', event => {
                document.getElementById("multiselect{{ $value }}").disabled = false;
                document.getElementById("status{{ $value }}").disabled = false;
            })   
                       
    </script>
    @endforeach


    @endpush

</div>