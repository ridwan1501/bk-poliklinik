<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function index()
    {
        return view('dashboard.antrian.index');
    }

    public function dataMenunggu()
    {
        $dayNameEnglish = date('l');
        $dayNamesIndonesian = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $dayName = $dayNamesIndonesian[$dayNameEnglish];

        $data = DaftarPoli::query()
            ->where('status_antrian', 'menunggu_dipanggil')
            ->whereHas('jadwalPeriksa', function ($query) use ($dayName) {
                $query->where('hari', $dayName);
            })
            ->with('pasien', 'jadwalPeriksa.dokter.poli')
            ->orderBy('created_at', 'asc')->get();

        return datatables($data)->toJson();
    }

    public function panggil($id)
    {
        $antrian = DaftarPoli::find($id);
        $antrian->update(['status_antrian' => 'dipanggil', 'dipanggil_pada' => now()]);

        return response()->json(['message' => 'Antrian berhasil dipanggil']);
    }

    public function display()
    {
        return view('dashboard.antrian.display');
    }

    public function dataDisplay()
    {
        $dayNameEnglish = date('l');
        $dayNamesIndonesian = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $dayName = $dayNamesIndonesian[$dayNameEnglish];

        $data = DaftarPoli::query()
            ->where('status_antrian', 'dipanggil')
            ->whereHas('jadwalPeriksa', function ($query) use ($dayName) {
                $query->where('hari', $dayName);
            })
            ->orderBy('dipanggil_pada', 'asc')
            ->first();

        $dataPrev = DaftarPoli::query()
            ->where('status_antrian', 'sudah_muncul')
            ->whereHas('jadwalPeriksa', function ($query) use ($dayName) {
                $query->where('hari', $dayName);
            })
            ->when($data, function ($query) use ($data) {
                return $query->where('id', '!=', $data->id);
            })
            ->orderBy('dipanggil_pada', 'desc')
            ->first();

        $antrianTampil = [
            'id' => $data ? $data->id : 0,
            'dipanggil' => $data ? $data->no_antrian : 0,
            'sebelumnya' => $dataPrev ? $dataPrev->no_antrian : 0
        ];


        return response()->json($antrianTampil);
    }

    public function selesaiDisplay($id)
    {
        $antrian = DaftarPoli::find($id);
        $antrian->update(['status_antrian' => 'sudah_muncul']);

        return response()->json(['message' => 'Antrian berhasil dipanggil']);
    }

}
