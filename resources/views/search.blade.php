<!DOCTYPE html>
<html lang="en">

<head>

    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Examin - Education and LMS Template">

    <!-- ========== Page Title ========== -->
    <title>Laporan Kerjasama | UNHAS</title>

    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="{{asset('new_template/assets/img/unhas.png')}}" type="image/x-icon">

    <!-- ========== Start Stylesheet ========== -->
    <link href="{{asset('new_template/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('new_template/assets/css/font-awesome.min.css')}}" rel="stylesheet" />
    <link href="{{asset('new_template/assets/css/flaticon-set.css')}}" rel="stylesheet" />
    <link href="{{asset('new_template/assets/css/elegant-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('new_template/assets/css/magnific-popup.css')}}" rel="stylesheet" />
    <link href="{{asset('new_template/assets/css/owl.carousel.min.css')}}" rel="stylesheet" />
    <link href="{{asset('new_template/assets/css/owl.theme.default.min.css')}}" rel="stylesheet" />
    <link href="{{asset('new_template/assets/css/animate.css')}}" rel="stylesheet" />
    <link href="{{asset('new_template/assets/css/bootsnav.css')}}" rel="stylesheet" />
    <link href="{{asset('new_template/assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('new_template/assets/css/responsive.css')}}" rel="stylesheet" />
    <!-- ========== End Stylesheet ========== -->

    <!-- ========== Google Fonts ========== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/svg-pan-zoom@3.6.1/dist/svg-pan-zoom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/StephanWagner/svgMap@v2.10.1/dist/svgMap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/StephanWagner/svgMap@v2.10.1/dist/svgMap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        .top3{
            margin-top: 3.5rem;
            margin-right: 1rem;
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
            padding-left: 0.625rem;
            font-size: 1.1rem;
            border-radius: 0.25rem;
        }
    </style>
    @livewireStyles
</head>

<body>
    <!-- Start Header Top 
    ============================================= -->
    <div class="top-bar-area address-two-lines bg-dark text-light">
        <div class="container">
            <div class="row">
                <div class="col-md-8 address-info">
                    <div class="info box">
                        <ul>
                            @foreach (\App\Models\ContactInfo::where('status',1)->get() as $item)
                            <li>
                                <span><img src="{{asset('new_template/assets/img/whatsappwhite.png')}}" style="margin-right: 3px" height="15">{{$item->nama}}</span>
                                <a class="" href="https://wa.me/{{$item->no_hp}}?text=" target="blank">
                                    +{{$item->no_hp}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @if (auth()->check())
                    <div class="user-login text-right col-md-4">
                        <a  href="{{route('index')}}">
                            <i class="fas fa-table"></i> Admin Panel
                        </a>
                    </div>
                @else
                    <div class="user-login text-right col-md-4">
                        <a  class="popup-with-form" href="#login-form">
                            <i class="fas fa-user"></i> Login
                        </a>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
    <!-- End Header Top -->

    <!-- Header 
    ============================================= -->
    <header id="home">

        <!-- Start Navigation -->
        <nav class="navbar navbar-default navbar-sticky bootsnav" style="z-index: 2">

            <!-- Start Top Search -->
            <div class="container">
                <div class="row">
                    <div class="top-search">
                        <div class="input-group">
                            <form action="#">
                                <input type="text" name="text" class="form-control" placeholder="Search">
                                <button type="submit">
                                    <i class="fas fa-search"></i>
                                </button>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Top Search -->

            <div class="container">

                <!-- Start Atribute Navigation -->
                {{-- <div class="attr-nav">
                    <ul>
                        <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                    </ul>
                </div>         --}}
                <!-- End Atribute Navigation -->

                <!-- Start Header Navigation -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="fa fa-bars"></i>
                        </button>
                        <a class="navbar-brand" href="{{route('index')}}">
                            <img src="{{asset('new_template/assets/img/logo_new.png')}}" class="logo" alt="Logo" style="max-width: 230px">
                        </a>
                    </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
            </div>

        </nav>
        <!-- End Navigation -->

    </header>
    <!-- End Header -->

    <!-- Start Login Form 
    ============================================= -->
    <form action="{{ route('login') }}" method="post" id="login-form" class="mfp-hide white-popup-block">
        <div class="col-md-4 login-social">
            {{-- <h3 style="margin-top: 30px">Aplikasi ditutup sementara sedang dilakukan maintenance</h3> --}}
            <h5 style="margin-top: 30px; font-weight: 700">LAPORAN KERJASAMA UNIVERSITAS HASANUDDIN</h5>
            <div style="font-size: 12px">
                <label>UPDATE :</label>
                <label>- Dashboard Dapat diakses secara umum</label>
                <label>- Update Dashboard (Map Sebaran kerjasama)</label>
                <label>- Menambahkan Menu Upload Laporan MoA dan Ia</label>
            </div>
        </div>
        <div class="col-md-8 login-custom">
            <h4>Gunakan User & Password Apps Anda !</h4>
                @csrf
                    <div>
                        <input type="text" name="email" class="form-control" value="{{old('email')}}" placeholder="NIP / USER APPS">
                    </div>
                    <br>
                    <div>
                        <input type="password" name="password" class="form-control" placeholder="PASSWORD" required>
                    </div>
                    @if(session('errors'))
                        <div class="mt-1 alert bg-rgba-danger mb-1" style="margin-bottom: 0px">
                            <i class="bx bx-info-circle align-middle"></i>
                            <span class="align-middle">
                                @foreach ($errors->all() as $error)
                                {{ $error }}
                                @endforeach
                            </span>
                        </div>
                    @endif
                        <hr>
                    <button type="submit" class="btn btn-primary btn-block">Log In</button>
        </div>
    </form>
    <!-- End Login Form -->
    @livewire('dashboard-chart.search')
    <!-- Start Top Categories 
    ============================================= -->
    <div id="top-categories" class="top-cat-area bottom-less" style="padding-top: 30px; min-height: 700px">
        <div class="container">
            <div class="row">
                <div class="col-12 top-cat-items">
                    @if ($results)
                        <table class="table table-border table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NO. DOKUMEN</th>
                                    <th>PENGGIAT KERJASAMA</th>
                                    <th>DOKUMEN KERJASAMA</th>
                                    <th>UNIV/FAKULTAS/PRODI</th>
                                    <th>NEGARA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($results as $item)
                                    
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->nomor_dok_unhas}}</td>
                                        <td>
                                            @foreach (json_decode($item->penggiat) as $value)
                                                <li>{{$value}}</li>
                                            @endforeach
                                        </td>
                                        <td>{{$item->this}}</td>
                                        @if ($item->this == 'MoU')
                                            <td>UNIVERSITAS</td>
                                        @else
                                            @php
                                                $prodi = \App\Models\Prodi::find($item->prodi_id)?->nama_resmi;
                                                $fakultas = \App\Models\Prodi::find($item->prodi_id)?->fakultas->nama_fakultas;
                                            @endphp
                                            <td>{{$fakultas}} / {{$prodi}}</td>
                                        @endif
                                        <td>{{$item->negara}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Belum ada kerjasama</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Top Categories -->

    <!-- Start Footer 
    ============================================= -->
    <!-- Start Footer Bottom -->
    <div class="footer-bottom bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 text-right link">
                        <ul>
                            <li>
                                <a target="blank" href="http://dsitd.unhas.ac.id" style="font-size: 9px">@ DSITD-Unhas</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Bottom -->

    <div id="myDiv" class="side
    @if(session('errors'))
    on
    @endif
    
    ">
        <a href="/" onclick="removeClass()"  class="close-side"><i class="fa fa-times"></i></a>
        <div class="widget">
            <h4 class="title">Error Login</h4>
            
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                
                @endforeach
            </ul>
        </div>
       
        
    </div>
    <!-- End Footer -->
    @livewireScripts
    <!-- jQuery Frameworks
    ============================================= -->
    <script src="{{asset('new_template/assets/js/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('new_template/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('new_template/assets/js/equal-height.min.js')}}"></script>
    <script src="{{asset('new_template/assets/js/jquery.appear.js')}}"></script>
    <script src="{{asset('new_template/assets/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('new_template/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('new_template/assets/js/modernizr.custom.13711.js')}}"></script>
    <script src="{{asset('new_template/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('new_template/assets/js/wow.min.js')}}"></script>
    <script src="{{asset('new_template/assets/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('new_template/assets/js/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{asset('new_template/assets/js/count-to.js')}}"></script>
    <script src="{{asset('new_template/assets/js/loopcounter.js')}}"></script>
    <script src="{{asset('new_template/assets/js/bootsnav.js')}}"></script>
    <script src="{{asset('new_template/assets/js/main.js')}}"></script>
    @stack('custom-scripts')
    @stack('chart-riwayatKerjasama')
    @stack('chart-statusKerjasama')
    <script>
        function removeClass() {
    // Mendapatkan elemen div berdasarkan ID
    var divElement = document.getElementById('myDiv');

    // Menghapus class tertentu dari elemen div
    divElement.classList.remove('on');
}

    </script>
</body>
</html>