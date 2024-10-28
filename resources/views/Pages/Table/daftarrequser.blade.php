@extends('MasterApp.Borders')

@push('titleNav')
    <span class="text-muted fw-light">Data Table /</span> User Verification Request
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
        Fancybox.bind('[data-fancybox="gallery"]', {
            infinite: false
        });
    </script>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Heading -->
        <div class="card p-3">
            <div id="newpost">
                <h1 class="h4">User Verification Request</h1>
                <hr class="m-3">
                @livewire('datatables.daftar-req-user')
            </div>
        </div>
    </div>
@endsection
