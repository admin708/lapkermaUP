<div class="card">
    <h5 class="card-header bg-primary p-3 text-white">Data Table</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap mt-3">
            <button wire:click="download()" type="button" class="btn btn-sm mb-3 btn-outline-primary">
                <span class="tf-icons bx bx-download"></span>&nbsp; Download Exel
            </button>
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
                        <tr>
                            <th>{{$referenceCount->prodi_id }}</th>
                            <th>{{$referenceCount->prodi_name}}</th>
                            <th>{{ $referenceCount->moa_reference_count }}</th>
                            <th>{{ $referenceCount->ia_reference_count }}</th>
                            <th>{{ $referenceCount->mou_reference_count }}</th>
                            <th>{{ $referenceCount->total_reference_count }}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
</div>
