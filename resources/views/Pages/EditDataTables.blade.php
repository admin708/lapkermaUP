@extends('MasterApp.Borders')
@push('titleNav')
<span class="text-muted fw-light">Edit /</span> Data
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Heading -->
        @livewire('edit-data-tables', ['id' => $id ])
</div>
</div>
@endsection