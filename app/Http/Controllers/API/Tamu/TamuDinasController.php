<?php

namespace App\Http\Controllers\API\Tamu;

use App\Http\Controllers\Controller;
use App\Models\Tamu\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TamuDinasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tamu::with('user')->where('tipe_tamu', 'Tamu Dinas')->get();
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
            return response()->json($validator->errors());
        }

        $data = new Tamu;
        $data->nama = $request->nama_instansi;
        $data->alamat = $request->alamat_instansi;
        $data->no_hp = $request->no_hp;
        $data->keperluan = $request->keperluan;
        $data->tipe = 'Tamu Dinas'; // Tamu dinas, tamu yayasan, tamu umum
        $data->user_id = auth()->user()->id;
        $data->save();
        $data = json_encode($data);

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
        $data = Tamu::with('user')->findOrFail($id);
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
            return response()->json($validator->errors());
        }

        $data = Tamu::findOrFail($id);
        $data->nama = $request->nama_instansi;
        $data->alamat = $request->alamat_instansi;
        $data->no_hp = $request->no_hp;
        $data->keperluan = $request->keperluan;
        $data->tipe = 'Tamu Dinas';
        $data->save();
        $data = json_encode($data);

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
        $data = Tamu::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus!'], 200);
    }
}
