<?php

namespace App\Http\Controllers;

use App\Http\Requests\JadwalPeriksaRequest;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.jadwal_periksa.index');
    }

    /**
     * It returns a json object of all the jadwal periksa in the database.
     *
     * @return A JSON object containing all the jadwal periksa.
     */
    public function data()
    {
        $id_dokter = Auth::user()->id_dokter;
        $jadwalPeriksas = JadwalPeriksa::with('dokter')
            ->when($id_dokter, function ($query, $id_dokter) {
                return $query->where('id_dokter', $id_dokter);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return datatables($jadwalPeriksas)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\JadwalPeriksaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JadwalPeriksaRequest $request)
{
    try {
        $payload = $request->validated();
        $id_dokter = Auth::user()->id_dokter;
        if ($id_dokter) {
            $payload['id_dokter'] = $id_dokter;
        }

        // Cek jadwal yang sama
        $existingJadwal = JadwalPeriksa::where([
            'id_dokter' => $payload['id_dokter'],
            'hari' => $payload['hari'],
        ])->first();

        if ($existingJadwal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dokter sudah memiliki jadwal pada hari ' . $payload['hari']
            ], 422);
        }

        $jadwal = JadwalPeriksa::create($payload);

        if ($payload['status'] == 1) {
            JadwalPeriksa::where('id_dokter', $payload['id_dokter'])
                ->where('id', '!=', $jadwal->id)
                ->update(['status' => false]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal Periksa berhasil ditambahkan'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menambahkan jadwal: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\JadwalPeriksaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JadwalPeriksaRequest $request, $id)
{
    try {
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);
        $payload = $request->validated();
        $id_dokter = Auth::user()->id_dokter;
        if ($id_dokter) {
            $payload['id_dokter'] = $id_dokter;
        }

        // Cek jadwal yang sama selain jadwal yang sedang diupdate
        if (isset($payload['hari'])) {
            $existingJadwal = JadwalPeriksa::where([
                'id_dokter' => $payload['id_dokter'],
                'hari' => $payload['hari'],
            ])
            ->where('id', '!=', $id)
            ->first();

            if ($existingJadwal) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Dokter sudah memiliki jadwal pada hari ' . $payload['hari']
                ], 422);
            }
        }

        $jadwalPeriksa->update($payload);

        if ($payload['status'] == 1) {
            JadwalPeriksa::where('id_dokter', $payload['id_dokter'])
                ->where('id', '!=', $id)
                ->update(['status' => false]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal Periksa berhasil diperbarui'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal memperbarui jadwal: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);
        $jadwalPeriksa->delete();

        return response()->json([
            'message' => 'Jadwal Periksa deleted successfully'
        ], 200);
    }
}
