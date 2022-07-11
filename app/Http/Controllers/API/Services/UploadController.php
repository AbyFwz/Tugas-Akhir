<?php

namespace App\Http\Controllers\API\Services;

use App\Http\Controllers\Controller;
use App\Models\Arsip\Arsip;
use App\Models\Arsip\Kategori;
use App\Models\Surat\Surat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function handleUpload(Request $request)
    {
        $validator = Validator::make($request->all, [
            'id' => 'required',
            'file' => 'required|file|mimetypes:application/msword,application/vnd.openxmlformats-officedocument.*,application/pdf,image/*,application/vnd.ms-excel,application/vnd.ms-powerpoint,application/zip,application/x-rar-compressed,text/*,application/octet-stream|max:4096',
            'type' => 'required|string|max:55',
            'request' => 'required|string|max:55'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 406);
        }

        $data = null;

        switch ($request->request) {
            case 'arsip':
                $data = Arsip::findOrFail($request->id);
                $kategori = $request->kategori;
                break;

            case 'surat-masuk':
                $data = Surat::findOrFail($request->id);
                $data->tipe = 'Surat Masuk';
                $kategori = '';
                break;

            case 'surat-keluar':
                $data = Surat::findOrFail($request->id);
                $data->tipe = 'Surat Masuk';
                $kategori = '';
                break;

            default:
                return response()->json(['error' => 'Tipe upload tidak sesuai!'], 406);
                break;
        }

        $file = $request->file;
        $ext = $file->getClientOriginalExtension();
        $nama = Carbon::now()->format('Y-m-d_His') . "_" . $kategori . "." . $ext;
        $path = Storage::putFileAs('public/surat/surat-keluar/', $file, $nama);

        try {
            $data->save();
            return response()->json(['success' => 'File berhasil diupload!'], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['error' => $th]);
        }
    }
}
