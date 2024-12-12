<?php

namespace App\Http\Controllers;

use App\Http\Requests\PoliRequest;
use App\Models\Poli;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.poli.index');
    }

    /**
     * It returns a json object of all the poli in the database.
     *
     * @return A JSON object containing all the poli.
     */
    public function data()
    {
        $poli = Poli::query()->orderBy('created_at', 'desc')->get();

        return datatables($poli)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PoliRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PoliRequest $request)
    {
        Poli::query()->create($request->validated());

        return response()->json([
            'message' => 'Poli created successfully'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PoliRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PoliRequest $request, $id)
    {
        $poli = Poli::query()->findOrFail($id);
        $poli->update($request->validated());

        return response()->json([
            'message' => 'Poli updated successfully'
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
        $poli = Poli::query()->findOrFail($id);
        $poli->delete();

        return response()->json([
            'message' => 'Poli deleted successfully'
        ], 200);
    }
}
