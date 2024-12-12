@extends('layouts.master-without_nav')

@section('title') Logins @endsection

@section('content')

<body class="account-body accountbg">


<div class="container">
    <div class="row vh-100 d-flex justify-content-center">
        <div class="col-12 align-self-center">
            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-body p-0 auth-header-box" style="border-radius: 10px;">
                            <div class="text-center p-3">
                                <a href="index" class="logo logo-admin">
                                    <img src="{{ URL::asset('logo.png') }}" height="90" alt="logo" class="auth-logo">
                                </a>
                                {{-- <h4 class="mt-3 mb-1 fw-semibold text-white font-18">Lets Get Started {{ config("app.name") }}</h4> --}}
                                {{-- <p class="text-muted  mb-0">Sign in to continue to {{ config("app.name") }}.</p> --}}
                                <h4 class="mt-3 mb-1 fw-semibold text-white font-18">Masuk Akun</h4>
                                <p class="text-muted  mb-0"></p>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="nav-border nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    {{-- <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#LogIn_Tab" role="tab">Log In</a> --}}
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active  p-3" id="LogIn_Tab" role="tabpanel">

                                    @if(Session::has('success'))
                                        <div class="alert alert-success text-center">
                                            {{Session::get('success')}}
                                        </div>
                                    @endif
                                    <form class="form-horizontal auth-form" method="POST" action="{{ route('login.post') }}">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="email">Nama Pengguna</label>
                                            <div class="input-group">
                                                <input name="email" type="text" class="form-control @error('email') is-invalid @enderror" id="username" placeholder="Enter Nama Pengguna" autocomplete="email" autofocus>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="userpassword">Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" id="userpassword" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row my-3">
                                            <div class="col-sm-6">
                                                <div class="custom-control custom-switch switch-success">
                                                    <input class="form-check-input" type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember"> Remember me </label>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-sm-6 text-end">
                                                @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                                                @endif

                                                <a href="{{ route('register') }}">Belum punya akun?</a>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end form-group-->

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In <i class="fas fa-sign-in-alt ms-1"></i></button>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end form-group-->
                                    </form>
                                    <!--end form-->
                                </div>
                            </div>
                        </div>

                        <div class="card-body bg-light-alt text-center">
                            <span class="text-muted d-none d-sm-inline-block">{{ config("app.name") }} © <script>
                                    document.write(new Date().getFullYear())

                                </script></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
