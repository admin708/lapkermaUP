<div class="card p-5">
    <h1 style="font-size: 23px">Request Role :</h1>
    <hr style="margin-bottom: 7px; margin-top: 3px">
    <table wire:poll.13s style="font-size: 13px" class="table table-sm table-bordered">
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
            @if ($item->prodi_id == 0)
            <td>Admin Pusat</td>
            @elseif ($item->prodi_id == 500)
            <td>Pimpinan Fakultas/Unit</td>
            @else
            <td>{{$item->prodi->nama_resmi}}</td>
            @endif
            <td>
                <button wire:click="konf({{$item->id}})" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#userkonfir{{$item->id}}">Konfirmasi</button>
                <button onclick="tolak({{$item->id}})" class="btn btn-sm btn-danger">Tolak</button>
            </td>
        </tr>
        <!-- konfir user Modal-->
        <div wire:ignore class="modal fade" id="userkonfir{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Akun</h5>
                        <button class="btn btn-sm" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
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
                            <option value="2" class="{{ $item->prodi_id == 500 ? 'd-none':'d-block' }}">Admin </option>
                            <option value="4" class="{{ $item->prodi_id == 500 ? 'd-block':'d-none' }}">Pimpinan </option>
                            @endif
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button wire:click="konf2" class="btn btn-sm btn-primary" type="button" data-bs-dismiss="modal">konfirmasi</button>

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
    <div class="input-group input-group-merge mb-2">
        <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-search"></i></span>
        <input wire:model.lazy="search" type="text" class="form-control" id="basic-icon-default-fullname" placeholder="search by nip">
      </div>
    <table style="font-size: 13px" class="table table-sm table-bordered">
        <tr>
            <th>NO.</th>
            <th>NIP</th>
            <th>NAMA</th>
            <th>ROLE</th>
            <th>FAKULTAS/UNIT KERJA</th>
            <th>PRODI</th>
            <th>ACTION</th>
        </tr>
        @forelse ($userTable as $item)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$item->email}}</td>
            <td>{{$item->name}}</td>
            @if ($item->role_id == 1 || $item->role_id == 99)
            <td>
                <label class="text-primary"> Admin Pusat</label>
            </td>
            @elseif ($item->role_id == 2)
            <td>
                <label class="text-success"> Admin Prodi</label>
            </td>
            @elseif ($item->role_id == 4)
            <td>
                <label class="text-info"> Pimpinan Fakultas/Unit</label>
            </td>
            @endif
            <td>
                @if ($item->fakultas_id == 0)
                   Admin Pusat
                @else
                    {{ $item->fakultas->nama_fakultas }}
                @endif
            </td>
            <td>
                @if ($item->prodi_id == 0)
                    Admin Pusat
                @elseif ($item->prodi_id == 500)
                    Pimpinan Fakultas/Unit
                @else
                    {{ $item->prodi->nama_resmi }}
                @endif
            </td>
            <td>
                @if ($item->email != auth()->user()->email)
                <button wire:click="del('{{$item->id}}')" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#userdel">Delete</button>
                @else
                <button class="btn btn-xs btn-warning">Your Account</button>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5"><i>Tidak Ada User....</i></td>
        </tr>
        @endforelse
    </table>
    <div class="my-3">
        {{ $userTable->links() }}
    </div>
    <!-- delete user Modal-->
    <div wire:ignore class="modal fade" id="userdel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Akun</h5>
                    <button class="btn btn-sm" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Select "DELETE" below if you are ready to delete account.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button wire:click="del2()" class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
    <script>
        function tolak(val) {
                Swal.fire({
                    icon: 'info',
                    text: 'Yakin Hapus Request ?',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        Livewire.emit('tolak', val)
                        // Swal.fire('Saved!', '', 'success')
                    }
                })
        }
    </script>
    @endpush
</div>
