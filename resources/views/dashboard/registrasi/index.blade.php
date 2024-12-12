@extends('layouts.master')
@section('title')
    Poli
@endsection

@section('css')
    <link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ config('app.name') }}
        @endslot
        @slot('li_2')
            Registrasi Jadwal
        @endslot
        @slot('title')
            Registrasi Jadwal
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Registrasi Jadwal</h4>
                </div>
                <!--end card-header-->
                <div class="card-body table-responsive">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('backoffice.registrasi.store') }}">
                        @csrf
                        <div class="mb-3 row">
                            <label class="form-label col-sm-2">Hari</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hari" id="senin" value="Senin" required>
                                    <label class="form-check-label" for="senin">Senin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hari" id="selasa" value="Selasa" required>
                                    <label class="form-check-label" for="selasa">Selasa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hari" id="rabu" value="Rabu" required>
                                    <label class="form-check-label" for="rabu">Rabu</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hari" id="kamis" value="Kamis" required>
                                    <label class="form-check-label" for="kamis">Kamis</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hari" id="jumat" value="Jumat" required>
                                    <label class="form-check-label" for="jumat">Jumat</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hari" id="sabtu" value="Sabtu" required>
                                    <label class="form-check-label" for="sabtu">Sabtu</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hari" id="minggu" value="Minggu" required>
                                    <label class="form-check-label" for="minggu">Minggu</label>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mb-3 row">
                            <label for="id_dokter" class="form-label col-sm-2">Dokter</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="id_dokter" name="id_dokter" required>
                                </select>
                            </div>
                        </div> --}}
                        <div class="mb-3 row">
                            <label for="id_poli" class="form-label col-sm-2">Poli</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="id_poli" name="id_poli" required>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="id_dokter" class="form-label col-sm-2">Jadwal Tersedia</label>
                            <div class="col-sm-10" id="container_id_jadwal">
                                <p>- Silahkan Pilih Hari</p>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="keluhan" class="form-label col-sm-2">Keluhan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="keluhan" name="keluhan" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end modal-->
@endsection

@section('script')
    <script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>

    <script>
        "use strict";

        const getDokter = () => {
            $.ajax({
                url: `${HOST_URL}/registrasi/data_dokter`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    let options = response.data.map(dokter => `<option value="${dokter.id}">${dokter.nama} - ${dokter.poli.nama_poli}</option>`);
                    $('#id_dokter').html(options);
                }
            });
        }

        const getPoli = () => {
            $.ajax({
                url: `${HOST_URL}/registrasi/data_poli`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    let options = response.data.map(poli => `<option value="${poli.id}">${poli.nama_poli}</option>`);
                    $('#id_poli').html([
                        '<option value="">Pilih Poli</option>',
                        ...options
                    ]);
                }
            });
        }

        const getJadwal = () => {
            const id_dokter = $('#id_dokter').val();
            const hari = $('input[name="hari"]:checked').val();
            console.log('id_dokter', id_dokter);
            console.log('hari', hari);
            $.ajax({
                url: `${HOST_URL}/registrasi/data_jadwal_periksa`,
                data: {
                    id_dokter: id_dokter,
                    hari: hari
                },
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#container_id_jadwal').empty();
                    let options = response.data.map(jadwal => `
                        <input type="radio" class="btn-check" name="id_jadwal" id="${jadwal.id}" value="${jadwal.id}">
                        <label class="btn btn-outline-warning btn-sm" for="${jadwal.id}">
                            ${jadwal.dokter.nama}
                            <br>
                            ${jadwal.hari}
                            <br>
                            ${jadwal.jam_mulai} - ${jadwal.jam_selesai}
                        </label>
                    `);

                    if (options.length === 0) {
                        options = '<p>- Tidak ada jadwal tersedia</p>';
                    }
                    $('#container_id_jadwal').html(options);
                }
            });
        }

        jQuery(document).ready(function() {
            $(".select2").select2({
                width: '100%',
                // dropdownParent: $("#modalForm")
            });

            getDokter();

            getPoli();

            $(document.body).on("change","#id_dokter",function(){
                getJadwal();
            });

            $(document.body).on("change","#id_poli",function(){
                getJadwal();
            });

            $(document.body).on("change","input[name='hari']",function(){
                getJadwal();
            });
        });
    </script>
@endsection
