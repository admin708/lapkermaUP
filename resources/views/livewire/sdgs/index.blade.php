<div>
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary" wire:click="$set('show',true)">
            Create
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-stripped">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Nama</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataSdgs as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->nama}}</td>
                        <td>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <center>Data Tidak Tersedia</center>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
  
    <!-- Modal -->
    <div class="modal fade show" style="display: {{$show ? 'block':'none'}}; background-color: rgba(128, 128, 128, 0.404)">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nama</h5>
            <button type="button" class="btn-close" wire:click="$set('show',false)"></button>
            </div>
            <div class="modal-body">
            <input type="text" class="form-control" wire:model.lazy="nama">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" wire:click="$set('show',false)">Close</button>
            <button type="button" class="btn btn-primary" wire:click="simpan">Save</button>
            </div>
        </div>
        </div>
    </div>
    
    
</div>
