@extends('MasterApp.Borders')

@push('titleNav')
<span class="text-muted fw-light">Data Table /</span> Daftar Request MoU
@endpush

@push('custom-style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    <style>
        .fancybox__container {
            z-index: 1000000 !important;
        }
        .modal-backdrop {
            z-index: 999 !important;
        }
        .swal2-container {
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
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
    Fancybox.bind('[data-fancybox="gallery"]', { infinite: false });

    function checkFileUploadExt(fieldObj) {
        var control = document.getElementById("uploadFiles");
        var filelength = control.files.length;

        for (var i = 0; i < control.files.length; i++) {
            var file = control.files[i];
            var FileName = file.name;
            var FileExt = FileName.substr(FileName.lastIndexOf('.') + 1); // pdf
            
            if ((FileExt.toUpperCase() != "PDF")) {
                control.value = "";
                swal.fire('File Harus dalam Format PDF');
            } else {
                const fileSize = file.size / 1024 / 1024; // in MiB
                if (fileSize > 1) {
                    control.value = "";
                    swal.fire('File size Maksimal Berukuran 1 MiB');
                } else {
                    Livewire.emit('successMe');
                }
            }
        }
    }

    window.livewire.on('alerts', param => {
        let timerInterval;
        Swal.fire({
            icon: param['icon'],
            title: param['pesan'],
            timer: 2000,
            timerProgressBar: true,
            onBeforeOpen: () => {
                Swal.showLoading();
                timerInterval = setInterval(() => {
                    const content = Swal.getContent();
                    if (content) {
                        const b = content.querySelector('b');
                        if (b) {
                            b.textContent = Swal.getTimerLeft();
                        }
                    }
                }, 100);
            },
            onClose: () => {
                window.location.reload();
            }
        });
    });

    window.livewire.on('delete', param => {
        Swal.fire({
            icon: 'info',
            title: 'Yakin Hapus Data?',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('yakinHapus');
            }
        });
    });
</script>
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Heading -->
    <div class="card p-3">
        <div id="newpost">
            <h1 class="h4">Memorandum of Understanding (MoU)</h1>
            <hr class="m-3">
            @livewire('datatables.daftar-req-mo-u')
        </div>
    </div>
</div>
@endsection
