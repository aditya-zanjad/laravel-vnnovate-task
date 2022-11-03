<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Begin: Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- End: Select2 CSS -->

    <!-- Begin: Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin-lte/css/adminlte.min.css') }}">
    <!-- End: Custom CSS -->
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" style="margin-top: 3%; margin-bottom: 5%">
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
                                    Register
                                </h3>
                            </div>

                            <!-- Begin: Form -->
                            <form method="POST" action="{{ route('register') }}">
                                {{-- Hidden inputs for CSRF token & POST method --}}
                                @csrf
                                @method('POST')
                                {{-- Hidden inputs for CSRF token & POST method --}}

                                <div class="card-body">
                                    <!-- Begin: Name -->
                                    <div class="form-group">
                                        <label for="name">
                                            {{ __('Name') }}
                                        </label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            id="email" placeholder="Enter Your Name..." value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="text-danger fw-bolder">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- End: Name -->

                                    <!-- Begin: Email -->
                                    <div class="form-group">
                                        <label for="email">
                                            {{ __('Email') }}
                                        </label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            id="email" placeholder="Enter Your Email Address..." value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="text-danger fw-bolder">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- End: Email -->

                                    <!-- Begin: Gender -->
                                    <div class="form-group">
                                        <label for="gender">
                                            {{ __('Gender') }}
                                        </label>
                                        <select class="form-control select2"
                                            id="gender" name="gender" style="width: 100%;">
                                            <option disabled>-- Select Gender --</option>
                                            <option value="m" {{ old('gender') === 'm' ? 'selected' : '' }}>
                                                Male
                                            </option>
                                            <option value="f" {{ old('gender') === 'f' ? 'selected' : '' }}>
                                                Female
                                            </option>
                                            <option value="o" {{ old('gender') === 'o' ? 'selected' : '' }}>
                                                Other
                                            </option>
                                          </select>
                                        @error('gender')
                                            <span class="text-danger fw-bolder">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- End: Gender -->

                                     <!-- Begin: City -->
                                     <div class="form-group">
                                        <label for="city">
                                            {{ __('City') }}
                                        </label>
                                        <select id="city" name="city_id"
                                            class="form-control select2" style="width: 100%;" required>
                                            <option disabled></option>
                                            @foreach ($cities as $city)
                                                @php
                                                    // If the old value of 'city_id' matches with the '$city->id',
                                                    // then select the current city
                                                    $selected = (int) old('city_id') === (int) $city->id;
                                                @endphp
                                                <option {{ $selected ? 'selected' : '' }}
                                                    value="{{ $city->id }}">
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                          </select>
                                        @error('city_id')
                                            <span class="text-danger fw-bolder">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- End: City -->

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

                                    <!-- Begin: Confirm Password -->
                                    <div class="form-group">
                                        <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                        <input type="password" class="form-control"
                                            name="password_confirmation" id="password_confirmation">
                                        @error('password_confirmation')
                                            <span class="text-danger fw-bolder">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- End: Confirm Password -->
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </form>
                            <!-- End: Form -->

                            <!-- Begin: User Login Link -->
                            <div class="row d-flex justify-content-end mr-2 mb-2">
                                <small>
                                    <a href="{{ route('login') }}">
                                        Already Registred? Click Here To Log In
                                    </a>
                                </small>
                            </div>
                            <!-- End: User Login Link -->
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

    <!-- Begin: Select2 - JS-->
    <script src="{{ asset('assets/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2()
        });
    </script>
    <!-- End: Select2 - JS-->
</body>
</html>
