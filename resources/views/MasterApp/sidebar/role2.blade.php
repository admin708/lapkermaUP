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
      <li class="menu-item">
        <a class="menu-link">
            <span style="font-size: 10px">{{ auth()->user()->fakultas->nama_fakultas }} / {{ auth()->user()->prodi->nama_resmi }}</span>
        </a>
      </li>

      <li class="menu-item {{ request()->route()->getName() == 'home' ? 'active':''}} ">
        <a class="menu-link" href="{{ route('home') }}">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <span>Dashboard</span>
        </a>
      </li>
      
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
        class="menu-item {{ request()->route()->getName() == 'mou-in' ? 'active open':(request()->route()->getName() == 'moa-in' ? 'active open':(request()->route()->getName() == 'ia-in' ? 'active open':'')) }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-file"></i>
          <div data-i18n="Layouts">Input Data Prodi</div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item {{ request()->route()->getName() == 'moa-in' ? 'active':'' }}">
            <a href="{{ route('moa-in') }}" class="menu-link">
              <div data-i18n="Without navbar">MoA & IA</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item {{ request()->route()->getName() == 'informasi' ? 'active':''}} ">
        <a class="menu-link" href="{{ route('informasi') }}">
            <i class="menu-icon tf-icons bx bx-support"></i>
            <span>Layanan Informasi</span>
        </a>
      </li>
    </ul>

  </aside>