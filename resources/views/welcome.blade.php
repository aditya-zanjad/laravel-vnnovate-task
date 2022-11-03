<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Vnnovate Task</title>

        <!-- Begin: Favicon -->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- End: Favicon -->

        <!-- Begin: Font Awesome - Icons -->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- End: Font Awesome - Icons -->

        <!-- Begin: Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- End: Google Fonts -->

        <!-- Begin: Custom CSS -->
        <link href="{{ asset('assets/landing-page/css/styles.css') }}" rel="stylesheet" />
        <!-- End: Custom CSS -->

        <!-- Begin: Custom CSS -->
        <style>
        </style>
        <!-- End: Custom CSS -->
    </head>

    <body id="page-top">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
            </div>
        </nav>

        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading text-dark h1 display-4">
                    Welcome To Vnnovate Task
                </div>
                <a href="{{ route('login') }}" class="btn btn-lg btn-primary text-dark me-3">
                    Log In
                </a>
                <a href="{{ route('register') }}" class="btn btn-lg btn-success">
                    Register
                </a>
            </div>
        </header>

        <!-- Begin: Bootstrap CDN JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- End: Bootstrap CDN JS -->

        <!-- Begin: Custom JS -->
        <script src="{{ asset('assets/landing-page/js/scripts.js') }}"></script>
        <!-- End: Custom JS -->
    </body>
</html>
