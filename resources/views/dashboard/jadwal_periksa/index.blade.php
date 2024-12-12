@extends('layouts.master')
@section('title')
    Jadwal Periksa
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
            Jadwal Periksa
        @endslot
        @slot('title')
            Jadwal Periksa
        @endslot
        @slot('btn_create')
            javascript:void(0);
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Jadwal Periksa</h4>
                </div>
                <!--end card-header-->
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Dokter</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Status</th>
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

    <div class="modal fade" id="modalForm" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body">
                    <form id="formJadwalPeriksa">
                        <input type="hidden" id="id" name="id">
                        @if (auth()->user()->role !== 'dokter')
                            <div class="mb-3">
                                <label for="id_dokter" class="form-label">Dokter</label>
                                <select class="form-control select2" id="id_dokter" name="id_dokter" required>
                                </select>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Hari</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hari" id="senin" value="Senin" required>
                                <label class="form-check-label" for="senin">Senin</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hari" id="selasa" value="Selasa" required>
                                <label class="form-check-label" for="selasa">Selasa</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hari" id="rabu" value="Rabu" required>
                                <label class="form-check-label" for="rabu">Rabu</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hari" id="kamis" value="Kamis" required>
                                <label class="form-check-label" for="kamis">Kamis</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hari" id="jumat" value="Jumat" required>
                                <label class="form-check-label" for="jumat">Jumat</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hari" id="sabtu" value="Sabtu" required>
                                <label class="form-check-label" for="sabtu">Sabtu</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hari" id="minggu" value="Minggu" required>
                                <label class="form-check-label" for="minggu">Minggu</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control select2" id="status" name="status" required>
                                <option value="0">Tidak Aktif</option>
                                <option value="1">Aktif</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
                <!--end modal-body-->
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
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
                    url: '{{ route('backoffice.jadwal_periksa.data') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'dokter.nama', name: 'dokter.nama' },
                    { data: 'hari', name: 'hari' },
                    { data: 'jam_mulai', name: 'jam_mulai' },
                    { data: 'jam_selesai', name: 'jam_selesai' },
                    { data: 'status', name: 'status' },
                    { data: 'id', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    {
                        targets: 4,
                        render: function(data, type, row) {
                            if (data) {
                                return `<span class="badge badge-soft-success">Aktif</span>`;
                            }
                            return `<span class="badge badge-soft-danger">Tidak Aktif</span>`;
                        }
                    },
                    {
                        targets: -1,
                        render: function(data, type, row) {
                            let json_row = JSON.stringify(row);
                            return `<button class="btn btn-sm btn-soft-primary btn-edit" data-row='${json_row}''><i class="fas fa-edit"></i></button>`;
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

                $('#status').val('0').trigger('change');

                // UN DISABLED
                $(`input[name="hari"]`).prop('disabled', false);
                $('#jam_mulai').prop('disabled', false);
                $('#jam_selesai').prop('disabled', false);
            });

            $('#modalForm form').on('submit', function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let url = id ? `${HOST_URL}/jadwal_periksa/${id}` : `${HOST_URL}/jadwal_periksa`;
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
                        console.log(response)
                        Swal.fire('Error', response?.responseJSON?.message || 'Something went wrong', 'error');
                    }
                });
            });

            $('#datatable').on('click', '.btn-edit', function() {
                let row = $(this).data('row');
                $('#modalForm form')[0].reset();
                $('.modal-title').text('Edit Data: ' + row.hari);
                $('#modalForm').modal('show');
                $('#id').val(row.id);
                $('#id_dokter').val(row.id_dokter).trigger('change');
                $(`input[name="hari"][value="${row.hari}"]`).prop('checked', true);;
                $('#jam_mulai').val(row.jam_mulai.slice(0, -3));
                $('#jam_selesai').val(row.jam_selesai.slice(0, -3));
                $('#status').val(row.status).trigger('change');

                // DISABLED
                $(`input[name="hari"]`).prop('disabled', true);
                $('#jam_mulai').prop('disabled', true);
                $('#jam_selesai').prop('disabled', true);
            });

            $('#datatable').on('click', '.btn-destroy', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: `${HOST_URL}/jadwal_periksa/${id}`,
                            method: 'DELETE',
                            success: function(response) {
                                datatable.reload();
                                Swal.fire('Deleted!', response.message, 'success');
                            },
                            error: function(response) {
                                Swal.fire('Error', 'Something went wrong', 'error');
                            }
                        });
                    }
                });
            });

            // Populate Dokter options
            $.ajax({
                url: `${HOST_URL}/dokter/data`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    let options = response.data.map(dokter => `<option value="${dokter.id}">${dokter.nama}</option>`);
                    $('#id_dokter').html(options);
                }
            });
        });
    </script>
@endsection
