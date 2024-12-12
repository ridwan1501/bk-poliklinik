@extends('layouts.master')
@section('title')
    Obat
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
            Obat
        @endslot
        @slot('title')
            Obat
        @endslot
        @slot('btn_create')
            javascript:void(0);
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Obat</h4>
                </div>
                <!--end card-header-->
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Obat</th>
                                <th>Kemasan</th>
                                <th>Harga</th>
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
                    <form id="formObat">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="nama_obat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="nama_obat" name="nama_obat" required>
                        </div>
                        <div class="mb-3">
                            <label for="kemasan" class="form-label">Kemasan</label>
                            <input type="text" class="form-control" id="kemasan" name="kemasan" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
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

        function formatRupiah(angka) {
            var number_string = angka.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return 'Rp ' + rupiah;
        }

        var datatable = function() {
            var table = $('#datatable').DataTable({
                responsive: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                order: [],
                ajax: {
                    url: '{{ route('backoffice.obat.data') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'nama_obat', name: 'nama_obat' },
                    { data: 'kemasan', name: 'kemasan' },
                    { data: 'harga', name: 'harga', render: function(data, type, row) {
                        return formatRupiah(data);
                    } },
                    { data: 'id', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    {
                        targets: -1,
                        render: function(data, type, row) {
                            let json_row = JSON.stringify(row);
                            return `
                                <button class="btn btn-sm btn-soft-primary btn-edit" data-row='${json_row}''><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-soft-danger btn-destroy" data-id="${data}"><i class="fas fa-trash"></i></button>
                            `;
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
                let url = id ? `${HOST_URL}/obat/${id}` : `${HOST_URL}/obat`;
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
                $('.modal-title').text('Edit Data: ' + row.nama_obat);
                $('#modalForm').modal('show');
                $('#id').val(row.id);
                $('#nama_obat').val(row.nama_obat);
                $('#kemasan').val(row.kemasan);
                $('#harga').val(row.harga);
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
                            url: `${HOST_URL}/obat/${id}`,
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
        });
    </script>
@endsection
