<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/png" href="{{asset('assets/img/unhas.png')}}">
    <title>Aplikasi Kerjasama | Universitas Hasanuddin</title>
    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/tailwind.min.css')}}" rel="stylesheet">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />

    <style>
        body.modal-ko {
            overflow: hidden !important;
            pointer-events: none !important;
            }

        .carousel-caption1 {
            position: absolute;
            top: 30%;
            left: 5%;
            z-index: 10;
            padding-top: 20px;
            padding-bottom: 20px;
            color: #f1be40;
            text-align: left;
        }

        .gerak {
            position: relative;
            animation: mymove 3s;
            animation-fill-mode: forwards;
        }

        @keyframes mymove {
            from {left: -120%;}
            to {left: 1%;}
        }

        .gerak2 {
            position: relative;
            animation: mymoves 3s;
            animation-fill-mode: forwards;
        }

        @keyframes mymoves {
            from {left: 120%;}
            to {left: 1%;}
        }
    </style>

    <script>
        var text="Universitas Hasanuddin";
        var delay=50;
        var currentChar=1;
        var destination="[none]";
        function type()
            {
                {
                    var dest=document.getElementById(destination);
                    if (dest)
                    {
                        dest.innerHTML=text.substr(0, currentChar)+"<blink>_</blink>";
                        currentChar++;
                        if (currentChar>text.length)
                        {
                            currentChar=1;
                            setTimeout("type()", 3000);
                        }
                        else
                        {
                            setTimeout("type()", delay);
                        }
                    }
                }
            }
        function startTyping(textParam, delayParam, destinationParam)
            {
                text=textParam;
                delay=delayParam;
                currentChar=1;
                destination=destinationParam;
                type();
            }
    </script>

    @livewireStyles
    
</head>

<body id="page-top bodyz" class="bodyz">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
            @include('Includes._sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
                     >
                    <div><img src="{{asset('assets/img/unhas.png')}}" style="height: 50px"></div>
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <strong style="font-size: 19px !important; ">Aplikasi Kerjasama</strong>

                </nav>
                
                <!-- End of Topbar -->
                @if ($PIN == 'index')
                    @include('Pages.IndexAdmin')
                @elseif ($PIN == 'dashboard')
                    @include('Pages.DashboardAdmin')
                @elseif ($PIN == 'InputDataTables')
                    @include('Pages.InputDataTables')
                @elseif ($PIN == 'editData')
                    @include('Pages.EditDataTables')
                @elseif ($PIN == 'ManagemenUser')
                    @include('Pages.ManagemenUser')
                @endif


            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                        {{-- onclick="event.preventDefault(); --}}
                        {{-- document.getElementById('logout-form').submit();" --}}
                        >
                        Logout
                    </a>
                    {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form> --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    {{-- <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>  --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    
    @livewireScripts
    @stack('scripts')
    <script>
  // Customization example
  Fancybox.bind('[data-fancybox="gallery"]', {
    infinite: false
  });
</script>
    <script>
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

        window.livewire.on('blok', param => {
            ech = param['pesan'];
            console.log(ech);
                $("body").addClass("modal-ko");

        })
        window.livewire.on('openz', param => {
            ech = param['pesan'];
            console.log(ech);
                $("body").removeClass("modal-ko");

        })

        window.livewire.on('repage', param => {
            pesan = param['pesan'];
            console.log(pesan);
            // location.reload();
            setTimeout("location.reload(true);", 500);
        })
    </script>
    <script language="JavaScript">
        javascript:startTyping(text, 230, "textDestination");
    </script>

</body>

</html>
