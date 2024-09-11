<div>
    <div class="custom-control custom-switch" style="float: right; margin-top: 7px;">
        <input type="checkbox" class="custom-control-input" id="switch1" wire:model="example" onclick="myFunction()">
        <label class="custom-control-label" for="switch1">Aktifkan Request</label>
    </div>
    <hr style="margin-bottom: 7px; margin-top: 3px">
    <h1 style="font-size: 23px">Request Role :</h1>
    <hr style="margin-bottom: 7px; margin-top: 3px">
{{-- {{$example}} --}}
    <table wire:poll.3s style="font-size: 13px" class="table table-sm table-bordered">
        <tr>
            <th>NO.</th>
            <th>NIP</th>
            <th>NAMA</th>
            <th>FAKULTAS</th>
            <th>PRODI</th>
            <th>ACTION</th>
        </tr>
        @php
            $nos=1;
            $no = 1;
        @endphp
       @forelse ($user as $item)
       <tr>
            <td>{{$nos++}}</td>
            <td>{{$item->email}}</td>
            <td>{{$item->name}}</td>
            @if ($item->fakultas_id == 0)
            <td>Admin Pusat</td>
            @else
            <td>{{$item->fakultas->nama_fakultas}}</td>
            @endif
            <td>{{$item->prodi->nama_resmi}}</td>
            <td>
                <button wire:click="konf({{$item->id}})" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#userkonfir{{$item->id}}">Confirm</button>
            </td>
        </tr>
        <!-- konfir user Modal-->
        <div wire:ignore class="modal fade" id="userkonfir{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Akun</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Select "ROLE" below if you are ready to confirm.</p>
                        <select class="form-control" wire:model="role" required>
                            <option value="">Selecet Role</option>
                            @if ($item->fakultas_id == 0)
                            <option value="1">Admin </option>
                            {{-- <option value="3">Pimpinan </option> --}}
                            @else
                            <option value="2">Admin </option>
                            {{-- <option value="4">Pimpinan </option> --}}
                            @endif
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button wire:click="konf2()" class="btn btn-sm btn-primary" type="button" data-dismiss="modal">konfirmasi</button>

                    </div>
                </div>
            </div>
        </div>
        @empty
        <tr>
            <td colspan="5"><i>Tidak Ada Permintaan Konfirmasi Role User....</i></td>
        </tr>
        @endforelse
    </table>

    <h1 style="font-size: 23px; margin-top: 53px">Table User :</h1>
    <hr style="margin-bottom: 7px; margin-top: 3px">

    <table style="font-size: 13px" class="table table-sm table-bordered">
        <tr>
            <th>NO.</th>
            <th>NIP</th>
            <th>NAMA</th>
            <th>FAKULTAS/UNIT KERJA</th>
            <th>PRODI</th>
            <th>ACTION</th>
        </tr>
        @forelse ($userTable->whereNotNull('created_at')->whereNotNull('role_id') as $item)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$item->email}}</td>
            <td>{{$item->name}}</td>
            <td>
                @if ($item->fakultas_id == 0)
                    Admin Pusat Lapkerma
                @else
                    {{ $item->fakultas->nama_fakultas }}
                @endif
            </td>
            <td>
                @if ($item->prodi_id == 0)
                    Admin Pusat Lapkerma
                @else
                    {{ $item->prodi->nama_resmi }}
                @endif
            </td>
            <td>
                @if ($item->email != auth()->user()->email)
                <button wire:click="del('{{$item->id}}')" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#userdel">Delete</button>
                @else
                <button class="btn btn-sm btn-warning">Your Account</button>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5"><i>Tidak Ada User....</i></td>
        </tr>
        @endforelse
    </table>

    <!-- delete user Modal-->
    <div wire:ignore class="modal fade" id="userdel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Akun</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Select "DELETE" below if you are ready to delete account.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button wire:click="del2()" class="btn btn-sm btn-danger" type="button" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function myFunction() {
            Livewire.emit('postAdded');
            console.log('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        }
    </script>
</div>
