<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObatRequest;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.obat.index');
    }

    /**
     * It returns a json object of all the obats in the database.
     *
     * @return A JSON object containing all the obats.
     */
    public function data()
    {
        $obats = Obat::orderBy('created_at', 'desc')->get();

        return datatables($obats)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ObatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ObatRequest $request)
    {
        Obat::create($request->validated());

        return response()->json([
            'message' => 'Obat created successfully'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ObatRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ObatRequest $request, $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->update($request->validated());

        return response()->json([
            'message' => 'Obat updated successfully'
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
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return response()->json([
            'message' => 'Obat deleted successfully'
        ], 200);
    }
}
