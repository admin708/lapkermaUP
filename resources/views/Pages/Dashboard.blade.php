@extends('MasterApp.Borders')
@push('titleNav')
<span class="text-muted fw-light">Dashboard/</span> Laporan Kerjasama
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
@push('first-scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

  @livewire('dashboard-chart.filter-chart')

  <div class="row">
    <div class="col-12 h-100 mb-3">
      @livewire('dashboard-chart.map')
    </div>
    <div class="col-12 col-lg-5 h-100 mb-3">
      @livewire('dashboard-chart.status-kerjasama')
    </div>
    <div class="col-12 col-lg-7 h-100 mb-3">
      @livewire('dashboard-chart.riwayat-kerjasama')
    </div>
    {{-- @if (auth()->user()->id == 3) --}}
    <div class="col-12 h-100 mb-3">
      @livewire('dashboard-chart.table')
    </div>
    {{-- @endif --}}
  </div>
</div>

@stack('first-scripts')

@stack('chart-statusKerjasama')
@stack('chart-riwayatKerjasama')

@endsection
