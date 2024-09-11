<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <link rel="icon" type="image/png" href="{{asset('assets/img/unhas.png')}}">
  <title>Laporan Kerjasama | Universitas Hasanuddin</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('change/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('change/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{asset('change/vendor/aos/aos.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('change/css/style.css')}}" rel="stylesheet">
</head>
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <br>
    <div class="container d-flex align-items-center">
      <h1 class="logo mr-auto" style="color: white">Login Page</h1>
    </div>
  </header><!-- End Header -->
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center" style="height: 928px !important; margin-top: -50px">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>Laporan Kerjasama</h1>
          <h1>Universitas Hasanuddin</h1>
          <div class="card-content" style="margin-top: 10px">
            <form action="{{ route('login') }}" method="post">
                @csrf
                    <div>
                        {{-- <label><strong style="color: white">NIP</strong></label> --}}
                        <input type="text" name="email" class="form-control" value="{{old('email')}}" placeholder="NIP / USER APPS">
                    </div>
                    <br>
                    <div>
                        {{-- <label for=""><strong style="color: white">Password</strong></label> --}}
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
            </form>
        </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="{{asset('change/img/hero-img.png')}}" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>
  </section>

  <footer id="footer" style="height: 193px">
    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>Arsha</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{asset('change/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('change/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('change/vendor/waypoints/jquery.waypoints.min.js')}}"></script>
  <script src="{{asset('change/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('change/vendor/venobox/venobox.min.js')}}"></script>
  <script src="{{asset('change/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
  <script src="{{asset('change/vendor/aos/aos.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('change/js/main.js')}}"></script>

</body>

</html>
