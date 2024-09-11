<div class="row mb-3">
  <div class="buy-now text-info">
    <div class="d-block btn-buy-now {{ $open == 2 ? 'col-3':'col-1' }} rounded px-3 py-2"
      style="left: 1rem !important;box-shadow: 0 0px !important; background-color: #1966eb21 !important;">
      {{-- <i role="button" wire:click="$set('open', 1)"
        class="text-danger {{ $open == 2 ? 'd-block':'d-none' }} menu-icon tf-icons bx bx-left-arrow"></i> --}}
      {{-- <i role="button" wire:click="$set('open', 1)"
        class="text-danger {{ $open == 2 ? 'd-block':'d-none' }} menu-icon tf-icons bx bx-left-arrow"></i> --}}
      <center>
        <i role="button" wire:click="$set('open', 2)"
          class="text-danger {{ $open == 1 ? 'd-block':'d-none' }} menu-icon tf-icons bx bx-cog"></i>
      </center>
      <div class="{{ $open == 2 ? 'd-block':'d-none' }} my-1 col-12">
        <label>Filter Tahun</label>
        <select style="background-color: #f4f6fb" wire:model.lazy="searchYear" class="form-select">
          <option value="all">All</option>
          @forelse (range(now()->year-5,now()->year) as $item)
          <option value="{{ $item }}">{{ $item }}</option>
          @empty
          <option></option>
          @endforelse
        </select>
      </div>
      <div class="{{ $open == 2 ? 'd-block':'d-none' }} my-1 col-12">
        <label>Filter Fakultas</label>
        <select style="background-color: #f4f6fb" wire:model.lazy="searchFakultas" class="form-select">
          <option value="all">All</option>
          @forelse ($getSelectFakultas as $item)
          <option value="{{ $item->id }}">{{ $item->nama_fakultas }}</option>
          @empty
          <option></option>
          @endforelse
        </select>
      </div>
      <div class="{{ $open == 2 ? 'd-block':'d-none' }} my-1 col-12">
        <label>Filter Prodi</label>
        <select style="background-color: #f4f6fb" wire:model.lazy="searchProdi" class="form-select">
          <option value="all">All</option>
          @forelse ($getSelectProdi as $item)
          <option value="{{ $item->id }}">{{ $item->nama_resmi }}</option>
          @empty
          <option></option>
          @endforelse
        </select>
      </div>
      <center>
        <i role="button" wire:click="$set('open', 1)"
          class="text-danger {{ $open == 2 ? 'd-block':'d-none' }} menu-icon tf-icons bx bx-cog"></i>
      </center>
    </div>
  </div>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1">
      <li class="breadcrumb-item">
        <a href="javascript:void(0);" class="fw-bold h5" style="color: black">{{ $searchYear ? 'DATA TAHUN : ' : 'ALL
          DATA :' }} &ensp; {{ $searchYear }}</a>
      </li>
      @foreach ($getSelectFakultas as $item)
      @if($item->id == $searchFakultas)
      <li class="breadcrumb-item">

        <a  class="fw-bold h5" style="color: black" href="javascript:void(0);">{{ $item->nama_fakultas }}</a>
      </li>
      @endif
      @endforeach
      @foreach ($getSelectProdi as $item)
      @if($item->id == $searchProdi)
      <li class="breadcrumb-item active">

        <a  class="fw-bold h5" style="color: black" href="javascript:void(0);">{{ $item->nama_resmi }}</a>
      </li>
      @endif
      @endforeach
    </ol>
  </nav>
  <div class="col-12 col-lg-4 my-3">
    <div class="card" style="min-height: 150px; background-color: #f4f6fb">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3" style="position: relative;">
          <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
            <div class="card-title">
              <div class="text-xs text-primary text-uppercase mb-1">
                Memorandum of Understanding
              </div>
              <span class="badge bg-label-primary rounded-pill">MoU</span>
            </div>

          </div>
          <div class="mt-sm-auto">
            <h1 class="mb-0">{{ $countMoU }}</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-12 my-3">
    <div class="card" style="min-height: 150px; background-color: #f4f6fb">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3" style="position: relative;">
          <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
            <div class="card-title">
              <div class="text-xs text-success text-uppercase mb-1">
                Memorandum of Aggreement
              </div>
              <span class="badge bg-label-success rounded-pill">MoA</span>
            </div>

          </div>
          <div class="mt-sm-auto">
            <h1 class="mb-0">{{ $countMoA }}</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-12 my-3">
    <div class="card" style="min-height: 150px; background-color: #f4f6fb">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3" style="position: relative;">
          <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
            <div class="card-title">
              <div class="text-xs text-warning text-uppercase mb-1">
                Implementation Arrangement
              </div>
              <span class="badge bg-label-warning rounded-pill">IA</span>
            </div>

          </div>
          <div class="mt-sm-auto">
            <h1 class="mb-0">{{ $countIA }}</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>