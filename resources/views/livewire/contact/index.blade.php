<div>
    <div class="card">
        <h5 class="card-header">Daftar Kontak
            <button onclick="addContact()" style="float: right" type="button" class="btn btn-icon btn-primary">
                <span class="tf-icons bx bx-plus"></span>
              </button>
        </h5>
        <div class="card-body">

          <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-sm" style="font-size: 13px">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Nomor HP</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody wire:sortable="updateTaskOrder">
                @forelse ($getContact as $item)
                    <tr role="button" wire:sortable.item="{{ $item->id }}" wire:key="task-{{ $item->id }}">
                        <td wire:sortable.handle>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>+{{ $item->no_hp }}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="hapusContact({{ $item->id }})">hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Kontak belum tersedia</td>
                    </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @push('custom-scripts')
      <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
        <script>
            function addContact() {
                (async () => {
                    const { value: formValues } = await Swal.fire({
                    showCancelButton: true,
                    title: 'Tambah Kontak',
                    html:
                        '<div class="mb-1 mt-3"><label class="form-label">Nama</label><input type="text" class="form-control" placeholder="Nama" id="swal-input1"></div>'+
                        '<div class="mb-2"><label class="form-label">No Hp</label><input type="number" class="form-control" placeholder="6282347387018" id="swal-input2"></div>',
                    focusConfirm: false,
                    preConfirm: () => {
                        if (document.getElementById('swal-input1').value) {
                            if (document.getElementById('swal-input2').value) {
                                return [
                                document.getElementById('swal-input1').value,
                                document.getElementById('swal-input2').value
                                ]
                            }else{
                                Swal.showValidationMessage('No Hp Wajib diisi')
                            }
                        }else{
                            Swal.showValidationMessage('Nama Wajib diisi')
                        }

                    }
                    })

                    if (formValues) {
                        Livewire.emit('sendValueCreat', formValues)

                    console.log(formValues);
                    }
                })()
            }
            function hapusContact(val) {
                Swal.fire({
                    icon: 'info',
                    text: 'Yakin Hapus Kontak',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        Livewire.emit('hapusKontak', val)
                        // Swal.fire('Saved!', '', 'success')
                    }
                })
            }
        </script>
      @endpush
</div>
