<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Role::all();
        $data = json_encode($data);
        return response()->json(['role' => $data]);
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
            'nama_role' => 'required|string|max:55',
            'keterangan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $data = new Role;
            $data->nama = $request->nama_role;
            $data->keterangan = $request->keterangan;
            $data->save();
            return response()->json(['message' => 'Data berhasil diupload'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Role::findOrFail($id);
        $data = json_encode($data);
        return response()->json(['role' => $data]);
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
            'nama_role' => 'required|string|max:55',
            'keterangan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $data = Role::findOrFail($id);;
            $data->nama = $request->nama_role;
            $data->keterangan = $request->keterangan;
            $data->save();

            return response()->json(['message' => 'Data berhasil diubah!']);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e], 500);
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
        $data = Role::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus!'], 200);
    }
}
