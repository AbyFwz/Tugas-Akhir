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
        try {
            $data = new Role;
            $data->nama = $request->nama_role;
            $data->keterangan = $request->keterangan;
            $data->save();
        } catch (\Throwable $e) {
            return response()->json(['message' => $e], 500);
        }

        return response()->json(['message' => 'Data berhasil diupload'], 200);
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
        $data = Role::findOrFail($id);;
        $data->nama = $request->nama_role;
        $data->keterangan = $request->keterangan;
        $data->save();

        return response()->json(['message' => 'Data berhasil diubah!']);
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
