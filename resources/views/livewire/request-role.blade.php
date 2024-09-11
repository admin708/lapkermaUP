<div>
        <div class="modal-body">
            <label for=""><strong>Pilih Fakultas / Unit Kerja :</strong></label>
            <select class="form-control mb-3" wire:model="fakultas" style="font-size: 12px">
                <option value="">Pilih</option>
                <!-- <option value="0">ADMIN PUSAT</option> -->
                @foreach ($listFakultas as $item)
                <option value="{{$item->id}}">{{$item->nama_fakultas}}</option>
                @endforeach
            </select>
            <label class="{{ $fakultas == 1000 ? 'd-none':'' }}"><strong>Pilih Level Pengguna :</strong></label>
            <select class="form-control mb-3 {{ $fakultas == 1000 ? 'd-none':'' }}" wire:model="prodi" style="font-size: 12px" >
                <option value="">Pilih</option>
                <option value="500">PIMPINAN / KASUBAG / ADMIN FAKULTAS</option>
                @if ($listProdi)
                @foreach ($listProdi as $item)
                <option value="{{$item->id}}">PRODI {{$item->nama_resmi}}</option>
                @endforeach
                @endif
            </select>

            Select "Send" below if you are ready to send your request.
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button wire:click="request" class="btn btn-primary" data-dismiss="modal">Send</button>
        </div>
</div>
