<div class="card">
    <h5 class="card-header bg-primary p-3 text-white">Data Table</h5>
    <div class="card-body">
        <div class="d-flex flex-row-reverse bd-highlight mt-3">
            <div class="dropdown jenis_kerja_sama px-3">
                <button class="btn btn-outline-primary dropdown-toggle "  role="button" data-bs-toggle="dropdown"
                >
                  Jenis Kerja Sama
                </button>
              
                <ul class="dropdown-menu ">
                  <li><a class="dropdown-item" >All</a></li>
                  <li><a class="dropdown-item" >Dalam Negeri</a></li>
                  <li><a class="dropdown-item" >Luar Negeri</a></li>
                </ul>
            </div> 
            <div class="dropdown order_by ">
                <button class="btn btn-outline-primary dropdown-toggle "  role="button" data-bs-toggle="dropdown" >
                  Urut Berdasarkan
                </button>
              
                <ul class="dropdown-menu text-primary">
                    <li class="dropdown-item">PRODI</li>
                    <li class="dropdown-item">MoA</li>
                    <li class="dropdown-item">IA</li>
                    <li class="dropdown-item">MoU</li>
                    <li class="dropdown-item">TOTAL KERJA SAMA</li>
                </ul>
              </div>  
        </div>
        <div class="table-responsive text-nowrap mt-3">
            <table class="table table-bordered table-hover table-sm" style="font-size: 13px">
                <thead>
                    <tr>
                      <th>ID</th>
                      <th>PRODI</th>
                      <th>MoA</th>
                      <th>IA</th>
                      <th>MoU</th>
                      <th>TOTAL KERJA SAMA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($referenceCounts as $referenceCount)
                    <tr style="font-size: 11px">
                        <td>{{$referenceCount->prodi_id ?? 0}}</td>
                        <td>{{$referenceCount->prodi_name ?? 0}}</td>
                        <td>{{ $referenceCount->moa_reference_count ?? 0}}</td>
                        <td>{{ $referenceCount->ia_reference_count ?? 0}}</td>
                        <td>{{ $referenceCount->mou_reference_count ?? 0}}</td>
                        <td>{{ $referenceCount->total_reference_count ?? 0}}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
</div>
