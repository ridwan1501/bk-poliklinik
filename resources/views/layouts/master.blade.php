<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title> {{ config("app.name") }} - Appointment</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Appointment" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @include('layouts.head-css')
    </head>

    <body>
        @include('layouts.sidebar')

        <div class="page-wrapper">
            @include('layouts.topbar')

            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                @include('layouts.footer')
            </div>

        </div>
        @include('layouts.vendor-scripts')
    </body>
</html>
