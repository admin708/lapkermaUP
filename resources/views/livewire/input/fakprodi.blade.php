<div class="col-auto my-2">
    <div class="
            @switch($status[$value]??null)
                @case(3)
                    d-none
                    @break
                @default
            @endswitch
        ">

        <label class="mr-sm-2">Fakultas
            @error('fakultas_pihak.'.$value) <i class="text-sm text-danger">* required</i> @enderror
        </label>

        @if (optional($showProdiDefault)[$value] == 'unhas' || optional($showProdiDefault)[$value] == 'universitas hasanuddin')
            <select wire:model="fakultas_pihak.{{ $value }}" class="form-select form-select-sm mr-sm-2" disabled>
                <option></option>
                @foreach ($fakultas as $item)
                <option value="{{ $item->id }}">{{ $item->nama_fakultas }}</option>
                @endforeach
            </select>
        @else
        <div class="btn-group">
            <input wire:model="fakultas_pihak.{{ $value }}" type="text" class="form-control form-control-sm" data-bs-toggle="dropdown" data-bs-display="static" aria-haspopup="true" aria-expanded="true">
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" data-bs-popper="static">
                <div class="card overflow-hidden" style="height: 200px">
                    <div class="ps ps--active-y " id="vertical-example">
                        @foreach($fakultasMitra as $item)
                        <li><button class="small dropdown-item" type="button">{{ $item->nama_fakultas }}</button></li>
                        @endforeach
                    </div>
                </div>
            </ul>
        </div>
        @endif


    </div>
</div>











<div class="col-auto my-2
    @switch($status[$value]??null)
        @case(3)
            d-none
            @break
        @default
    @endswitch">
    <label>Prodi
        @error('arrayProdi.'.$value) <i class="text-sm text-danger">* required</i> @enderror
    </label>
    <div class="row">
        <div class="col-6 mb-1 {{ optional($showProdiDefault)[$value] == 'unhas' || optional($showProdiDefault)[$value] == 'universitas hasanuddin' ? 'd-block':'' }}"
            style="display: none">
            <input type="text" class="form-control py-1" placeholder="{{ auth()->user()->role_id == 2 ? auth()->user()->prodi->nama_resmi:'' }}" disabled>
        </div>
        <div class="col-12 {{ optional($showProdiDefault)[$value] == 'unhas' || optional($showProdiDefault)[$value] == 'universitas hasanuddin' ? 'd-none':'d-block' }}"
        >
            <div class="btn-group">
                <input type="text" class="form-control form-control-sm" data-bs-toggle="dropdown" data-bs-display="static" aria-haspopup="true" aria-expanded="true">
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" data-bs-popper="static">
                <div class="card overflow-hidden" style="height: 200px">
                    <div class="ps ps--active-y " id="vertical-example">
                        @foreach($prodiAll as $item)
                        <li><button class="small dropdown-item" type="button">{{ $item->nama_resmi }}</button></li>
                        {{-- <option value="{{$item->id}}">{{ $item->nama_resmi }}</option> --}}
                        @endforeach
                        {{-- <div class="ps__rail-x" style="left: 0px; bottom: -856px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 856px; height: 232px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 125px; height: 33px;"></div></div> --}}
                    </div>
                </div>

                </ul>
              </div>

        </div>
        <div class="col-12 {{ optional($showProdiDefault)[$value] == 'unhas' || optional($showProdiDefault)[$value] == 'universitas hasanuddin' ? 'd-block':'d-none' }}"
            >
            <div wire:ignore >
                <select id="multiselect{{ $value }}" multiple wire:model="arrayProdi.{{ $key }}"
                style="width: 100%; border: red">
                @foreach($prodiAll as $item)
                @if ($item->id == auth()->user()->prodi_id)
                <option value="{{$item->id}}" disabled="disabled" >{{ $item->nama_resmi }}</option>
                @else
                <option value="{{$item->id}}">{{ $item->nama_resmi }}</option>

                @endif
                @endforeach
            </select>
            </div>
        </div>
    </div>

</div>
