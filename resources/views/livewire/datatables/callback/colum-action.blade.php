<div class="flex space-x-1 justify-around" >
  <button type="button" wire:click="editData({{ $id }})" class="btn btn-warning btn-sm">
    <i class="bx bx-pen"></i>
  </button>
  @if (auth()->user()->role_id == 1)
  <button type="button" class="btn btn-danger btn-sm"  data-bs-toggle="modal" data-bs-target="#hapus{{ $id }}">
    <i class="bx bx-trash"></i>
  </button>
  <!-- Modal -->
  <div class="modal fade" id="hapus{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h5" id="exampleModalLabel">Hapus Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Yakin Hapus Data ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" wire:click="hapus({{ $id }})" data-bs-dismiss="modal">Hapus</button>
        </div>
      </div>
    </div>
  </div>
  @endif
  
    
    
  </div>
  
  