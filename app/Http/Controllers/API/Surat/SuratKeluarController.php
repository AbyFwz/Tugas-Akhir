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
            $kategori = 'Surat_Keluar';
            $file = $request->file_surat;
            $nama_file = Carbon::now()->format('Y-m-d_His') . "_" . $kategori . "." . $file->getClientOriginalExtension();
            $path = Storage::putFileAs('surat', $request->file_surat, $nama_file);
        } else {
            $nama_file = '';
        }

        $data = new Surat;
        $data->nomor = $request->nomor_surat;
        $data->tujuan = $request->tujuan_surat;
        $data->uraian = $request->uraian;
        $data->keterangan = $request->keterangan;
        $data->tipe = 'Surat Keluar';
        $data->file = $path;
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
            $kategori = 'Surat_Keluar';
            $file = $request->file_surat;
            $nama_file = Carbon::now()->format('Y-m-d_His') . "_" . $kategori . "." . $file->getClientOriginalExtension();
            $path = Storage::putFileAs('surat', $request->file_surat, $nama_file);
        } else {
            $nama_file = '';
        }

        $data = Surat::findOrFail($id);
        $data->nomor = $request->nomor_surat;
        $data->tujuan = $request->tujuan_surat;
        $data->uraian = $request->uraian;
        $data->keterangan = $request->keterangan;
        $data->tipe = 'Surat Keluar';
        $data->file = $path;
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
