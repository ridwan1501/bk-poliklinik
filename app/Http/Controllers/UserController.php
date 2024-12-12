<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserMethodRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.users.index');
    }

    /**
     * It returns a json object of all the categories in the database.
     *
     * @return A JSON object containing all the categories.
     */
    public function data()
    {
        $users = User::query()
            ->where('role', '!=', 'user')
            ->get();

        return datatables($users)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserMethodRequest $request)
    {
        $validated = $request->validated();

        $user = new User();

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->mobilenumber = $validated['mobilenumber'];
        $user->avatar = $validated['avatar'];
        $user->role = $validated['role'];

        $user->save();

        return response()->json([
            'message' => 'User created successfully'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserMethodRequest $request, $id)
    {
        $validated = $request->validated();

        $user = User::findOrFail($id);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (isset($validated['password']) && $validated['password']) $user->password = Hash::make($validated['password']);
        $user->mobilenumber = $validated['mobilenumber'];
        $user->avatar = $validated['avatar'];
        $user->role = $validated['role'];

        $user->save();

        return response()->json([
            'message' => 'User updated successfully'
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
        $type = User::query()->findOrFail($id);

        $type->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}
