<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="{{route('home')}}" class="app-brand-link">
        <span class="app-brand-logo demo">
          <img src="assetss/img/avatars/unhas.png" alt class="w-px-40 h-auto rounded-circle" />
        </span>
        <span class="demo menu-text fw-bolder ms-2">
          <span class="demo menu-text fw-bolder ms-2 text-primary">Sistem Informasi</span>
          <hr style="margin-bottom: 2px; margin-top: 3px">
          <span style="font-size: 11px" class="demo menu-text fw-bolder ms-2 text-danger">Kerjasama & Kemitraan</span>
        </span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>

    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-3">
      @if (auth()->user()->role_id == 2)
      <li class="menu-item">
        <a class="menu-link">
            <span style="font-size: 10px">{{ auth()->user()->fakultas->nama_fakultas }} / {{ auth()->user()->prodi->nama_resmi }}</span>
        </a>
      </li>
      @elseif (auth()->user()->role_id == 1)
      <li class="menu-item">
        <a class="menu-link">
            <span style="font-size: 10px">ADMIN PUSAT</span>
        </a>
      </li>
      @elseif (auth()->user()->role_id == 4)
      <li class="menu-item">
        <a class="menu-link">
            <span style="font-size: 10px">PIMPINAN FAKULTAS/UNIT - {{ auth()->user()->fakultas->nama_fakultas??'PUSAT' }}</span>
        </a>
      </li>
      @endif

      {{-- <li class="menu-item {{ request()->route()->getName() == 'index' ? 'active':''}}">
        <a href="{{ route('index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-window-alt"></i>
          <div data-i18n="Basic">Index</div>
        </a>
      </li> --}}
      {{-- @if (auth()->user()->role_id != 4) --}}
      <li class="menu-item {{ request()->route()->getName() == 'home' ? 'active':''}} ">
        <a class="menu-link" href="{{ route(auth()->user()->role_id != 4 ? 'home':'home') }}">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <span>Dashboard</span>
        </a>
      </li>
      {{-- @endif --}}

      {{-- <li class="menu-item {{ request()->route()->getName() == 'InputDataTables' ? 'active':''}} ">
        <a class="menu-link" href="{{ route('InputDataTables') }}">
            <i class="menu-icon tf-icons bx bx-file"></i>
            <span>{{auth()->user()->role_id == 1 ? 'Input Data':'Input / Cek Data'}}</span>
        </a>
      </li> --}}
      <li class="menu-item {{ request()->route()->getName() == 'mou' ? 'active':''}} ">
        <a class="menu-link" href="{{ route('mou') }}">
            <i class="menu-icon tf-icons bx bx-book"></i>
            <span>Daftar MoU</span>
        </a>
      </li>
      <li
        class="menu-item {{ request()->route()->getName() == 'moa' ? 'active open':(request()->route()->getName() == 'ia' ? 'active open':'') }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-table"></i>
          <div data-i18n="Layouts">Table Prodi</div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item {{ request()->route()->getName() == 'moa' ? 'active':'' }}">
            <a href="{{ route('moa') }}" class="menu-link">
              <div data-i18n="Without navbar">MoA</div>
            </a>
          </li>
          <li class="menu-item {{ request()->route()->getName() == 'ia' ? 'active':'' }}">
            <a href="{{ route('ia') }}" class="menu-link">
              <div data-i18n="Without navbar">IA</div>
            </a>
          </li>
        </ul>
      </li>
      <li
        class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-table"></i>
          <div data-i18n="Layouts">Table Non Prodi</div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item">
            <a class="menu-link">
              <div data-i18n="Without navbar">MoA</div>
            </a>
          </li>
          <li class="menu-item">
            <a class="menu-link">
              <div data-i18n="Without navbar">IA</div>
            </a>
          </li>
        </ul>
      </li>
      {{-- @if (auth()->user()->role_id != 4) --}}
      
      <li
        class="menu-item {{ request()->route()->getName() == 'mou-in' ? 'active open':(request()->route()->getName() == 'moa-in' ? 'active open':(request()->route()->getName() == 'ia-in' ? 'active open':'')) }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-file"></i>
          <div data-i18n="Layouts">Input Data {{ auth()->user()->role_id == 1 ? '':'Prodi' }}</div>
        </a>

        <ul class="menu-sub">
          @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 99)
              <li class="menu-item {{ request()->route()->getName() == 'mou-in' ? 'active':'' }}">
                <a href="{{ route('mou-in') }}" class="menu-link">
                  <div data-i18n="Without menu">MoU</div>
                </a>
            @endif
          </li>
          @if (auth()->user()->role_id == 2 || auth()->user()->role_id == 4)
          <li class="menu-item {{ request()->route()->getName() == 'moa-in' ? 'active':'' }}">
            <a href="{{ route('moa-in') }}" class="menu-link">
              <div data-i18n="Without navbar">MoA & IA</div>
            </a>
          </li>
          @endif
        </ul>
      </li>
      @if (auth()->user()->role_id == 2 || auth()->user()->role_id == 4)
      <li
        class="menu-item {{ request()->route()->getName() == 'nonprodi-moa-in' ? 'active open':'' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-file"></i>
          <div data-i18n="Layouts">Input Data Non Prodi</div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item {{ request()->route()->getName() == 'nonprodi-moa-in' ? 'active':'' }}">
            <a href="{{ route('nonprodi-moa-in') }}" class="menu-link">
              <div data-i18n="Without navbar">MoA & IA</div>
            </a>
          </li>
        </ul>
      </li>
      @endif
      {{-- @endif --}}
      
      <li class="menu-item {{ request()->route()->getName() == 'informasi' ? 'active':''}} ">
        <a class="menu-link" href="{{ route('informasi') }}">
            <i class="menu-icon tf-icons bx bx-support"></i>
            <span>Layanan Informasi</span>
        </a>
      </li>
      @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 99)
      @php
      $userz = App\Models\User::where('request', 1)->whereNull('role_id')->count('id');
      @endphp
      <li class="menu-item {{ request()->route()->getName() == 'managemen-user' ? 'active open':(request()->route()->getName() == 'user-non-apps' ? 'active open':($userz >= 1 ? 'open':'')) }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle" >
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Layouts">User</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->route()->getName() == 'managemen-user' ? 'active':'' }}">
            <a href="{{ route('managemen-user') }}" class="menu-link">
              <div data-i18n="Without menu">User Apps</div>
              @if ($userz >= 1)
              <i class="menu-icon tf-icons bx bx-bell text-danger" style="margin-left: 4rem"></i>
              @endif
            </a>
          </li>
          {{-- <li class="menu-item {{ request()->route()->getName() == 'user-non-apps' ? 'active':'' }}">
            <a href="{{ route('user-non-apps') }}" class="menu-link">
              <div data-i18n="Without navbar">User Non APPS</div>
            </a>
          </li> --}}
        </ul>
      </li>
      @endif

    </ul>

  </aside>