@extends('layouts.default')

@section('title', 'Users | Edit')

@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary" style="margin-top: 3%; margin-bottom: 12%;">
            <div class="card-header">
                <h3 class="card-title">
                    Edit Profile
                </h3>
            </div>

            <!-- Begin: Form -->
            <form method="POST" action="{{ route('users.update') }}">
                {{-- Hidden inputs for CSRF token, POST method & User ID --}}
                @csrf
                @method('PATCH')
                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                {{-- Hidden inputs for CSRF token, POST method & User ID --}}

                <div class="card-body">
                    <!-- Begin: Name -->
                    <div class="form-group">
                        <label for="name">
                            {{ __('Name') }}
                        </label>
                        <input type="text" name="name" id="name" class="form-control"
                            id="email" placeholder="Enter Your Name..."
                            value="{{ old('name') ?? $user->name }}" required>
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
                            id="email" placeholder="Enter Your Email Address..."
                            value="{{ old('email') ?? $user->email }}" required>
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
                        <select name="gender" id="gender" class="form-control select2"
                            style="width: 100%;" required>
                            <option disabled>-- Select Gender --</option>
                            <option value="m"
                                {{ old('gender') === 'm' || $user->gender === 'm' ? 'selected' : '' }}>
                                Male
                            </option>
                            <option value="f"
                                {{ old('gender') === 'f' || $user->gender === 'f' ? 'selected' : '' }}>
                                Female
                            </option>
                            <option value="o"
                                {{ old('gender') === 'o' || $user->gender === 'o' ? 'selected' : '' }}>
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
                        <select id="city" name="city_id" class="form-control select2"
                            style="width: 100%;" required>
                            <option selected disabled></option>
                            @foreach ($cities as $city)
                                @php
                                    // If the old value of 'city_id' matches with the '$city->id',
                                    // OR If the '$city->id' matches with the '$user->city->id',
                                    // then the current city is selected
                                    $selected = ((int) old('city_id') === (int) $city->id) || (
                                        (int) old('city_id') !== (int) $city->id &&
                                        (int) $city->id === $user->city->id
                                    );
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
                        <label for="old_password">{{ __('Old Password') }}</label>
                        <input type="password" class="form-control" name="old_password" id="old_password">
                        @error('old_password')
                            <span class="text-danger fw-bolder">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <!-- End: Password -->

                    <!-- Begin: New Password -->
                    <div class="form-group">
                        <label for="new_password">{{ __('Password') }}</label>
                        <input type="password" class="form-control" name="new_password" id="new_password">
                        @error('new_password')
                            <span class="text-danger fw-bolder">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <!-- End: New Password -->

                    <!-- Begin: Confirm Password -->
                    <div class="form-group">
                        <label for="new_password_confirmation">{{ __('Confirm Password') }}</label>
                        <input type="password" class="form-control"
                            name="new_password_confirmation" id="new_password_confirmation">
                        @error('new_password_confirmation')
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
        </div>
    </div>
</div>
@endsection
