<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::with('role')->get();
        // echo "<pre>"; dd($data); die;
        $data = json_encode($data);

        return response()->json(['user' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $role = Role::findOrFail($request->role_id);

        $data = new User();
        $data->name = $request->nama;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->role_id = $request->role_id;
        $data->save();

        return response()->json(['message' => 'Data berhasil ditambahkan!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::with('role')->findOrFail($id);
        $data = json_encode($data);
        return response()->json(['user' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $role = Role::findOrFail($request->role_id);

        $data = User::with('role')->findOrFail($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->role_id = $request->role_id;
        $data->save();

        return response()->json(['message' => 'Data berhasil diubah!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $date->delete();

        return response()->json(['message' => 'Data berhasil dihapus!'], 200);
    }
}
