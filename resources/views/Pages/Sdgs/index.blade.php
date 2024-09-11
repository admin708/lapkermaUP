@extends('MasterApp.Borders')
@push('titleNav')
<span class="text-muted fw-light">Sustainable Development Goals (SDGS)</span> 
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
    document.addEventListener('livewire:load', function () {
        Livewire.on('modalClosed', () => {
            const modal = document.querySelector('.modal.show');
            if (modal) {
                modal.classList.remove('show');
                modal.style.display = 'none';
            }
        });
    });
</script>
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
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Heading -->

    <div class="col-xl-12">
        <div class="nav-align-top mb-4">
          <div class="tab-content">
                @livewire('sdgs.index')
          </div>
        </div>
      </div>
</div>

@endsection
