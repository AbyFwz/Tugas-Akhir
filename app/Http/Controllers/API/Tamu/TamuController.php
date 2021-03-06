<?php

namespace App\Http\Controllers\API\Tamu;

use App\Http\Controllers\Controller;
use App\Models\Tamu\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TamuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tamu::all();
        $data = json_encode($data);

        return response()->json(['tamu' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $data = new Tamu;
        $data->nama_instansi = $request->nama_instansi;
        $data->alamat_instansi = $request->alamat_instansi;
        $data->no_hp = $request->no_hp;
        $data->keperluan = $request->keperluan;
        $data->tipe_tamu = $request->tipe_tamu; // Tamu dinas, tamu yayasan, tamu umum
        $data->save();
        $data = json_encode($data);

        return response()->json(['tamu' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Tamu::findOrFail($id);
        $data = json_encode($data);

        return response()->json(['tamu' => $data], 200);
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
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $data = Tamu::findOrFail($id);
        $data->nama_instansi = $request->nama_instansi;
        $data->alamat_instansi = $request->alamat_instansi;
        $data->no_hp = $request->no_hp;
        $data->keperluan = $request->keperluan;
        $data->tipe_tamu = $request->tipe_tamu;
        $data->save();
        $data = json_encode($data);

        return response()->json(['tamu' => $data], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Tamu::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus!'], 204);
    }
}
