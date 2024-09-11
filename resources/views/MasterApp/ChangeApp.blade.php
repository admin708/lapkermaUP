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
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('change/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('change/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('change/vendor/aos/aos.css')}}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{asset('change/css/style.css')}}" rel="stylesheet">
    @livewireStyles

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <br>
        <div class="container d-flex align-items-center">

            <h1 class="logo mr-auto"></h1>

            <a class="get-started-btn scrollto" href="{{ route('logout') }}">Logout</a>

        </div>
    </header><!-- End Header -->
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center" style="height: 928px !important; margin-top: -50px">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up" data-aos-delay="200">
                    <center>
                        <h1>Laporan Kerjasama</h1>
                        <h1>Universitas Hasanuddin</h1>
                    </center>
                    <hr class="my-3">

                    @if (auth()->user()->request != null)
                    <center>
                        <h2>Request Telah dikirim, Tunggu hingga Admin Pusat Mengkonfirmasi permintaan anda.</h2>
                    </center>
                    @else
                    <a class="btn btn-success mb-3" href="#" data-toggle="modal" data-target="#creatModal">Minta
                        Akses</a>

                    <center>
                        <h2>Klik tombol minta akses untuk mengirim permintaan ke Admin Pusat</h2>
                    </center>
                    @endif
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{asset('change/img/hero-img.png')}}" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="creatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kirim Permintaan Ke Admin Pusat</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @livewire('request-role')
            </div>
        </div>
    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    @livewireScripts

    <script>
        window.livewire.on('repage', param => {
            pesan = param['pesan'];
            console.log(pesan);
            // location.reload();
            setTimeout("location.reload(true);", 500);
        })

        window.livewire.on('alert', param => {
            // alert(param['pesan'])
            let timerInterval
            Swal.fire({
            icon: param['icon'],
            title: param['pesan'],
            // html: 'I will close in <b></b> milliseconds.',
            timer: 700,
            timerProgressBar: true,
            onBeforeOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                    const b = content.querySelector('b')
                    if (b) {
                    b.textContent = Swal.getTimerLeft()
                    }
                }
                }, 100)
            },
            onClose: () => {
                // window.location.reload();
                // clearInterval(timerInterval)
            }
            }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
            })
        })
    </script>

</body>

</html>
