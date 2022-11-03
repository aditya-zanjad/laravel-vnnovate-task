<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Begin: Google Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- End: Google Fonts -->

    <!-- Begin: Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- End: Font Awesome Icons -->

    <!-- Begin: Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- End: Ionicons -->

    <!-- Begin: CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- End: CSS -->

    @stack('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Begin: Wrapper -->
    <div class="wrapper">
        <!-- Begin: Loader Animation -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('assets/admin-lte/img/AdminLTELogo.png') }}"
                alt="AdminLTELogo" height="60" width="60">
        </div>
        <!-- End: Loader Animation -->

        <!-- Begin: Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <!-- Begin: Right-Side Navbar Menu Items -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-sm btn-warning mt-1 mr-2 text-dark"
                        href="{{ route('users.edit', auth()->id()) }}" role="button">
                        <i class="fas fa-edit"></i>
                        Edit Profile
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-sm btn-danger mt-1 mr-2">
                            <i class="fas fa-sign-out-alt"></i>
                            Sign Out
                        </button>
                    </form>
                </li>
            </ul>
            <!-- End: Right-Side Navbar Menu Items -->
        </nav>
        <!-- End: Navbar -->

        <!-- Begin: Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Begin: Brand Logo -->
            <a href="{{ route('users.index') }}" class="brand-link">
                <img src="{{ asset('assets/admin-lte/img/AdminLTELogo.png') }}"
                    alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>
            <!-- End: Brand Logo -->

            <!-- Begin: Sidebar Contents -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets/admin-lte/img/user2-160x160.jpg') }}"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            {{ auth()->user()->name }}
                        </a>
                    </div>
                </div>

                <!-- Begin: Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column"
                        data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}"
                                        class="nav-link {{ Route::is('users.index') ? 'active' : '' }}">
                                        <i class="fas fa-users mr-2"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('shops.index') }}"
                                        class="nav-link
                                        {{ Route::is('shops.index') || Route::is('shops.products.index') ? 'active' : '' }}">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        <p>Shops</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('products.index') }}"
                                        class="nav-link {{ Route::is('products.index') ? 'active' : '' }}">
                                        <i class="fas fa-box mr-2"></i>
                                        <p>Products</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- End: Siderbar Menu -->
            </div>
            <!-- End: Sidebar Contents -->
        </aside>
        <!-- End: Main Sidebar Container -->

        <!-- Begin: Content Wrapper -->
        <div class="content-wrapper bg-light">
            <!-- Begin: Main Content -->
            <section class="content">
                <div class="container-fluid">
                    @include('alerts.index')
                    @yield('content')
                </div>
            </section>
            <!-- End: Main Content -->
        </div>
        <!-- End: Content Wrapper -->

        <footer class="main-footer">
            <strong>Copyright &copy; 2022</strong>
            All rights reserved.
        </footer>
    </div>
    <!-- End: Wrapper -->

    <!-- Begin: JS -->
    <script src="{{ asset('assets/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <script src="{{ asset('assets/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/js/adminlte.js') }}"></script>
    <!-- End: JS -->

    <!-- Begin: Custom JS -->
    @stack('scripts')
    <!-- End: Custom JS -->
</body>
</html>
