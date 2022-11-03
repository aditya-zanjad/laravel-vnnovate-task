<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Begin: Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/css/adminlte.min.css') }}">
    <!-- End: Custom CSS -->
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" style="margin: 10%">
        <section class="content">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <a href="{{ route('welcome') }}" class="btn btn-success">
                                <i class="fas fa-arrow-left mr-2 mt-1"></i>Go Back
                            </a>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Log In
                                </h3>
                            </div>

                            <!-- Begin: Form -->
                            <form method="POST" action="{{ route('login') }}">
                                {{-- Hidden inputs for CSRF token & POST method --}}
                                @csrf
                                @method('POST')
                                {{-- Hidden inputs for CSRF token & POST method --}}

                                <div class="card-body">
                                    <!-- Begin: Email -->
                                    <div class="form-group">
                                        <label for="email">
                                            {{ __('Email') }}
                                        </label>
                                        <input type="email" name="email" id="email"
                                            class="form-control" id="email"
                                            placeholder="Enter Your Email Address..." value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger fw-bolder">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- End: Email -->

                                    <!-- Begin: Password -->
                                    <div class="form-group">
                                        <label for="password">{{ __('Password') }}</label>
                                        <input type="password" class="form-control" name="password" id="password">
                                        @error('password')
                                            <span class="text-danger fw-bolder">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- End: Password -->

                                    <!-- Begin: Remember Me -->
                                    <div class="form-check">
                                        <input type="checkbox" id="remember_me"
                                            name="remember" class="form-check-input">
                                        <label class="form-check-label" for="remember_me">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                    <!-- End: Remember Me -->
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </form>
                            <!-- End: Form -->

                            <!-- Begin: User Registration Link -->
                            <div class="row d-flex justify-content-end mr-2 mb-2">
                                <small>
                                    <a href="{{ route('register') }}">
                                        Not Registred? Click Here To Register
                                    </a>
                                </small>
                            </div>
                            <!-- End: User Registration Link -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Begin: JS -->
    <script src="{{ asset('assets/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('assets/admin-lte/js/adminlte.min.js') }}"></script>
    <!-- End: JS -->
</body>
</html>
