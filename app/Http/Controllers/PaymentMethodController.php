<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;
use App\Models\Type;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('dashboard.payment_method.index');
    }

    /**
     * It returns a json object of all the categories in the database.
     *
     * @return A JSON object containing all the categories.
     */
    public function data()
    {
        $categories = PaymentMethod::query()->orderBy('created_at', 'desc')->get();

        return datatables($categories)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentMethodRequest $request)
    {
        PaymentMethod::query()->create($request->validated());

        return response()->json([
            'message' => 'Payment Method created successfully'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentMethodRequest $request, $id)
    {
        $type = PaymentMethod::query()->findOrFail($id);
        $type->update($request->validated());

        return response()->json([
            'message' => 'Payment Method updated successfully'
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
        $type = PaymentMethod::query()->findOrFail($id);

        $type->delete();

        return response()->json([
            'message' => 'Payment Method deleted successfully'
        ], 200);
    }
}
