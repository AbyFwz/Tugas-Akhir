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
        $data = Surat::with('user')->where('tipe', 'Surat Keluar')->where('asal', null)->get();
        $data = json_encode($data);

        return response()->json(['suratKeluar' => $data]);
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
        $data->nomor = $request->nomor_surat;
        $data->tujuan = $request->tujuan_surat;
        $data->uraian = $request->uraian;
        $data->keterangan = $request->keterangan;
        $data->tipe = 'Surat Keluar';
        $data->file = null;
        $data->user_id = auth()->user()->id;
        $data->save();
        $data = json_encode($data);

        return response()->json(['suratKeluar' => $data], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Surat::with('user')->findOrFail($id);
        $data = json_encode($data);

        return response()->json(['suratKeluar' => $data], 200);
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
        $data->nomor = $request->nomor_surat;
        $data->tujuan = $request->tujuan_surat;
        $data->uraian = $request->uraian;
        $data->keterangan = $request->keterangan;
        $data->tipe = 'Surat Keluar';
        $data->file = null;
        $data->save();
        $data = json_encode($data);

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
