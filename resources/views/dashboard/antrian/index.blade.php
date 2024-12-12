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
            Antrian
        @endslot
        @slot('title')
            Antrian
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Antrian Menunggu Dipanggil</h4>
                    <a href="{{ route('backoffice.antrian.display') }}">Display Antrian</a>
                </div>
                <!--end card-header-->
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Jadwal</th>
                                <th>Dokter</th>
                                <th>Pasien</th>
                                <th>No Antrian</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by DataTables -->
                        </tbody>
                    </table>
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
        var type_id = "";

        var datatable = function() {
            var table = $('#datatable').DataTable({
                responsive: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                order: [],
                ajax: {
                    url: '{{ route('backoffice.antrian.data-menunggu') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'id', name: 'jadwal' },
                    { data: 'jadwal_periksa.dokter.nama', name: 'dokter' },
                    { data: 'pasien.nama', name: 'pasien' },
                    { data: 'no_antrian', name: 'no_antrian' },
                    { data: 'id', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        render: function(data, type, row) {
                            return `${row.jadwal_periksa.hari}<br />${row.jadwal_periksa.jam_mulai}-${row.jadwal_periksa.jam_selesai}`;
                        }
                    },
                    {
                        targets: -1,
                        render: function(data, type, row) {
                            let json_row = JSON.stringify(row);
                            return `<button class="btn btn-sm btn-soft-primary btn-destroy" data-id="${data}"><i class="fas fa-bell"></i></button>`;
                        }
                    }
                ],
            });

            return {
                init: function() {
                    table;
                },
                reload: function() {
                    table.ajax.reload();
                }
            };

        }();

        jQuery(document).ready(function() {
            datatable.init();

            $(".select2").select2({
                width: '100%',
                dropdownParent: $("#modalForm")
            });

            $('.btn-create').on('click', function() {
                $('#id').val('');
                $('#modalForm form')[0].reset();
                $('.modal-title').text('Tambah Data');
                $('#modalForm').modal('show');
            });

            $('#modalForm form').on('submit', function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let url = id ? `${HOST_URL}/poli/${id}` : `${HOST_URL}/poli`;
                let method = id ? 'PUT' : 'POST';
                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#modalForm').modal('hide');
                        datatable.reload();
                        Swal.fire('Success', response.message, 'success');
                    },
                    error: function(response) {
                        Swal.fire('Error', 'Something went wrong', 'error');
                    }
                });
            });

            $('#datatable').on('click', '.btn-edit', function() {
                let row = $(this).data('row');
                $('#modalForm form')[0].reset();
                $('.modal-title').text('Edit Data: ' + row.nama_poli);
                $('#modalForm').modal('show');
                $('#id').val(row.id);
                $('#nama_poli').val(row.nama_poli);
                $('#keterangan').val(row.keterangan);
            });

            $('#datatable').on('click', '.btn-destroy', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Panggil Antrian?',
                    text: "pasien akan dipanggil melalui display!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Panggil!'
                }).then((result) => {
                    console.log(result)
                    if (result.value) {
                        $.ajax({
                            url: `${HOST_URL}/antrian/panggil/${id}`,
                            method: 'PUT',
                            success: function(response) {
                                datatable.reload();
                                Swal.fire('Dipanggil!', response.message, 'success');
                            },
                            error: function(response) {
                                Swal.fire('Error', 'Something went wrong', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
