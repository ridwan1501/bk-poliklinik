@extends('layouts.master-without_nav')

@section('title') Daftar @endsection

@section('content')

<body class="account-body accountbg">


<div class="container">
    <div class="row vh-100 d-flex justify-content-center">
        <div class="col-12 align-self-center">
            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <div class="card">
                        <div class="card-body p-0 auth-header-box">
                            <div class="text-center p-3">
                                <a href="index" class="logo logo-admin">
                                    <img src="{{ URL::asset('logo.png') }}" height="100" alt="logo" class="auth-logo">
                                </a>
                                {{-- <h4 class="mt-3 mb-1 fw-semibold text-white font-18">Lets Get Started {{ config("app.name") }}</h4> --}}
                                {{-- <p class="text-muted  mb-0">Sign in to continue to {{ config("app.name") }}.</p> --}}
                                <h4 class="mt-3 mb-1 fw-semibold text-white font-18">Pendaftaran Akun</h4>
                                <p class="text-muted  mb-0">AmbaKlinik</p>
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
                                    <form class="form-horizontal auth-form" method="POST" action="{{ route('register.post') }}">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="nama">Nama</label>
                                            <div class="input-group">
                                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" id="" placeholder="Enter Nama" autocomplete="nama" autofocus>
                                                @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="alamat">Alamat</label>
                                            <div class="input-group">
                                                <input name="alamat" type="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}" id="" placeholder="Enter Alamat" autocomplete="alamat" autofocus>
                                                @error('alamat')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="no_ktp">No KTP</label>
                                            <div class="input-group">
                                                <input name="no_ktp" type="no_ktp" class="form-control @error('no_ktp') is-invalid @enderror" value="{{ old('no_ktp') }}" id="" placeholder="Enter No KTP" autocomplete="no_ktp" autofocus>
                                                @error('no_ktp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="no_hp">No HP</label>
                                            <div class="input-group">
                                                <input name="no_hp" type="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" id="" placeholder="Enter No HP" autocomplete="no_hp" autofocus>
                                                @error('no_hp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row my-3">
                                            <div class="col-sm-12 text-end">
                                                @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                                                @endif

                                                <a href="{{ route('login') }}">Sudah punya akun?</a>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end form-group-->

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Daftar Sekarang <i class="fas fa-sign-in-alt ms-1"></i></button>
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
