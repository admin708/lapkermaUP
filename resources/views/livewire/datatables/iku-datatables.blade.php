<div class="card">
    <h5 class="card-header bg-primary p-3 text-white">Data Table</h5>
    <div class="card-body">
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
                            <td>{{$referenceCount->prodi_id }}</td>
                            <td>{{$referenceCount->prodi_name}}</td>
                            <td>{{ $referenceCount->moa_reference_count }}</td>
                            <td>{{ $referenceCount->ia_reference_count }}</td>
                            <td>{{ $referenceCount->mou_reference_count }}</td>
                            <td>{{ $referenceCount->total_reference_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
</div>
