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
            Riwayat Periksa
        @endslot
        @slot('title')
            History
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Riwayat Periksa</h4>
                </div>
                <!--end card-header-->
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Dibuat</th>
                                <th>Hari</th>
                                <th>Pasien</th>
                                <th>No Antrian</th>
                                <th>Keluhan</th>
                                <th>Biaya Periksa</th>
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
                    url: '{{ route('backoffice.registrasi.data') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    {
                        data: 'created_at',
                        name: 'nama_poli',
                        render: function(data, type, row) {
                            return new Date(data).toLocaleString();
                        }
                    },
                    { data: 'jadwal_periksa.hari', name: 'hari' },
                    { data: 'pasien.nama', name: 'nama' },
                    { data: 'no_antrian', name: 'no_antrian' },
                    { data: 'keluhan', name: 'keluhan' },
                    {
                        data: 'periksa',
                        name: 'biaya_periksa',
                        render: function(data, type, row) {
                            let nominal = undefined;
                            if (row?.periksa?.biaya_periksa) {
                                nominal = row.periksa.biaya_periksa;
                            }

                            console.log('nominal', nominal);
                            return (nominal ? formatRupiah(nominal) : '-');
                        }
                    },
                    {
                        data: 'id',
                        name: 'status',
                        render: function(data, type, row) {
                            let status = '-';
                            let badge = '';
                            if (row.periksa) {
                                badge = 'badge-soft-success';
                                status = 'Selesai';
                            } else {
                                badge = 'badge-soft-warning';
                                status = 'Menunggu Pemeriksaan';
                            }
                            return `<span class="badge ${badge}">${status}</span>`;
                        }
                    },
                    { data: 'id', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    {
                        targets: 1,
                        render: function(data, type, row) {
                            return `${row.jadwal_periksa.hari}<br />${row.jadwal_periksa.jam_mulai}-${row.jadwal_periksa.jam_selesai}`;
                        }
                    },
                    {
                        targets: -1,
                        render: function(data, type, row) {
                            let json_row = JSON.stringify(row);
                            let renderButton = '';
                            // const view = `<button class="btn btn-sm btn-soft-primary btn-edit"><i class="fas fa-edit"></i></button>`;
                            // const delete = `<button class="btn btn-sm btn-soft-danger btn-destroy" data-id="${data}"><i class="fas fa-trash"></i></button>`;
                            @if (auth()->user()->role == 'admin' || auth()->user()->role == 'dokter')
                                renderButton = `
                                    <a href="${HOST_URL}/registrasi/detail/${data}"><button class="btn btn-sm btn-soft-primary"><i class="fas fa-eye"></i></button></a>
                                    <button class="btn btn-sm btn-soft-danger btn-destroy" data-id="${data}"><i class="fas fa-trash"></i></button>
                                `;
                            @else
                                renderButton = `<a href="${HOST_URL}/registrasi/detail/${data}"><button class="btn btn-sm btn-soft-primary"><i class="fas fa-eye"></i></button></a>`;
                            @endif

                            return renderButton;
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
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    console.log(result)
                    if (result.value) {
                        $.ajax({
                            url: `${HOST_URL}/poli/${id}`,
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
