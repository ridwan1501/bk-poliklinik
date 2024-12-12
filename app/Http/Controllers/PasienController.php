<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasienRequest;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.pasien.index');
    }

    /**
     * It returns a json object of all the pasiens in the database.
     *
     * @return A JSON object containing all the pasiens.
     */
    public function data()
    {
        $pasiens = Pasien::orderBy('created_at', 'desc')->get();

        return datatables($pasiens)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PasienRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PasienRequest $request)
    {
        $no_rm = Pasien::generateNoRM();
        $payload = $request->validated();
        $payload['no_rm'] = $no_rm;
        $data = Pasien::create($payload);

        User::create([
            'name' => $payload['nama'],
            'email' => $payload['nama'],
            'password' => bcrypt($payload['alamat']),
            'id_pasien' => $data->id,
            'role' => 'pasien'
        ]);

        return response()->json([
            'message' => 'Pasien created successfully'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PasienRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PasienRequest $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->validated());

        $user = User::where('id_pasien', $id)->first();
        $user->update([
            'name' => $request->nama,
            'email' => $request->nama,
            'password' => bcrypt($request->alamat)
        ]);

        return response()->json([
            'message' => 'Pasien updated successfully'
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
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        $user = User::where('id_pasien', $id)->first();
        if ($user) $user->delete();

        return response()->json([
            'message' => 'Pasien deleted successfully'
        ], 200);
    }
}
