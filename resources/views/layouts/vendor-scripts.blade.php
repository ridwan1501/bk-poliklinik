    <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/metismenu.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/waves.js') }}"></script>
    <script src="{{ URL::asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/moment.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script>
        var HOST_URL = "{{ url('/') }}/backoffice";
        var UPLOAD_URL = "{{ url('/') }}/storage/admin";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('script')
