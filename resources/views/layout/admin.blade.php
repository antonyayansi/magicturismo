<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('titulo')</title>

    <link rel="shortcut icon" href="{{ asset('assets-admin/images/logo/favicon.png') }}">

    @yield('css')
    <link href="{{ asset('assets-admin/css/app.min.css') }}" rel="stylesheet">

</head>

<body>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <div class="header">
                <div class="logo logo-dark">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo" width="100px">
                        <img class="logo-fold" src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo"
                            width="80px">
                    </a>
                </div>

                <div class="nav-wrap">
                    <ul class="nav-left">
                        <li class="desktop-toggle">
                            <a href="javascript:void(0);">
                                <i class="anticon"></i>
                            </a>
                        </li>
                        <li class="mobile-toggle">
                            <a href="javascript:void(0);">
                                <i class="anticon"></i>
                            </a>
                        </li>

                    </ul>
                    <ul class="nav-right">
                        <li class="dropdown dropdown-animated scale-left">
                            <a href="javascript:void(0);" data-toggle="dropdown">
                                <i class="anticon anticon-bell notification-badge"></i>
                            </a>

                        </li>
                        <li class="dropdown dropdown-animated scale-left">
                            <div class="pointer" data-toggle="dropdown">
                                <div class="avatar avatar-image  m-h-10 m-r-15">
                                    <img src="{{ asset('assets-admin/images/avatars/thumb-3.jpg') }}" alt="">
                                </div>
                            </div>
                            <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                                <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                                    <div class="d-flex m-r-50">
                                        <div class="avatar avatar-lg avatar-image">
                                            <img src="{{ asset('assets-admin/images/avatars/thumb-3.jpg') }}"
                                                alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <p class="m-b-0 text-dark font-weight-semibold">{{ Auth::user()->nombres }}
                                            </p>
                                            <p class="m-b-0 opacity-07">{{ Auth::user()->nivel }} </p>
                                        </div>
                                    </div>
                                </div>


                                <a href="javascript:void(0);" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                            <span class="m-l-10">Salir</span>
                                        </div>
                                        <i class="anticon font-size-10 anticon-right"></i>
                                    </div>
                                </a>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            <!-- Header END -->

            <!-- Side Nav START -->
            <div class="side-nav">
                <div class="side-nav-inner">
                    <ul class="side-nav-menu scrollable">
                        <li class="nav-item dropdown open">
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-toggle">
                                <span class="icon-holder">
                                    <i class="anticon anticon-dashboard"></i>
                                </span>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown open">
                            <a href="{{ route('admin.carrusel') }}" class="dropdown-toggle">
                                <span class="icon-holder">
                                    <i class="anticon anticon-dashboard"></i>
                                </span>
                                <span class="title">Carrusel</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown open">
                            <a href="{{ route('admin.paquetes') }}" class="dropdown-toggle">
                                <span class="icon-holder">
                                    <i class="anticon anticon-dashboard"></i>
                                </span>
                                <span class="title">Paquetes</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown open">
                            <a href="{{ route('admin.reservas') }}" class="dropdown-toggle">
                                <span class="icon-holder">
                                    <i class="anticon anticon-dashboard"></i>
                                </span>
                                <span class="title">Reservas</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Side Nav END -->
            <!-- Page Container START -->
            <div class="page-container">

                @yield('contenido')

            </div>
            <!-- Content Wrapper END -->

            <!-- Footer START -->
            <footer class="footer">
                <div class="footer-content">
                    <p class="m-b-0">Copyright © 2025 All rights reserved.</p>
                    
                </div>
            </footer>
            <!-- Footer END -->

        </div>
        <!-- Page Container END -->

    </div>
    </div>


    <!-- Core Vendors JS -->
    @yield('js')
    
</body>

</html>
