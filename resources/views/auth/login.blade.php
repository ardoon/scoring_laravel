@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row vh-100">

        <div class="col-12 col-lg-5 bg-light my-auto">
            <form method="POST" action="{{ route('login') }}" class="col-12 col-md-9 mt-5 mx-auto">
                @csrf

                <h3 class="text-center mb-5">ورود اعضای تعاونی</h3>

                <div class="form-group">
                    <label for="mobile"><i class="fa fa-user"></i> شماره موبایل</label>
                    <input id="mobile"
                        type="text"
                        class="form-control @error('mobile') is-invalid @enderror"
                        name="username" value="{{ old('mobile') }}"
                        required
                        autocomplete="mobile"
                        autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

                <button type="submit" class="btn btn-dark text-light float-left px-5">دریافت کد</button>
                <a type="submit"
                    class="btn btn-outline-dark float-left px-5 ml-2"
                    href="{{ route('login.admin') }}">ورود مدیر</a>
            </form>
        </div>

        <div id="login-side-bg" class="col-7 d-none d-lg-block bg-dark">

        </div>

    </div>
</div>
@endsection
