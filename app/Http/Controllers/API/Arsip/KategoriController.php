<?php

namespace App\Http\Controllers\API\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Kategori::all();
        $data = json_encode($data);
        return response()->json(['kategori' => $data]);
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
            'nama_kategori' => 'required|string|max:255',
            'keterangan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 406);
        }

        $data = new Kategori();
        $data->nama = $request->nama_kategori;
        $data->keterangan = $request->keterangan;
        $data->user_id = auth()->user()->id;
        $data->save();

        return response()->json(['message' => 'Data berhasil ditambahkan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Kategori::findOrFail($id);
        $data = json_encode($data);
        return response()->json(['kategori' => $data]);
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
            'nama_kategori' => 'required|string|max:255',
            'keterangan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 406);
        }

        $data = Kategori::findOrFail($id);
        $data->nama = $request->nama_kategori;
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
        $data = Kategori::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus!']);
    }
}
