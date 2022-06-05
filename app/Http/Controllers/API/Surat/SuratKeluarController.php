<?php

namespace App\Http\Controllers\API\Surat;

use App\Http\Controllers\Controller;
use App\Models\Surat\Surat;
use Illuminate\Http\Request;

use App\Models\SuratKeluar;
use Illuminate\Support\Facades\Validator;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Surat::where('tipe', 'Surat Keluar')->where('asal_surat', null)->get();
        return response()->json(['data' => $data]);
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

        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $data = new Surat;
        $data->nomor_surat = $request->nomor_surat;
        $data->tujuan_surat = $request->tujuan_surat;
        $data->uraian = $request->uraian;
        $data->keterangan = $request->keterangan;
        $data->tipe_surat = 'Surat Keluar';
        $data->file_surat = null;
        $data->save();

        return response()->json(['data' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Surat::findOrFail($id);

        return response()->json(['data' => $data], 200);
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

        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $data = Surat::findOrFail($id);
        $data->nomor_surat = $request->nomor_surat;
        $data->tujuan_surat = $request->tujuan_surat;
        $data->uraian = $request->uraian;
        $data->keterangan = $request->keterangan;
        $data->tipe_surat = 'Surat Keluar';
        $data->file_surat = null;
        $data->save();

        return response()->json([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Surat::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus!'], 204);
    }
}
