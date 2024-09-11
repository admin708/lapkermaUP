<div class="">
  <style>
    .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(167, 167, 248, 0.589);/* Ubah alpha (0.5) sesuai dengan kebutuhan transparansi */
            z-index: 9999; /* Pastikan nilai z-index lebih tinggi dari elemen lain yang ada */
            overflow: hidden;
        }
  </style>
  <div class="overlay" wire:loading id="overlay"></div>

  <div class="row">
      @php
          $sortedArr = collect($data1)->sortByDesc('nilai')->take(5);
          $sortedArr2 = collect($data2)->sortByDesc('nilai')->take(10);
          $sortedArr3 = collect($arrayGabung)->sortByDesc('nilai')->take(5);
          $maxNilai = $sortedArr->first()['nilai'] + 10;
          $maxNilai2 = $sortedArr2->first()['nilai'] + 10;
          $maxNilai3 = $sortedArr3->first()['nilai'] + 10;
      @endphp



      <div class="col-lg-4" style="padding: 3rem">
          <div class="card">
              <div class="card-body">
                <h5 class="card-title h3">Top 5 Bentuk Kegiatan</h5>
                <hr>
                @foreach ($sortedArr as $key => $item)
                <label class="mb-1">{{ substr( $item['nama'], 0, 36) }}</label>
              <label style="float: right" class="mb-1 text-primary">{{ $item['nilai'] }}</label>
              <div class="progress mb-3" style="height: 21px">
                  <div class="progress-bar bg-info" role="progressbar" style="width: {{ $item['nilai'] * 100/ $maxNilai }}%; font-size: 17px" aria-valuenow="{{ $item['nilai'] }}" aria-valuemin="0" aria-valuemax="{{ $maxNilai }}"></div>
                </div>
                @endforeach
              </div>
            </div>
      </div>
      <div class="col-lg-4" style="padding: 3rem">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title h3">Top 5 Klasifikasi Mitra</h5>
              <hr>
              @foreach ($sortedArr3 as $key => $item)
              <label class="mb-1">{{ substr( $item['nama'], 0, 40) }}</label>
            <label style="float: right" class="mb-1 text-primary">{{ $item['nilai'] }}</label>
            <div class="progress mb-3" style="height: 21px">
                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $item['nilai'] * 100/ $maxNilai3 }}%; font-size: 17px" aria-valuenow="{{ $item['nilai'] }}" aria-valuemin="0" aria-valuemax="{{ $maxNilai3 }}"></div>
              </div>
              @endforeach
            </div>
        </div>
      </div>
      <div class="col-lg-4" style="padding: 3rem">
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title h3 m-0 me-2">Top 10 Negara Mitra</h5>
            <hr>
          </div>
          <div class="card-body">
            <div class="opening-info">
              <ul>
                @foreach ($sortedArr2 as $key => $item)
                  @if ($item['nilai'] > 0)
                    <li style="margin-top: 9px"> <span> {{ $loop->iteration }}. {{ $item['nama'] }}  </span>
                      <div class="pull-right" style="font-weight: 700">{{ $item['nilai'] }} </div>
                    </li>
                    <hr>
                  @endif
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
  </div>
  
  @if ($year && $fakultas)
@php
   $totalProdiD34 = $this->getProdi->whereIn('jenjang',['diploma 3','diploma 4'])->count();
   $totalProdiS1 = $this->getProdi->whereIn('jenjang',['sarjana','profesi'])->count();
   $totalProdiS2 = $this->getProdi->whereIn('jenjang',['magister','doktor'])->count();
  //  $totalProdiSpesialis = $this->getProdi->whereIn('jenjang',['spesialis 1','spesialis 2'])->count();
@endphp
 @if ($totalProdiD34 != 0)
     @include('livewire.dashboard-chart._table_d34')
 @endif
 @if ($totalProdiS1 != 0)
     @include('livewire.dashboard-chart._table_s1')
 @endif
 @if ($totalProdiS2 != 0)
     @include('livewire.dashboard-chart._table_s2')
 @endif
 {{-- @if ($totalProdiSpesialis)
     @include('livewire.dashboard-chart._table_spesialis')
 @endif --}}
@endif
  
</div>
