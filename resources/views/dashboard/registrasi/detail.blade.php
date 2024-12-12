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
            Detail
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
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
                <div class="card-header d-flex gap-3 align-items-center">
                    <h4 class="card-title">Detail Informasi</h4>
                    <div>
                        <span class="badge {{ $data->periksa ? 'badge-soft-success' : 'badge-soft-warning' }}">{{ $data->periksa ? 'Selesai' : 'Menunggu Pemeriksaan' }}</span>
                    </div>
                </div>
                <!--end card-header-->
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Antrian</td>
                                <td>:</td>
                                <td>{{ $data->no_antrian }}</td>
                            </tr>
                            <tr>
                                <td>Keluhan</td>
                                <td>:</td>
                                <td>{{ $data->keluhan }}</td>
                            </tr>
                            <tr>
                                <td>Catatan</td>
                                <td>:</td>
                                <td>{{ $data->periksa->catatan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Biaya Pemeriksaan</td>
                                <td>:</td>
                                <td>Rp. {{ number_format($data->periksa->biaya_periksa ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Obat</td>
                                <td>:</td>
                                <td>
                                    @if ($data->periksa)
                                        @foreach ($data->periksa->detailPeriksas as $detail)
                                            <p>{{ $detail->obat->nama_obat }} - Rp. {{ number_format($detail->obat->harga, 0) }}</p>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if(auth()->user()->role == 'dokter')
            <div class="card">
                <div class="card-header d-flex gap-3 align-items-center">
                    <h4 class="card-title">Form Pemeriksaan</h4>
                </div>
                <!--end card-header-->
                <div class="card-body table-responsive">
                    <form method="POST" action="{{ route('backoffice.registrasi.upsert-periksa') }}">
                        @csrf
                        <input type="hidden" name="id_daftar_poli" value="{{ $data->id }}">
                        <input type="hidden" name="id_obat_selected" value="{{ json_encode($ids_obat) }}">
                        <input type="hidden" name="biaya_pemeriksaan">
                        <div class="mb-3 row">
                            <label for="tgl_periksa" class="form-label col-sm-2">Tanggal Pemeriksaan</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="date" id="tgl_periksa" name="tgl_periksa" value={{ $data && $data->periksa ? $data->periksa->tgl_periksa : '' }} required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="catatan" class="form-label col-sm-2">Catatan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="catatan" name="catatan" required>{{ $data && $data->periksa ? $data->periksa->catatan : '' }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="id_obat" class="form-label col-sm-2">Obat</label>
                            <div class="col-sm-10 d-flex gap-3">
                                <select class="form-control select2" id="id_obat" name="id_obat" required>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                <button type="button" id="buttonAddObat" class="btn btn-outline-primary" style="width: 150px"><i class="mdi mdi-plus me-2"></i>Tambah</button>
                            </div>
                            <div class="col-sm-2"></div>
                            <div id="info-obat" class="col-sm-10 mt-3">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="biaya" class="form-label col-sm-2">Biaya Pemeriksaan</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="biaya" name="biaya" value="Rp. 150.000" disabled />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="biaya_pemeriksaan_mock" class="form-label col-sm-2">Total Biaya</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="biaya_pemeriksaan_mock" name="biaya_pemeriksaan_mock" value="{{ $data && $data->periksa ? number_format($data->periksa->biaya_periksa ?? 0, 2) : 'Rp. 150.000' }}" disabled />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
            @endif
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
        var data_obat = [];

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

        const getObat = () => {
            $.ajax({
                url: `${HOST_URL}/obat/data`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    data_obat = response.data;
                    let options = response.data.map(oabt => `<option value="${oabt.id}">${oabt.nama_obat}</option>`);
                    $('#id_obat').html(options);
                    renderInfoObat();
                }
            });
        }

        const renderInfoObat = () => {
            let id_obat_selected = $('input[name="id_obat_selected"]').val();

            // Parse the existing value to an array
            id_obat_selected = id_obat_selected ? JSON.parse(id_obat_selected) : [];

            const renderHtml = id_obat_selected.map(id => {
                const obat = data_obat.find(o => o.id == id);
                if (!obat) return '';
                return `<p>${obat.nama_obat} - ${formatRupiah(obat.harga)}</p>`;
            });

            const biaya_periksa = 150000;
            const total = id_obat_selected.reduce((acc, curr) => {
                const obat = data_obat.find(o => o.id == curr);
                if (!obat) return acc;
                return acc + obat.harga;
            }, 0);

            $('input[name="biaya_pemeriksaan_mock"]').val(formatRupiah(total + biaya_periksa));
            $('input[name="biaya_pemeriksaan"]').val(total + biaya_periksa);
            $('#info-obat').html(renderHtml);
        }

        const addObat = () => {
            const id_obat = $('#id_obat').val();
            let id_obat_selected = $('input[name="id_obat_selected"]').val();

            // Parse the existing value to an array
            id_obat_selected = id_obat_selected ? JSON.parse(id_obat_selected) : [];

            // Check if id_obat already exists in the array
            if (!id_obat_selected.includes(id_obat)) {
                // Push the new id_obat to the array
                id_obat_selected.push(id_obat);

                // Update the input value with the new array
                $('input[name="id_obat_selected"]').val(JSON.stringify(id_obat_selected));
            } else {
                alert('Obat sudah ditambahkan.');
            }

            renderInfoObat();

            console.log('id_obat', id_obat);
            console.log('id_obat_selected', id_obat_selected);
        }

        jQuery(document).ready(function() {
            $(".select2").select2({
                width: '100%',
                // dropdownParent: $("#modalForm")
            });

            getObat();
            renderInfoObat();

            $('#buttonAddObat').on('click', function() {
                addObat();
            });
        });
    </script>
@endsection
