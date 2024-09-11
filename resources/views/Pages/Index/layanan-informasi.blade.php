@extends('MasterApp.Borders')
@push('titleNav')
    Layanan Informasi
@endpush
@section('content')
     <!-- Content wrapper -->
     <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-6 col-12 mb-md-0 mb-4">
                  <div class="card">
                    <h5 class="card-header">Kontak Kami</h5>
                    <div class="card-body">
                      <!-- Connections -->
                      @foreach ($getContact as $item)
                      <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                          <img src="assetss/img/icons/brands/whatsapp.png" alt="google" class="me-3" height="40">
                        </div>
                        <div class="flex-grow-1 row">
                          <div class="col-lg-8 col-sm-12 mb-sm-0 mb-2">
                            <h6 class="mb-0">{{ $item->nama }}</h6>
                            <small class="text-muted">+{{ $item->no_hp }}</small>
                          </div>
                          <div class="col-lg-4 col-sm-12 text-end">
                            <div class="form-check form-switch">
                              <a class="btn btn-sm btn-primary" href="https://wa.me/{{ $item->no_hp }}?text=" target="blank">
                                kirim pesan</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      @endforeach
                      <!-- /Connections -->
                    </div>
                  </div>
                </div>
              </div>
        </div>
        <!-- / Content -->
      </div>
      <!-- Content wrapper -->
@endsection
