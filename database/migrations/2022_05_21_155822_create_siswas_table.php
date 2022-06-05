<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            // TODO: Research tentang data siswa
            // TODO: Mikir logika absensi harian dan bulanan
            // TODO: Bikin graph mutasi siswa dibagi berdasarkan bulan, tahun, dan P/L (Pindah, Putus Sekolah, Meninggal)
            // TODO: Bikin table catatan prestasi
            // TODO: Bikin graph jarak tempuh siswa perkelompok / perangkatan
            $table->id();
            $table->integer('nomor_induk')->nullable();
            // Informasi Umum
            $table->string('nama_lengkap_siswa');
            $table->string('nama_panggilan_siswa');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('agama');
            $table->string('kewarganegaraan')->default('Indonesia');
            $table->string('bahasa'); // Bahasa Sehari hari
            // End Informasi Umum
            // Saudara
            $table->integer('saudara_kandung');
            $table->integer('saudara_tiri');
            $table->integer('saudara_angkat');
            // End Saudara
            // Keadaan Jasmani
            $table->integer('berat_badan')->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->text('penyakit')->nullable();
            // End Keadaan Jasmani
            // Informasi Rumah dan Kontak
            $table->string('alamat_siswa');
            $table->string('no_hp');
            $table->string('bertempat_tinggal'); // (Orang tua/Wali/Asrama/Menumpang)
            $table->string('jarak_tempat_tinggal');
            // End Informasi Rumah dan Kontak
            $table->datetime('tanggal_terdaftar');
            $table->datetime('tanggal_lulus')->nullable();
            $table->string('pendidikan_selanjutnya')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswas');
    }
}
