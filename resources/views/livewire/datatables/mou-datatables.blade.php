<div class="card">
  <h5 class="card-header bg-primary p-3 text-white">Data Table</h5>
  <div class="card-body">
    @if ($showModalsEdit == false)
    <div class="table-responsive text-nowrap mt-3">
        <button wire:click="download()" type="button" class="btn btn-sm mb-3 btn-outline-primary">
            <span class="tf-icons bx bx-download"></span>&nbsp; Download Exel
          </button>
      <table class="table table-bordered table-hover table-sm" style="font-size: 13px">
        <thead>
          <tr>
            <th width="10%">Tanggal TTD</th>
            <th>No. Dokumen</th>
            <th>Penggiat Kerjasama</th>
            <th>Jenis Kerjasama</th>
            <th>Negara</th>
            <th>Judul</th>
            <th>Status</th>
            <th rowspan="2">
              <button class="btn btn-sm btn-warning" wire:click="rezet">Reset</button>
            </th>
          </tr>
          <tr>
            <th>
              <select class="form-select form-select-sm" wire:model.lazy="cariTahun">
                <option value="">Tahun</option>
                @foreach ($getTahun as $key => $item)
                <option value="{{ $key }}">{{ $key}}</option>
                @endforeach
              </select>
              <select class="form-select form-select-sm mt-1" wire:model.lazy="sortData">
                <option value="">Sort By</option>
                <option value="1">Tanggal TTD</option>
                <option value="2">Create</option>
              </select>
            </th>
            <th>
              <input type="text" class="form-control form-control-sm" wire:model.lazy="cariNomorDokumen">
            </th>
            <th>
              <input type="text" class="form-control form-control-sm" wire:model.lazy="cariPenggiat">
            </th>
            <th>
              <select class="form-select form-select-sm" wire:model.lazy="cariKerjasama">
                <option value=""></option>
                @foreach ($getJenis as $item)
                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
              </select>
            </th>
            <th>
              <input type="text" class="form-control form-control-sm" wire:model.lazy="cariNegara">
            </th>
            <th>
              <input type="text" class="form-control form-control-sm" wire:model.lazy="cariJudul">
            </th>
            <th>
              <select class="form-select form-select-sm" wire:model.lazy="cariStatus">
                <option value=""></option>
                @foreach ($getStatus as $item)
                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
              </select>
            </th>
          </tr>
        </thead>
        <tbody class="small">
          @foreach ($DataMou as $item)
          @if ($item->id != 42)
          <tr>
            <td>
              <i class="fab fa-angular fa-lg text-danger"></i> <strong>{{ $item->tanggal_ttd }}</strong>
            </td>
            <td>{{ $item->nomor_dok_unhas }}</td>
            <td class="text-wrap" style="font-size: 11px">
              @php
                  $show = strtoupper(str_replace(str_split('[]"'), '', $item->penggiat));
              @endphp
              {{ strtoupper(str_replace(',', ' / ', $show)) }}
            </td>
            <td>{{ $item->getJenisKerjasama->nama }}</td>
            <td>{{ $item->negara }}</td>
            <td class="text-wrap">
              {{ substr($item->judul, 0, 30) }}
            </td>
            <td>
              {{ $item->getStatusKerjasama->nama }}
            </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu" style="">
                  @if ($item->level == 1)
                  <a class="dropdown-item text-primary small" role="button" wire:click="getEdit({{ $item->id }})"><i
                    class="bx bx-show me-1"></i> View</a>
                  @else
                  <a class="dropdown-item text-primary small" role="button" wire:click="getEdit2({{ $item->id }})"><i
                    class="bx bx-show me-1"></i> View</a>
                  @endif
                  @if (auth()->user()->role_id == 1)
                  <a class="dropdown-item text-danger small" role="button" wire:click="delete({{ $item->id }})"><i class="bx bx-trash me-1"></i>
                    Delete</a>
                  @elseif (auth()->user()->role_id != 1)
                  <a class="dropdown-item text-success small" role="button" wire:click="toInput('{{ $item->uuid }}')"><i class="bx bx-file me-1"></i>
                    Buat MoA atau Ia</a>
                  @endif
                </div>
              </div>
            </td>
          </tr>
          @endif

          @endforeach
        </tbody>
      </table>
      <div class="my-3">
        {{ $DataMou->links() }}
      </div>
    </div>
    @endif
  </div>

  <div class="modal fade show" id="fullscreenModal" tabindex="-1"
    style="display: {{ $showModalsEdit == true ? 'block':'none' }};" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-fullscreen" role="document">
      <div class="modal-content">
        <div class="modal-header container">
          <h4 class="modal-title h4" id="modalFullTitle">{{ $showModalsEdit == true ? 'Detail':'' }} Data MoU</h4>
          <div class="demo-inline-spacing">
            <button type="button" wire:click="closeEdit" class="btn btn-secondary btn-sm">
              <span class="tf-icons bx bx-chevron-left"></span>&nbsp; Close
            </button>
            @if (auth()->user()->role_id == 1)
            <button type="button" wire:click="emitEdit" class="btn btn-primary btn-sm">
              <span class="tf-icons bx bx-save"></span>&nbsp; Update
            </button>
            @endif
          </div>
        </div>
        <div class="modal-body">
          <div class="container-xxl flex-grow-1 container-p-y">
            @livewire('input.mou')
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade show" id="fullscreenModal" tabindex="-1"
    style="display: {{ $showModalsEdit2 == true ? 'block':'none' }};" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-fullscreen" role="document">
      <div class="modal-content">
        <div class="modal-header container">
          <h4 class="modal-title h4" id="modalFullTitle">{{ $showModalsEdit2 == true ? 'Edit':'' }} Data MoU Non Prodi</h4>
          <div class="demo-inline-spacing">
            <button type="button" wire:click="closeEdit" class="btn btn-secondary btn-sm">
              <span class="tf-icons bx bx-chevron-left"></span>&nbsp; Close
            </button>
          </div>
        </div>
        <div class="modal-body">
          <div class="container-xxl flex-grow-1 container-p-y">
            @livewire('input.mou-non-prodi')
          </div>
        </div>
      </div>
    </div>
  </div>
@push('custom-scripts')
    <script>
      function checkFileUploadExt2(fieldObj) {
                var control = document.getElementById("uploadFiles2");
                var filelength = control.files.length;

                for (var i = 0; i < control.files.length; i++) {
                    var file = control.files[i];
                    var FileName = file.name;
                    var FileExt = FileName.substr(FileName.lastIndexOf('.') + 1); // pdf

                    if ((FileExt.toUpperCase() != "PDF")) {
                        // $(uploadFiles).val(''); //for clearing with Jquery
                        control.value="";
                        swal.fire('File Harus dalam Format PDF');
                    }else{
                        const fileSize = file.size / 1024 / 1024; // in MiB
                        // console.log(fileSize);
                        if (fileSize > 1) {
                            // alert('File size Maksimal Berukuran 1 MiB');
                            // alert('pesan' => 'Data Duplikat', 'icon'=>'error');
                        control.value="";
                            // $(uploadFiles).val(''); //for clearing with Jquery
                            swal.fire('File size Maksimal Berukuran 1 MiB');
                        } else {
                            Livewire.emit('successMe')
                            // console.log(control.value);
                        }
                    }
                }
            }
      </script>
@endpush

</div>
