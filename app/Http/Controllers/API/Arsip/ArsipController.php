<?php

namespace App\Http\Controllers\API\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\Arsip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $data = Arsip::with('user')->get();
        // dd($data); die;
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

        if ($request->hasFile('file_arsip')) {
            echo "File ada"; die;
            $file = $request->file('file_arsip');
            $nama_file = $request->tipe_arsip . "_" . Carbon::now() . "_" . $file->getClientOriginalExtension();
            $destination = Storage::put("/arsip/" . $request->tipe_arsip . "/");
            $file->move($destination);
        } else {
            echo "file tidak ada"; die;
            $nama_file = '';
        }

        $data = new Arsip;
        $data->nomor = $request->nomor_arsip;
        $data->nama = $request->nama_arsip;
        $data->keterangan = $request->keterangan;
        $data->file = $nama_file;
        $data->user_id = auth()->user()->id;
        $data->kategori_id = $request->kategori;
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
        $data = Arsip::with('user')->with('kategori')->findOrFail($id);
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
        $data->nomor = $request->nomor_arsip;
        $data->nama = $request->nama_arsip;
        $data->keterangan = $request->keterangan;
        $data->file = $request->file_arsip;
        $data->kategori_id = $request->kategori;
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
        $data = Arsip::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
