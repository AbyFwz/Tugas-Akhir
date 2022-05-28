<?php

namespace App\Http\Controllers\API\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Siswa::all();

        return response()->json(['data_siswa' => $data]);
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

        $data = new Siswa;
        $data->nomor_induk = $request->nomor_induk;
        $data->nama_lengkap_siswa = $request->nama_lengkap_siswa;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir; // Nanti di parse
        $data->agama = $request->agama;
        $data->kewarganegaraan = $request->kewarganegaraan;
        $data->bahasa = $request->bahasa;
        $data->saudara_kandung = $request->saudara_kandung;
        $data->saudara_tiri = $request->saudara_tiri;
        $data->saudara_angkat = $request->saudara_angkat;
        $data->berat_badan = $request->berat_badan;
        $data->tinggi_badan = $request->tinggi_badan;
        $data->golongan_darah = $request->golongan_darah;
        $data->penyakit = $request->penyakit;
        $data->alamat_siswa = $request->alamat_siswa;
        $data->no_hp = $request->no_hp;
        $data->bertempat_tinggal = $request->bertempat_tinggal;
        $data->jarak_tempat_tinggal = $request->jarak_tempat_tinggal;
        $data->tanggal_terdaftar = $request->tanggal_terdaftar;
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
        $data = Siswa::findOrFail($id);

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
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $data = Siswa::findOrFail($id);
        $data->nomor_induk = $request->nomor_induk;
        $data->nama_lengkap_siswa = $request->nama_lengkap_siswa;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir; // Nanti di parse
        $data->agama = $request->agama;
        $data->kewarganegaraan = $request->kewarganegaraan;
        $data->bahasa = $request->bahasa;
        $data->saudara_kandung = $request->saudara_kandung;
        $data->saudara_tiri = $request->saudara_tiri;
        $data->saudara_angkat = $request->saudara_angkat;
        $data->berat_badan = $request->berat_badan;
        $data->tinggi_badan = $request->tinggi_badan;
        $data->golongan_darah = $request->golongan_darah;
        $data->penyakit = $request->penyakit;
        $data->alamat_siswa = $request->alamat_siswa;
        $data->no_hp = $request->no_hp;
        $data->bertempat_tinggal = $request->bertempat_tinggal;
        $data->jarak_tempat_tinggal = $request->jarak_tempat_tinggal;
        $data->tanggal_terdaftar = $request->tanggal_terdaftar;
        $data->save();

        return response()->json(['data' => $data], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Siswa::findOrFail($id);
        $data->delete();

        return response()->json(['message' => "Data siswa berhasil dihapus!"], 204); // 204 (No Content)
    }
}
