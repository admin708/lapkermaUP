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
                      <th>MoU</th>
                      <th>IA</th>
                      <th>TOTAL KERJA SAMA</th>

                      <!--  
                      {{-- @if (auth()->user()->role_id != 5) --}}
                      <th>Prodi/Sub Unit Kerja</th>
                      {{-- @endif --}}
                      <th>Negara</th>
                      <th>Jenis Kerjasama</th>
                      <th>Judul</th>
                      <th>Status</th>-->
                      
                    </tr>
                    {{-- <tr>
                      <th>
                        <input type="text" class="form-control form-control-sm" wire:model.lazy="cariMitra">
                      </th>
                      <th>
                        <input type="text" class="form-control form-control-sm" wire:model.lazy="cariMitra">
                      </th>
                      <th>

                      </th>
                      <th>
                        
                      </th>
                      <th>

                      </th>
                    </tr> --}}
                  </thead> 
                  <tbody>
                    <!-- Data rows go here -->
                </tbody>
            </table>
        </div>
    </div>
</div>
