<?php

namespace App\Http\Controllers\API\Surat;

use App\Http\Controllers\Controller;
use App\Models\Surat\Surat;
use Illuminate\Http\Request;
use app\Models\SuratMasuk;
use Illuminate\Support\Facades\Validator;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Surat::with('user')->where('tipe', 'Surat Masuk')->where('tujuan', null)->get();
        $data = json_encode($data);

        return response()->json(['suratMasuk' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
        * *MIMES COLLECTION
        * application/msword: DOC
        * application/vnd.ms-excel: xls xlm xla xlc xlt xlw
        * application/vnd.ms-powerpoint: ppt pps pot
        * application/pdf: PDF
        * image/*: all image formats
        * application/zip: zip
        * application/x-rar-compressed: rar
        * application/vnd.openxmlformats-officedocument.*: DOCX, XLSX, PPTX
        * application/octet-stream: Unknown Type
        */
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:255',
            'nama_surat' => 'required|string|max:255',
            'asal_surat' => 'required|string|max:255',
            'keterangan' => 'string',
            'file_surat' => 'required|file|mimetypes:application/msword,application/vnd.openxmlformats-officedocument.*,application/pdf,image/*,application/vnd.ms-excel,application/vnd.ms-powerpoint,application/zip,application/x-rar-compressed,text/*,application/octet-stream|max:4096'

        ]);

        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 406);
        }

        if ($request->hasFile('file_surat')) {
            $kategori = 'Surat_Masuk';
            $file = $request->file_surat;
            $nama_file = Carbon::now()->format('Y-m-d_His') . "_" . $kategori . "." . $file->getClientOriginalExtension();
            $path = Storage::putFileAs('public/surat/surat-masuk/', $request->file_surat, $nama_file);
        } else {
            $nama_file = '';
        }

        $data = new Surat;
        $data->nomor = $request->nomor_surat;
        $data->nama = $request->nama_surat;
        $data->asal = $request->asal_surat;
        $data->keterangan = $request->keterangan;
        $data->tipe = 'Surat Masuk';
        $data->file = null;
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
        $data = Surat::with('user')->findOrFail($id);
        $file = Storage::url($data->file);
        $data = json_encode($data);

        return response()->json(['suratMasuk' => $data, 'file' => $file], 200);
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
        /**
        * *MIMES COLLECTION
        * application/msword: DOC
        * application/vnd.ms-excel: xls xlm xla xlc xlt xlw
        * application/vnd.ms-powerpoint: ppt pps pot
        * application/pdf: PDF
        * image/*: all image formats
        * application/zip: zip
        * application/x-rar-compressed: rar
        * application/vnd.openxmlformats-officedocument.*: DOCX, XLSX, PPTX
        * application/octet-stream: Unknown Type
        */
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:255',
            'nama_surat' => 'required|string|max:255',
            'asal_surat' => 'required|string|max:255',
            'keterangan' => 'string',
            'file_surat' => 'file|mimetypes:application/msword,application/vnd.openxmlformats-officedocument.*,application/pdf,image/*,application/vnd.ms-excel,application/vnd.ms-powerpoint,application/zip,application/x-rar-compressed,text/*,application/octet-stream|max:4096'

        ]);

        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 406);
        }

        if ($request->hasFile('file_surat')) {
            $kategori = 'Surat_Masuk';
            $file = $request->file_surat;
            $nama_file = Carbon::now()->format('Y-m-d_His') . "_" . $kategori . "." . $file->getClientOriginalExtension();
            $path = Storage::putFileAs('public/surat/surat-masuk/', $request->file_surat, $nama_file);
        }

        $data = Surat::findOrFail($id);
        $data->nomor = $request->nomor_surat;
        $data->nama = $request->nama_surat;
        $data->asal = $request->asal_surat;
        $data->keterangan = $request->keterangan;
        $data->tipe = 'Surat Masuk';
        $data->file = $path;
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
        $data = Surat::findOrFail($id);
        Storage::delete($data->file);
        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus!'], 200);
    }
}
