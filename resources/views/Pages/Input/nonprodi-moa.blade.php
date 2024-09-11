@extends('MasterApp.Borders')
@push('titleNav')
<span class="text-muted fw-light">Input Data / Non Prodi /</span> MoA & IA
@endpush
@push('custom-style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('livewire-style')
@livewireStyles
@endpush
@push('livewire-scripts')
@livewireScripts
@endpush
@push('first-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    // window.location.reload();
                    // clearInterval(timerInterval)
                }
                }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
                })
            })
            window.livewire.on('alerts2', param => {
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
                    // window.location.reload();
                    window.location.href = '{{route("moa-in")}}';
                    // clearInterval(timerInterval)
                }
                }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
                })
            })
</script>
@endpush
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Heading -->

    <div class="col-xl-12">
        <div class="nav-align-top mb-4">
          <div class="tab-content">
                @livewire('input.moa-non-prodi', ['id'=>$id, 'val'=>$val])
          </div>
        </div>
      </div>
</div>

@endsection
