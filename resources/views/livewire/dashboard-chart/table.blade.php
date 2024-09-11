<div class="row">
    @php
        $sortedArr = collect($data1)->sortByDesc('nilai')->take(5);
        $sortedArr2 = collect($data2)->sortByDesc('nilai')->take(10);
        $sortedArr3 = collect($arrayGabung)->sortByDesc('nilai')->take(5);
        $maxNilai = $sortedArr->first()['nilai'] + 10;
        $maxNilai2 = $sortedArr2->first()['nilai'] + 10;
        $maxNilai3 = $sortedArr3->first()['nilai'] + 10;
    @endphp
    {{-- @dd($data3) --}}
   {{-- {{ $maxNilai2 }} --}}

    <div class="col-lg-4">
        <div class="card" style="background-color: #f4f6fb">
            <div class="card-body">
              <h5 class="card-title">Top 5 Bentuk Kegiatan</h5>
              @foreach ($sortedArr as $key => $item)
              <!-- Progress Bars with Backgrounds-->
              <label class="mb-1">{{ substr( $item['nama'], 0, 36) }}</label>
            <label style="float: right" class="mb-1 text-primary">{{ $item['nilai'] }}</label>
            <div class="progress mb-3" style="height: 21px">
                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $item['nilai'] * 100/ $maxNilai }}%; font-size: 17px" aria-valuenow="{{ $item['nilai'] }}" aria-valuemin="0" aria-valuemax="{{ $maxNilai }}"></div>
              </div>
              @endforeach
            </div>
          </div>
    </div>
    {{-- @if (auth()->user()->id == 3) --}}

    <div class="col-lg-4">
      <div class="card" style="background-color: #f4f6fb">
          <div class="card-body">
            <h5 class="card-title">Top 5 Klasifikasi Mitra</h5>
            @foreach ($sortedArr3 as $key => $item)
            <!-- Progress Bars with Backgrounds-->
            <label class="mb-1">{{ substr( $item['nama'], 0, 40) }}</label>
          <label style="float: right" class="mb-1 text-primary">{{ $item['nilai'] }}</label>
          <div class="progress mb-3" style="height: 21px">
              <div class="progress-bar bg-info" role="progressbar" style="width: {{ $item['nilai'] * 100/ $maxNilai3 }}%; font-size: 17px" aria-valuenow="{{ $item['nilai'] }}" aria-valuemin="0" aria-valuemax="{{ $maxNilai3 }}"></div>
            </div>
            @endforeach
          </div>
        </div>
  </div>
  {{-- @endif --}}
    <div class="col-lg-4">
      <div class="card" style="background-color: #f4f6fb">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Top 10 Negara Mitra</h5>
        </div>
        <div class="card-body">
          <ul class="p-0 m-0">
          @foreach ($sortedArr2 as $key => $item)
          @if ($item['nilai'] > 0)
              
            <li class="d-flex mb-4 pb-1">
                  <div class="flex-shrink-0 me-3">
                <img src="assetss/img/negara/{{ $item['flag'] }}" alt="User">
              </div>
              
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="text-muted d-block mb-1">No. {{ $loop->iteration }}</small>
                  <h6 class="mb-0">{{ $item['nama'] }}</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                  <h6 class="mb-0">{{ $item['nilai'] }}</h6>
                </div>
              </div>
            </li>
          @endif

          @endforeach
          </ul>
        </div>
        </div>
  </div>
</div>
