@extends('MasterApp.Borders')
@push('titleNav')
    Index
@endpush
@push('custom-style')
<script src="https://cdn.jsdelivr.net/npm/svg-pan-zoom@3.6.1/dist/svg-pan-zoom.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/StephanWagner/svgMap@v2.10.1/dist/svgMap.min.js"></script>
<link href="https://cdn.jsdelivr.net/gh/StephanWagner/svgMap@v2.10.1/dist/svgMap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
@push('livewire-style')
@livewireStyles
@endpush
@push('livewire-scripts')
@livewireScripts
@endpush
@section('content')
<div class="mt-3">
  {{-- @livewire('dashboard-chart.search') --}}
  @livewire('dashboard-chart.map-dashboard')
</div>
@endsection