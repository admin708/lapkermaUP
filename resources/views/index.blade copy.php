<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<title>Fionca - HTML 5 Template Preview</title>

<base href="{{asset('new_template')}}/">

<!-- Fav Icon -->
<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Arimo:400,400i,700,700i&display=swap" rel="stylesheet">

<!-- Stylesheets -->
<link href="assets/css/font-awesome-all.css" rel="stylesheet">
<link href="assets/css/flaticon.css" rel="stylesheet">
<link href="assets/css/owl.css" rel="stylesheet">
<link href="assets/css/bootstrap.css" rel="stylesheet">
<link href="assets/css/jquery.fancybox.min.css" rel="stylesheet">
<link href="assets/css/animate.css" rel="stylesheet">
<link href="assets/css/color.css" rel="stylesheet">
<link href="assets/css/rtl.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<link href="assets/css/responsive.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/svg-pan-zoom@3.6.1/dist/svg-pan-zoom.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/StephanWagner/svgMap@v2.10.1/dist/svgMap.min.js"></script>
<link href="https://cdn.jsdelivr.net/gh/StephanWagner/svgMap@v2.10.1/dist/svgMap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


@livewireStyles
</head>


<!-- page wrapper -->
<body class="boxed_wrapper ltr">

    <!-- page-direction -->
    <div class="page_direction">
        <div class="demo-rtl direction_switch"><button class="rtl">RTL</button></div>
        <div class="demo-ltr direction_switch"><button class="ltr">LTR</button></div>
    </div>
    <!-- page-direction end -->
    
    <!-- main header -->
    <header class="main-header style-one" style="margin-top: -23px">
        <div class="header-top">
            <div class="auto-container">
                <div class="top-inner clearfix">
                    <ul class="info top-left pull-left">
                        <li><i class="fas fa-map-marker-alt"></i>838 Andy Street, Madison, NJ 08003</li>
                        <li><i class="fas fa-headphones"></i>Support <a href="tel:01005200369">0100 5200 369</a></li>
                    </ul>
                    <div class="top-right pull-right">
                        <ul class="social-links clearfix">
                            <li><a href="index.html"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="index.html"><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href="index.html"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="index.html"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="index.html"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-lower">
            <div class="auto-container">
                <div class="outer-box clearfix">
                    <div class="logo-box pull-left">
                        <figure class="logo"><a href="index.html"><img src="assets/images/logo_new.png" alt=""></a></figure>
                    </div>
                    
                </div>
            </div>
        </div>

        
    </header>
    <!-- main-header end -->

    


    <!-- banner-section -->
    <section class="banner-section">
        @livewire('dashboard-chart.map')
    </section>
    <!-- banner-section end -->


    <!-- info-section -->
    <section class="info-section p-0">
        <div class="auto-container">
            @livewire('dashboard-chart.filter-chart')
            <div class="row">
                  <div class="col-12 h-100 mb-3">
                    @livewire('dashboard-chart.riwayat-kerjasama')
                  </div>
                  <div class="col-12 h-100 mb-3">
                    @livewire('dashboard-chart.table')
                  </div>
            </div>
        </div>
    </section>
    <!-- info-section end -->




    <!-- main-footer -->
    <footer class="main-footer">
        <div class="footer-top">
            <div class="auto-container">
                <div class="widget-section">
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget logo-widget">
                                <figure class="footer-logo"><a href="index.html"><img src="assets/images/footer-logo.png" alt=""></a></figure>
                                <div class="text">
                                    <p>Tempor incididunt ut labore eut dolore veniam quis nostrud exercitation ullamc consequat. Duis aute irure.</p>
                                </div>
                                <ul class="info-list clearfix">
                                    <li><i class="fas fa-map-marker-alt"></i>838 Andy Street, Madison, NJ 08003</li>
                                    <li><i class="fas fa-envelope"></i>Email <a href="mailto:support@my-domain.com">support@my-domain.com</a></li>
                                    <li><i class="fas fa-headphones"></i>Support <a href="tel:01005200369">0100 5200 369</a></li>
                                </ul>
                                <ul class="social-links clearfix">
                                    <li><a href="index.html"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="index.html"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="index.html"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="index.html"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="index.html"><i class="fab fa-pinterest-p"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget links-widget ml-70">
                                <div class="widget-title">
                                    <h4>Useful Links</h4>
                                </div>
                                <div class="widget-content">
                                    <ul class="list clearfix">
                                        <li><a href="index.html">About Us</a></li>
                                        <li><a href="index.html">What We Offers</a></li>
                                        <li><a href="index.html">Testimonials</a></li>
                                        <li><a href="index.html">Our Projectss</a></li>
                                        <li><a href="index.html">Latest News</a></li>
                                        <li><a href="index.html">Privacy Policy</a></li>
                                        <li><a href="index.html">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget links-widget">
                                <div class="widget-title">
                                    <h4>What We Do</h4>
                                </div>
                                <div class="widget-content">
                                    <ul class="list clearfix">
                                        <li><a href="index.html">Financial Advice</a></li>
                                        <li><a href="index.html">Business Planning</a></li>
                                        <li><a href="index.html">Startup Help</a></li>
                                        <li><a href="index.html">Investment Strategy</a></li>
                                        <li><a href="index.html">Management Services</a></li>
                                        <li><a href="index.html">Market Research</a></li>
                                        <li><a href="index.html">SEO Optimization</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget newsletter-widget">
                                <div class="widget-title">
                                    <h4>Newslette</h4>
                                </div>
                                <div class="widget-content">
                                    <div class="text">
                                        <p>Get in your inbox the latest News</p>
                                    </div>
                                    <form action="contact.html" method="post" class="newsletter-form">
                                        <div class="form-group">
                                            <i class="far fa-user"></i>
                                            <select name="" id="">
                                                <option value=""></option>
                                            </select>
                                            <input type="text" name="name" placeholder="Your Name" required="">
                                        </div>
                                        <div class="form-group">
                                            <i class="far fa-envelope"></i>
                                            <input type="email" name="email" placeholder="Email address" required="">
                                        </div>
                                        <div class="form-group message-btn">
                                            <button class="theme-btn style-one" type="submit">subscribe</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="auto-container">
                <div class="copyright"><p>&copy; 2020 <a href="index.html">FIONCA</a> - Business & Consulting. All rights reserved.</p></div>
            </div>
        </div>
    </footer>
    <!-- main-footer end -->



    <!--Scroll to top-->
    <button class="scroll-top scroll-to-target" data-target="html">
        <span class="fa fa-arrow-up"></span>
    </button>


    <!-- sidebar cart item -->
    <div class="xs-sidebar-group info-group info-sidebar">
        <div class="xs-overlay xs-bg-black"></div>
        <div class="xs-sidebar-widget">
            <div class="sidebar-widget-container">
                <div class="widget-heading">
                    <a href="#" class="close-side-widget">X</a>
                </div>
                <div class="sidebar-textwidget">
                <div class="sidebar-info-contents">
                    <div class="content-inner">
                        <div class="upper-box">
                            <div class="logo">
                                <a href="index.html"><img src="assets/images/sidebar-logo.png" alt="" /></a>
                            </div>
                            <div class="text">
                                <p>Exercitation ullamco laboris nis aliquip sed conseqrure dolorn repreh deris ptate velit ecepteur duis.</p>
                            </div>
                        </div>
                        <div class="side-menu-box">
                            <div class="side-menu">
                                <nav class="menu-box">
                                    <div class="menu-outer">
                                        
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <div class="info-box">
                            <h3>Get in touch</h3>
                            <ul class="info-list clearfix">
                                <li><i class="fas fa-map-marker-alt"></i>838 Andy Street, Madison, NJ</li>
                                <li><i class="fas fa-envelope"></i><a href="mailto:support@my-domain.com">support@my-domain.com</a></li>
                                <li><i class="fas fa-headphones-alt"></i><a href="tel:101005200369">+1  0100 5200 369</a></li>
                                <li><i class="far fa-clock"></i>Monday to Friday: 9am - 6pm</li>
                            </ul>
                            <form action="contact.html" method="post" class="subscribe-form">
                                <div class="form-group">
                                    <input type="email" name="email" placeholder="Email address" required="">
                                    <button type="submit" class="theme-btn style-one">subscribe now</button>
                                </div>
                            </form>
                            <ul class="social-links clearfix">
                                <li><a href="index.html"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="index.html"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="index.html"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="index.html"><i class="fab fa-google-plus-g"></i></a></li>
                                <li><a href="index.html"><i class="fab fa-pinterest-p"></i></a></li>
                                <li><a href="index.html"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- END sidebar widget item -->
@livewireScripts

<!-- jequery plugins -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.js"></script>
<script src="assets/js/wow.js"></script>
<script src="assets/js/validation.js"></script>
<script src="assets/js/jquery.fancybox.js"></script>
<script src="assets/js/appear.js"></script>
<script src="assets/js/jquery.countTo.js"></script>
<script src="assets/js/scrollbar.js"></script>
<script src="assets/js/nav-tool.js"></script>
<script src="assets/js/TweenMax.min.js"></script>
<script src="assets/js/circle-progress.js"></script>
<script src="assets/js/jquery.nice-select.min.js"></script>
<!-- main-js -->
<script src="assets/js/script.js"></script>
@stack('custom-scripts')
@stack('chart-riwayatKerjasama')
@stack('chart-statusKerjasama')

</body><!-- End of .page_wrapper -->
</html>
