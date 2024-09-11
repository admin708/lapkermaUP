<style>
    .ground {
        background:rgba(255, 255, 255, 0.9);
        color:black !important;
    }
    .bg-gradient-primary2 {
        /* background-color: #960019; */
        background: #800000;
        background-size: cover;
    }
    .page-link1 {
    position: relative;
    display: block;
    padding: .5rem .5rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #d0d5e1;
    /* background-color: #fff; */
    /* border: 1px solid #dddfeb; */
    }
</style>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary2 sidebar sidebar-dark accordion" id="accordionSidebar">

    <div class="profile">
        <img src="{{asset('assets/img/png2.png')}}" alt="" class="rounded-circle" style="width: 130px; background-color: #fff; margin: 27px auto; border: 9px solid #2c2f3f">
        <h1 style="font-size: 15px !important; text-align: center; font-weight: 700; font-family: poppins, sans-serif; margin-top: -7px !important" class="text-light uppercase"><a style="text-decoration-none">{{auth()->user()->name}}</a></h1>
        <h1 style="font-size: 12px !important; text-align: center; font-weight: 700; font-family: poppins, sans-serif;" class="text-light">
            @if (auth()->user()->role_id == 2)
                <a style="text-decoration-none">{{auth()->user()->fakultas->nama_fakultas}}</a>
            @else
                <a style="text-decoration-none">Admin Pusat</a>
            @endif
        </h1>
        <div class="mt-3 text-center">
            <nav>
                @livewire('info')
            </nav>
        </div>
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{$PIN == 'index' ? 'active':''}} ">
        <a class="nav-link" href="{{route('index')}}">
            <i class="fas fa-fw fa-globe"></i>
            <span>Aplikasi Kerjasama</span></a>
    </li>
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{$PIN == 'dashboard' ? 'active':''}} ">
        <a class="nav-link" href="{{ route('menu','dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    {{-- <hr class="sidebar-divider"> --}}

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{$PIN == 'InputDataTables' ? 'active':''}} ">
        <a class="nav-link" href="{{ route('menu','InputDataTables') }}">
            <i class="fas fa-fw fa-file"></i>
            <span>{{auth()->user()->role_id == 1 ? 'Input Data':'Input / Cek Data'}}</span></a>
    </li>

    @if (auth()->user()->role_id == 1)
    <li class="nav-item {{$PIN == 111 ? 'active':''}} ">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-file"></i>
            <span>Tambah User nonApps</span></a>
    </li>
    @endif

    {{-- @if (auth()->user()->role_id == 2)
    <li class="nav-item {{$PIN == 20 ? 'active':''}} ">
        <a class="nav-link" href="{{route('plus',20)}}">
            <i class="fas fa-fw fa-file"></i>
            <span>Input Data</span></a>
    </li>
    @endif --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
