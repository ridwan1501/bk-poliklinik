<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Dokter;
use App\Models\JadwalPeriksa;
use App\Models\Periksa;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class RegistrasiController extends Controller
{
    public function index()
    {
        return view('dashboard.registrasi.index');
    }

    public function history()
    {
        return view('dashboard.registrasi.history');
    }

    public function detail($id)
    {
        $data = DaftarPoli::with('jadwalPeriksa.dokter.poli', 'periksa.detailPeriksas.obat', 'pasien')->find($id);
        $ids_obat = $data && $data->periksa && $data->periksa->detailPeriksas ? $data->periksa->detailPeriksas->pluck('id_obat')->map(function ($id) {
            return (string) $id;
        })->toArray() : [];

        return view('dashboard.registrasi.detail', compact('data', 'ids_obat'));
    }

    public function data()
    {
        $id_pasien = Auth::user()->id_pasien;
        $daftarPolis = DaftarPoli::with('jadwalPeriksa.dokter.poli', 'periksa', 'pasien');
        if (Auth::user()->role == 'dokter') {
            $daftarPolis->whereHas('jadwalPeriksa.dokter', function ($query) {
                $query->where('id', Auth::user()->id_dokter);
            });
        } else if (Auth::user()->role == 'pasien') {
            $daftarPolis->where('id_pasien', $id_pasien);
        }
        $daftarPolis->orderBy('created_at', 'desc')->get();

        return datatables($daftarPolis)->toJson();
    }

    public function dataDokter()
    {
        $dokters = Dokter::with('poli')->orderBy('created_at', 'desc')->get();

        return datatables($dokters)->toJson();
    }

    public function dataPoli()
    {
        $polis = Poli::orderBy('created_at', 'desc')->get();

        return datatables($polis)->toJson();
    }

    public function dataJadwalPeriksa(Request $request)
    {
        $query = JadwalPeriksa::with('dokter')->orderBy('created_at', 'desc');

        if ($request->has('hari')) {
            $query->where('hari', $request->input('hari'));
        }

        if ($request->has('id_dokter')) {
            $query->where('id_dokter', $request->input('id_dokter'));
        }

        if ($request->has('id_poli')) {
            $query->whereHas('dokter', function ($query2) use ($request) {
                $query2->where('id_poli', $request->input('id_poli'));
            });
        }

        $jadwalPeriksas = $query->get();

        return datatables($jadwalPeriksas)->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_jadwal' => 'required',
                'keluhan' => 'required',
            ]);

            $no_antrian = DaftarPoli::count() + 1;
            $id_pasien = Auth::user()->id_pasien;

            DaftarPoli::create([
                'id_pasien' => $id_pasien,
                'id_jadwal' => $request->input('id_jadwal'),
                'keluhan' => $request->input('keluhan'),
                'no_antrian' => $no_antrian,
            ]);

            return redirect()->route('backoffice.registrasi.index')->with('success', "Registrasi berhasil: Antrian $no_antrian");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function upsertPeriksa(Request $request)
    {
        try {
            $allRequest = $request->all();
            $id_daftar_poli = $allRequest['id_daftar_poli'];
            $id_obat_selected = json_decode($allRequest['id_obat_selected']);
            $biaya_pemeriksaan = $allRequest['biaya_pemeriksaan'];
            $tgl_periksa = $allRequest['tgl_periksa'];
            $catatan = $allRequest['catatan'];

            $periksa = Periksa::updateOrCreate(
                ['id_daftar_poli' => $id_daftar_poli],
                [
                    'biaya_periksa' => $biaya_pemeriksaan,
                    'tgl_periksa' => $tgl_periksa,
                    'catatan' => $catatan,
                ]
            );

            DetailPeriksa::where('id_periksa', $periksa->id)->delete();
            foreach ($id_obat_selected as $id_obat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $id_obat,
                ]);
            }

            return redirect()->route('backoffice.registrasi.detail', $id_daftar_poli)->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
