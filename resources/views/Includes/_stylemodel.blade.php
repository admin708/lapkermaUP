<style>
    .modal-window {
      position: fixed;
      background-color: rgba(200, 200, 200, 0.75);
      top: 0;
      right: 0;
      bottom: 0;
      left: -3px;
      z-index: 999;
      opacity: 0;
      pointer-events: none;
      -webkit-transition: all 0.3s;
      -moz-transition: all 0.3s;
      transition: all 0.3s;
    }

    .modal-window:target {
      opacity: 1;
      pointer-events: auto;
    }

    .modal-window>div {
      width: 70%;
      /* height: 75%; */
      position: relative;
      margin: 5% auto;
      padding: 2.3rem;
      background: #fff;
      color: #444;
    }

    .modal-window header {
      font-weight: bold;
    }

    .modal-close {
        position: absolute;
        top:3px;
        right:3px;
        background-color: rgb(88, 88, 88);
        padding:7px 10px;
        font-size: 11px;
        text-decoration: none;
        line-height: 1;
        color:#fff;
    }

    .modal-close:hover {
      color: #000;
    }

    .modal-window h1 {
      font-size: 150%;
      margin: 0 0 15px;
    }
</style>

 <!-- Modal -->
 <div class="modal fade" id="upload{{$id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi pengiriman Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        Kirim Data Ke Pusat?
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button wire:click="kirim({{$id}})" class="btn btn-info" data-dismiss="modal">Kirim</button>
        </div>
    </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal{{$id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        Yakin Hapus Data?
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button wire:click="hapus({{$id}})" class="btn btn-danger" data-dismiss="modal">Delete</button>
        </div>
    </div>
    </div>
</div>

<div id="open-modal{{$id}}" class="modal-window">
    <div>
      <a href="#modal-close" title="Close" class="modal-close" type="button" wire:click="closemi()">X</a>
      <div>
          @php
            if (auth()->user()->app == 1) {
                $data = \App\Dokumen::where('core_id',$id)->get();
            } elseif (auth()->user()->app == 2) {
                $data = \App\DokumenKerjasama::where('kerjasama_id',$id)->get();
            }
            $nooooo = 1;
          @endphp
              <div class="row">
                  <div class="col-sm-4 table-responsive">
                      <table class="table table-sm">
                       <thead>
                           <tr>
                               <th>No.</th>
                               <th>Nama Dokumen</th>
                               <th>Action</th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($data as $item)
                           <tr>
                               <td>{{$nooooo++}}</td>
                               <td>
                                   <button wire:click="dokumen({{$item->id}})" class="btn btn-sm btn-default">{{$item->url}}</button>
                              </td>
                              @if (auth()->user()->role_id == 1 || (auth()->user()->app == 2))
                                <td>
                                    @if ($sw)
                                        @if (auth()->user()->app == 1) 
                                            <button wire:click="{{$sw == $item->id? 'hapus2':'hapus1'}}({{$item->id}},{{$item->kerjasama_id}})"
                                                class="btn btn-sm {{$sw == $item->id? 'btn-danger':'btn-warning'}}" 
                                                style="font-size: 10px !important">{{$sw == $item->id? 'Yakin Hapus ?':'Delete'}}
                                            </button>
                                        @elseif (auth()->user()->app == 2) 
                                            <button wire:click="{{$sw == $item->id? 'hapus2':'hapus1'}}({{$item->id}},{{$item->kerjasama_id}})"
                                                class="btn btn-sm {{$sw == $item->id? 'btn-danger':'btn-warning'}}" 
                                                style="font-size: 10px !important">{{$sw == $item->id? 'Yakin Hapus ?':'Delete'}}
                                            </button>
                                        @endif
                                    
                                    @else
                                    <button wire:click="hapus1({{$item->id}})" class="btn btn-sm btn-warning" style="font-size: 10px !important">Delete</button>
                                    @endif
                                </td>
                              @else
                              <td></td>
                              @endif

                           </tr>
                           @endforeach
                           <tr>
                            <td colspan="2"><br></td>
                           </tr>
                       </tbody>
                      </table>
                  </div>

                  <div class="col-sm-8" style="display: block; overflow: auto;">
                      @if ($pim != $id)
                      <img class="img-fluid img-thumbnail" src="{{asset('storage/Dokumen/Capture.PNG')}}">
                  @else
                      <object width= "100%" height="500px" data="{{asset('storage/Dokumen/'.$doc)}}#page=1" type="application/pdf"></object>
                  @endif
                  </div>
              </div>
          </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModals{{$id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        Yakin Mengkonfirmasi Data?
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button wire:click="konfirm({{$id}})" class="btn btn-success" data-dismiss="modal">Accept</button>
        </div>
    </div>
    </div>
</div>
