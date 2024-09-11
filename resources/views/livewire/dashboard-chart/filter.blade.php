<div>
    <div class="collapse navbar-collapse" id="navbar-menu">
        <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#">
            <li>
                <select wire:model="searchYear" class="top3">
                    <option value="">SEMUA TAHUN</option>
                    @forelse (range(now()->year-5,now()->year) as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                    @empty
                    <option></option>
                    @endforelse
                  </select>
            </li>
            <li>
                <select wire:model="searchFakultas" class="top3">
                    <option value="">SEMUA FAKULTAS</option>
                    @foreach ($getSelectFakultas as $item)
                    @if ($item->id != 1000)

                    <option value="{{ $item->id }}">{{ $item->nama_fakultas }}</option>
                    @endif

                    @endforeach
                  </select>
            </li>
            {{-- <li>
                <select wire:model.lazy="searchProdi" class="top3">
                    <option value="">SEMUA PRODI</option>
                    @forelse ($getSelectProdi as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_resmi }}</option>
                    @empty
                    <option></option>
                    @endforelse
                </select>
            </li> --}}
        </ul>
    </div><!-- /.navbar-collapse -->
</div>
