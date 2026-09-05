<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Agencia de Viajes</title>
    <meta name="author" content="Alex Granada - Cus-code.com">
    <meta name="description" content="">
    <meta name="keywords" content=" ">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;family=Manrope:wght@200..800&amp;family=Montez&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

    <div class="th-menu-wrapper onepage-nav">
        <div class="th-menu-area text-center"><button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo"><a href="{{ route('home') }}" width="80px">
                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Tourm"></a>
            </div>
            <div class="th-mobile-menu">
                <ul>
                    <li><a class="active" href="{{ route('home') }}">Home</a> </li>
                    <li><a href="about.html">Nuestra Agencia</a></li>

                    <li class="menu-item-has-children"><a href="#">Tours</a>
                        <ul class="sub-menu">
                            <li><a href="">tour a Machupicchu</a></li>
                            <li><a href="">Tour a vinicunca</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children"><a href="#">Paquetes</a>
                        <ul class="sub-menu">
                            <li><a href="">Paquete 3 Días cusco</a></li>
                            <li><a href="">Paquete 4 Días Arequipa</a></li>
                            <li><a href="">Paquete 5 Días Puno</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children"><a href="#">Caminos Del Inca</a>
                        <ul class="sub-menu">
                            <li><a href="">Camino de los incas 3 días</a></li>
                            <li><a href="">Camino de los incas 4 días</a></li>
                            <li><a href="">Camino de los incas 5 días</a></li>
                        </ul>
                    </li>


                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contactos</a></li>
                </ul>
            </div>
        </div>
    </div>

    <header class="th-header header-layout1">
        <div class="header-top">
            <div class="container th-container">
                <div class="row justify-content-center justify-content-xl-between align-items-center">
                    <div class="col-auto d-none d-md-block">
                        <div class="header-links">
                            <ul>
                                <li class="d-none d-xl-inline-block"><i class="fa-sharp fa-regular fa-location-dot"></i>
                                    <span>Cusco Cusco Perú</span>
                                </li>
                                <li class="d-none d-xl-inline-block"><i class="fa-regular fa-clock"></i>
                                    <span> Lunes a Domingo 8:00 am - 6:00 pm</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-right">
                            <div class="currency-menu"><select class="form-select nice-select">
                                    <option selected="">Idioma</option>
                                    <option>EN</option>
                                    <option>ES</option>
                                    <option>FR</option>
                                </select>
                            </div>
                            <div class="header-links">
                                <ul>
                                    <li class="d-none d-md-inline-block"><a href="#">Preguntas frecuentes</a></li>
                                    <li class="d-none d-md-inline-block"><a href="#">Soporte</a></li>
                                    {{-- <li>
                                        <a href="#login-form" class="popup-content">Sign In / Register<i
                                                class="fa-regular fa-user"></i></a>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <div class="menu-area">
                <div class="container th-container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Tourm" width="80px">
                                </a>
                            </div>
                        </div>
                        <div class="col-auto me-xl-auto " style="margin-left: 120px;">
                            <nav class="main-menu d-none d-xl-inline-block">
                                <ul>

                                    <li><a href="{{ route('home') }}" class="active">Home</a></li>
                                    <li><a href="#">Nuestra Agencia</a></li>

                                    <li class="menu-item-has-children"><a href="#">Tours</a>
                                        <ul class="sub-menu">
                                            <li><a href="#">Tour a machupicchu</a></li>
                                            <li><a href="#">Tour a Vinicunca</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children"><a href="#">Paquetes</a>
                                        <ul class="sub-menu">
                                            <li><a href="#">Paquete 3 días Cusco</a></li>
                                            <li><a href="#">Paquete 4 días Cusco</a></li>
                                            <li><a href="#">Paquete 5 días Cusco</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children"><a href="#">Camino de los Incas</a>
                                        <ul class="sub-menu">
                                            <li><a href="#">Camino de los Incas 4 días</a></li>
                                            <li><a href="#">Camino de los Incas 5 días</a></li>
                                            <li><a href="#">Camino de los Incas 6 días</a></li>
                                            <li><a href="#">Camino de los Incas 7 días</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Blog</a></li>
                                    <li><a href="#">Contactos</a></li>
                                </ul>
                            </nav><button type="button" class="th-menu-toggle d-block d-xl-none">
                                <i class="far fa-bars"></i></button>
                        </div>
                        <div class="col-auto d-none d-xl-block">
                            <div class="header-button">
                                <a href="#" class="th-btn style3 th-icon"> Contactanos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('contenido')
    </main>
    
    <footer class="footer-wrapper footer-layout1">
        <div class="widget-area">
            <div class="container">
                <div class="newsletter-area">
                    <div class="newsletter-top">
                        <div class="row gy-4 align-items-center">
                            <div class="col-lg-5">
                                <h2 class="newsletter-title text-capitalize mb-0">get updated the latest newsletter
                                </h2>
                            </div>
                            <div class="col-lg-7">
                                <form class="newsletter-form"><input class="form-control" type="email"
                                        placeholder="Enter Email" required=""> <button type="submit"
                                        class="th-btn style3">Subscribe Now <img src="assets/img/icon/plane.svg"
                                            alt=""></button></form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-md-6 col-xl-3">
                        <div class="widget footer-widget">
                            <div class="th-widget-about">
                                <div class="about-logo"><a href="home-travel.html"><img src="assets/img/logo3.svg"
                                            alt="Tourm"></a></div>
                                <p class="about-text">Rapidiously myocardinate cross-platform intellectual capital
                                    model. Appropriately create interactive infrastructures</p>
                                <div class="th-social"><a href="https://www.facebook.com/"><i
                                            class="fab fa-facebook-f"></i></a> <a href="https://www.twitter.com/"><i
                                            class="fab fa-twitter"></i></a> <a href="https://www.linkedin.com/"><i
                                            class="fab fa-linkedin-in"></i></a> <a
                                        href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a> <a
                                        href="https://instagram.com/"><i class="fab fa-instagram"></i></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">Quick Links</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <li><a href="index-2.html">Home</a></li>
                                    <li><a href="about.html">About us</a></li>
                                    <li><a href="service.html">Our Service</a></li>
                                    <li><a href="contact.html">Terms of Service</a></li>
                                    <li><a href="contact.html">Tour Booking Now</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">Address</h3>
                            <div class="th-widget-contact">
                                <div class="info-box_text">
                                    <div class="icon"><img src="assets/img/icon/phone.svg" alt="img"></div>
                                    <div class="details">
                                        <p><a href="tel:+01234567890" class="info-box_link">+01 234 567 890</a></p>
                                        <p><a href="tel:+09876543210" class="info-box_link">+09 876 543 210</a></p>
                                    </div>
                                </div>
                                <div class="info-box_text">
                                    <div class="icon"><img src="assets/img/icon/envelope.svg" alt="img">
                                    </div>
                                    <div class="details">
                                        <p><a href="mailto:mailinfo00@tourm.com"
                                                class="info-box_link">mailinfo00@tourm.com</a></p>
                                        <p><a href="mailto:support24@tourm.com"
                                                class="info-box_link">support24@tourm.com</a></p>
                                    </div>
                                </div>
                                <div class="info-box_text">
                                    <div class="icon"><img src="assets/img/icon/location-dot.svg"
                                            alt="img"></div>
                                    <div class="details">
                                        <p>789 Inner Lane, Holy park, California, USA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">Instagram Post</h3>
                            <div class="sidebar-gallery">
                                <div class="gallery-thumb"><img src="assets/img/widget/gallery_1_1.jpg"
                                        alt="Gallery Image"> <a target="_blank" href="https://www.instagram.com/"
                                        class="gallery-btn"><i class="fab fa-instagram"></i></a></div>
                                <div class="gallery-thumb"><img src="assets/img/widget/gallery_1_2.jpg"
                                        alt="Gallery Image"> <a target="_blank" href="https://www.instagram.com/"
                                        class="gallery-btn"><i class="fab fa-instagram"></i></a></div>
                                <div class="gallery-thumb"><img src="assets/img/widget/gallery_1_3.jpg"
                                        alt="Gallery Image"> <a target="_blank" href="https://www.instagram.com/"
                                        class="gallery-btn"><i class="fab fa-instagram"></i></a></div>
                                <div class="gallery-thumb"><img src="assets/img/widget/gallery_1_4.jpg"
                                        alt="Gallery Image"> <a target="_blank" href="https://www.instagram.com/"
                                        class="gallery-btn"><i class="fab fa-instagram"></i></a></div>
                                <div class="gallery-thumb"><img src="assets/img/widget/gallery_1_5.jpg"
                                        alt="Gallery Image"> <a target="_blank" href="https://www.instagram.com/"
                                        class="gallery-btn"><i class="fab fa-instagram"></i></a></div>
                                <div class="gallery-thumb"><img src="assets/img/widget/gallery_1_6.jpg"
                                        alt="Gallery Image"> <a target="_blank" href="https://www.instagram.com/"
                                        class="gallery-btn"><i class="fab fa-instagram"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap" data-bg-src="assets/img/bg/copyright_bg_1.jpg">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6">
                        <p class="copyright-text">Copyright 2025 <a href="home-travel.html">Tourm</a>. All Rights
                            Reserved.</p>
                    </div>
                    <div class="col-md-6 text-end d-none d-md-block">
                        <div class="footer-card"><span class="title">We Accept</span> <img
                                src="assets/img/shape/cards.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="scroll-top"><svg class="progress-circle svg-content" width="100%" height="100%"
            viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg></div>
    <div id="login-form" class="popup-login-register mfp-hide">
        <ul class="nav" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-menu" id="pills-home-tab"
                    data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab"
                    aria-controls="pills-home" aria-selected="false">Login</button></li>
            <li class="nav-item" role="presentation"><button class="nav-menu active" id="pills-profile-tab"
                    data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab"
                    aria-controls="pills-profile" aria-selected="true">Register</button></li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h3 class="box-title mb-30">Sign in to your account</h3>
                <div class="th-login-form">
                    <form action="https://html.themeholy.com/tourm/demo/mail.php" method="POST"
                        class="login-form ajax-contact">
                        <div class="row">
                            <div class="form-group col-12"><label>Username or email</label> <input type="text"
                                    class="form-control" name="email" id="email" required="required">
                            </div>
                            <div class="form-group col-12"><label>Password</label> <input type="password"
                                    class="form-control" name="pasword" id="pasword" required="required">
                            </div>
                            <div class="form-btn mb-20 col-12"><button class="th-btn btn-fw th-radius2">Send
                                    Message</button></div>
                        </div>
                        <div id="forgot_url"><a href="my-account.html">Forgot password?</a></div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade active show" id="pills-profile" role="tabpanel"
                aria-labelledby="pills-profile-tab">
                <h3 class="th-form-title mb-30">Sign in to your account</h3>
                <form action="https://html.themeholy.com/tourm/demo/mail.php" method="POST"
                    class="login-form ajax-contact">
                    <div class="row">
                        <div class="form-group col-12"><label>Username*</label> <input type="text"
                                class="form-control" name="usename" id="usename" required="required"></div>
                        <div class="form-group col-12"><label>First name*</label> <input type="text"
                                class="form-control" name="firstname" id="firstname" required="required"></div>
                        <div class="form-group col-12"><label>Last name*</label> <input type="text"
                                class="form-control" name="lastname" id="lastname" required="required"></div>
                        <div class="form-group col-12"><label for="new_email">Your email*</label> <input
                                type="text" class="form-control" name="new_email" id="new_email"
                                required="required"></div>
                        <div class="form-group col-12"><label for="new_email_confirm">Confirm email*</label> <input
                                type="text" class="form-control" name="new_email_confirm"
                                id="new_email_confirm" required="required"></div>
                        <div class="statement"><span class="register-notes">A password will be emailed to
                                you.</span></div>
                        <div class="form-btn mt-20 col-12"><button class="th-btn btn-fw th-radius2">Sign up</button>
                        </div>
                    </div>
                    <p class="form-messages mb-0 mt-3"></p>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/gsap.min.js"></script>
    <script src="assets/js/circle-progress.js"></script>
    <script src="assets/js/matter.min.js"></script>
    <script src="assets/js/matterjs-custom.js"></script>
    <script src="assets/js/nice-select.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
<!-- Mirrored from html.themeholy.com/tourm/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 13 Feb 2025 02:28:24 GMT -->

</html>
