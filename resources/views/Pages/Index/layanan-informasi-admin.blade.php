@extends('MasterApp.Borders')
@push('titleNav')
    Layanan Informasi
@endpush
@push('livewire-style')
@livewireStyles
@endpush
@push('livewire-scripts')
@livewireScripts
@endpush
@push('first-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endpush
@push('custom-scripts')
    <script>
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
    </script>
@endpush
@section('content')
     <!-- Content wrapper -->
     <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            @livewire('contact.index')
        </div>
        <!-- / Content -->
      </div>
      <!-- Content wrapper -->
@endsection
