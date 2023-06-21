@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row vh-100">

        <div class="col-12 col-lg-5 bg-light my-auto">
            <form method="POST" action="{{ route('login') }}" class="col-12 col-md-9 mt-5 mx-auto">
                @csrf

                <h3 class="text-center mb-5">ورود به حساب کاربری</h3>

                <div class="form-group">
                    <label for="username"><i class="fa fa-user"></i> نام کاربری</label>
                    <input id="username"
                        type="text"
                        class="form-control @error('username') is-invalid @enderror"
                        name="username" value="{{ old('username') }}"
                        required
                        autocomplete="username"
                        autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="password"><i class="fa fa-lock"></i> گذرواژه</label>
                    <input id="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        required
                        autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

                <div class="form-group form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label mr-4" for="remember">مرا به خاطر بسپار</label>
                    @if (Route::has('password.request'))

                    @endif
                </div>


                <button type="submit" class="btn btn-dark text-light float-left px-5">ورود</button>
                <a type="submit"
                    class="btn btn-outline-dark float-left px-5 ml-2"
                    href="{{ route('login') }}">ورود اعضا</a>
            </form>
        </div>

        <div id="login-side-bg" class="col-7 d-none d-lg-block bg-dark">

        </div>

    </div>
</div>
@endsection
