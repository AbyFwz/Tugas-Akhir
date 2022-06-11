<?php

namespace App\Http\Controllers\API\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArsipController extends Controller
{
    /**
     *
     *
     *
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Arsip::all();
        $data = json_encode($data);
        return response()->json(['arsip' => $data]);
    }

    /**
     *
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

        $data = new Arsip;
        $data->nama_arsip = $request->nama_arsip;
        $data->keterangan = $request->keterangan;
        $data->file_arsip = $request->file_arsip;
        $data->save();
        $data = json_encode($data);

        return response()->json(['arsip' => $data], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Arsip::findOrFail($id);
        $data = json_encode($data);

        return response()->json(['arsip' => $data], 200);
    }

    /**
     *
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

        $data = Arsip::findOrFail($id);
        $data->nama_arsip = $request->nama_arsip;
        $data->keterangan = $request->keterangan;
        $data->file_arsip = $request->file_arsip;
        $data->save();
        $data = json_encode($data);

        return response()->json(['arsip' => $data], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Arsip::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus', 'arsip' => $id], 204);
    }
}
