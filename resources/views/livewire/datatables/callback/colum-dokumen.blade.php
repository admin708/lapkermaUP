<div class="col-12 row">

    @php
    $dokumen = \App\Models\DokumenLapkerma::where('kerjasama_id', $id)->get();
    @endphp
    @forelse ($dokumen as $item)
      <div class="col-7 text-primary" role="button" data-fancybox data-options='{"type" : "iframe", "iframe" : {"preload" : false, "css" : {"width" : "600px"}}}'
        data-src="{{asset('storage/DokumenLapkerma/'.$item->url)}}">
        <u>Dokumen#{{ $loop->iteration }}</u>
      </div>
    @empty
      <img class="img-fluid img-thumbnail" src="{{asset('storage/Dokumen/Capture.PNG')}}">
    @endforelse
  
  </div>