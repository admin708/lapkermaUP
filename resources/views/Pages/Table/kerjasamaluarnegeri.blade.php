@extends('MasterApp.Borders')
@push('titleNav')
<span class="text-muted fw-light">Data Table /</span> IKU-6
@endpush
@push('custom-style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    <style>
        .fancybox__container {
        z-index: 1000000 !important;
        }
        .modal-backdrop {
            z-index: 999 !important;
        }
        .swal2-container{
            z-index: 99999 !important;
        }
    </style>
@endpush
@push('livewire-style')
@livewireStyles
@endpush
@push('livewire-scripts')
@livewireScripts
@endpush
@push('first-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
    // Customization example
    Fancybox.bind('[data-fancybox="gallery"]', {
      infinite: false
    });
</script>
@endpush
@push('custom-scripts')
<script>
  function checkFileUploadExt(fieldObj) {
                var control = document.getElementById("uploadFiles");
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
            window.livewire.on('alerts', param => {
                // alert(param['pesan'])
                let timerInterval
                Swal.fire({
                icon: param['icon'],
                title: param['pesan'],
                // html: 'I will close in <b></b> milliseconds.',
                timer: 1000,
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
                    window.location.reload();
                    // clearInterval(timerInterval)
                }
                }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
                })
            })

            window.livewire.on('delete', param => {
                Swal.fire({
                    icon: 'info',
                title: 'Yakin Hapus Data ?',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    // Swal.fire('Berhasil Dihapus!', '', 'success')
                    Livewire.emit('yakinHapus')
                }
                })
            })
</script>

@endpush
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Heading -->
    <div class="card p-3">
        <div id="newpost">
            <h1 class="h4">Indikator Kerjasama Utama (IKU-6) Luar Negeri</h1>
            <hr class="m-3">
            @livewire('datatables.kerjasama-luar-negeri-datatables')
        </div>
    </div>
</div>

@endsection