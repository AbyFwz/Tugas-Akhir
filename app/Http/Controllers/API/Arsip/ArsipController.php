<?php

namespace App\Http\Controllers\API\Arsip;

use App\Http\Controllers\Controller;
use App\Models\Arsip\Arsip;
use App\Models\Arsip\Kategori;
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
        $data = Arsip::with('user')->with('kategori')->get();
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
        * application/vnd.openxmlformats-officedocument.wordprocessingml.document: DOCX
        * application/vnd.openxmlformats-officedocument.spreadsheetml.sheet: XLSX
        * application/vnd.openxmlformats-officedocument.presentationml.presentation: PPTX
        * application/octet-stream: Unknown Type
        */

        $validator = Validator::make($request->all(), [
            'nomor_arsip' => 'required|string|max:255',
            'nama_arsip' => 'required|string|max:255',
            'keterangan' => 'string',
            'kategori' => 'required',
            // 'file_arsip' => 'required|file|mimes:doc,docx'
            'file_arsip' => 'required|file|mimetypes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/pdf,image/*,application/vnd.ms-excel,application/vnd.ms-powerpoint,application/zip,application/x-rar-compressed,text/*,application/octet-stream|max:4096'
        ]);

        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 406);
        }

        if ($request->file('file_arsip')) {
            $kategori = Kategori::findOrFail($request->kategori);
            $file = $request->file_arsip;
            $nama_file = Carbon::now()->format('Y-m-d_His') . "_" . $kategori->nama . "." . $file->getClientOriginalExtension();
            $path = Storage::putFileAs('public/arsip', $request->file_arsip, $nama_file);
        } else {
            return response()->json(["res" => "No File"], 406);
            $nama_file = '';
        }

        $data = new Arsip;
        $data->nomor = $request->nomor_arsip;
        $data->nama = $request->nama_arsip;
        $data->keterangan = $request->keterangan;
        $data->file = $path;
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
        $file = Storage::url($data->file);
        $data = json_encode($data);

        return response()->json(['arsip' => $data, 'file' => $file], 200);
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
        return response()->json(['request', $request->all()]);
        $validator = Validator::make($request->all(), [
            'nomor_arsip' => 'required|string|max:255',
            'nama_arsip' => 'required|string|max:255',
            'keterangan' => 'string',
            'kategori' => 'required',
            // 'file_arsip' => 'required|file|mimes:doc,docx'
            'file_arsip' => 'file|mimetypes:application/msword,application/vnd.openxmlformats-officedocument.*,application/pdf,image/*,application/vnd.ms-excel,application/vnd.ms-powerpoint,application/zip,application/x-rar-compressed,text/*,application/octet-stream|max:4096'
        ]);

        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 406);
        }

        $data = Arsip::findOrFail($id);

        if ($request->hasFile('file_arsip')) {
            $kategori = str_replace(' ', '_', Kategori::findOrFail($request->kategori));
            $file = $request->file_arsip;
            $nama_file = Carbon::now()->format('Y-m-d_His') . "_" . $kategori->nama . "." . $file->getClientOriginalExtension();
            $path = Storage::putFileAs('public/arsip', $request->file_arsip, $nama_file);
            $data->file = $path;
        }

        $data->nomor = $request->nomor_arsip;
        $data->nama = $request->nama_arsip;
        $data->keterangan = $request->keterangan;
        $data->kategori_id = $request->kategori;
        $data->save();

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
        Storage::delete($data->file);
        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
