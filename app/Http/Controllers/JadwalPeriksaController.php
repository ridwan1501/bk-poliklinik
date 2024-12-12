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
        $payload = $request->validated();
        $id_dokter = Auth::user()->id_dokter;
        if ($id_dokter) {
            $payload['id_dokter'] = $id_dokter;
        }
        $jadwal = JadwalPeriksa::create($payload);

        if ($payload['status'] == 1) {
            JadwalPeriksa::where('id_dokter', $payload['id_dokter'])
            ->where('id', '!=', $jadwal->id)
            ->update([
                'status' => false,
            ]);
        }

        return response()->json([
            'message' => 'Jadwal Periksa created successfully'
        ], 200);
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
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);
        $payload = $request->validated();
        $id_dokter = Auth::user()->id_dokter;
        if ($id_dokter) {
            $payload['id_dokter'] = $id_dokter;
        }
        $jadwalPeriksa->update($payload);

        if ($payload['status'] == 1) {
            JadwalPeriksa::where('id_dokter', $payload['id_dokter'])
                ->where('id', '!=', $id)
                ->update([
                    'status' => false,
                ]);
        }

        return response()->json([
            'message' => 'Jadwal Periksa updated successfully'
        ], 200);
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
