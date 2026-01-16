<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurusan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('prodi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained('jurusan')->onDelete('cascade');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nim')->unique();
            $table->string('nama_lengkap');
            $table->foreignId('prodi_id')->constrained('prodi')->onDelete('cascade');
            $table->string('jalur_masuk');
            $table->string('no_hp');
            $table->integer('semester_saat_ini')->default(1);
            $table->bigInteger('ukt_awal')->nullable();
            $table->bigInteger('piutang_semester_lalu')->nullable();
            $table->timestamps();
        });

        Schema::create('pengajuan_penurunan_ukt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->string('kode')->unique();
            $table->bigInteger('penghasilan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->bigInteger('penghasilan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->bigInteger('total_gaji')->nullable();
            $table->integer('jumlah_tanggungan')->nullable();
            $table->integer('daya_listrik')->nullable();
            $table->bigInteger('tagihan_listrik')->nullable();
            $table->bigInteger('tagihan_pdam')->nullable();
            $table->bigInteger('pbb')->nullable();
            $table->integer('jumlah_motor')->default(0);
            $table->integer('jumlah_mobil')->default(0);
            $table->string('kepemilikan_kartu')->nullable();
            $table->string('pernyataan_teman')->nullable();
            $table->text('alasan_pengajuan')->nullable();
            $table->string('link_drive')->nullable();
            $table->enum('status', [
                'diajukan',
                'diterima_keuangan',
                'dinilai_admin',
                'dinilai_keuangan',
                'dinilai_wadir',
                'disarankan_cicilan',
                'disetujui',
                'ditolak',
            ])->default('diajukan');
            $table->timestamps();
        });

        Schema::create('dokumen_pendukung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_penurunan_ukt')->onDelete('cascade');
            $table->enum('jenis_dokumen', [
                'foto_rumah','foto_mobil','foto_motor','tagihan_listrik','lainnya'
            ]);
            $table->string('keterangan')->nullable();
            $table->string('path');
            $table->timestamps();
        });

        Schema::create('hasil_validasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_penurunan_ukt')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->text('hasil_wawancara')->nullable();
            $table->bigInteger('hasil_score')->nullable();
            $table->bigInteger('rekomendasi_ukt')->nullable();
            $table->enum('status', ['disetujui','disarankan_cicilan']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusan');
        Schema::dropIfExists('prodi');
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('pengajuan_penurunan_ukt');
        Schema::dropIfExists('dokumen_pendukung');
        Schema::dropIfExists('hasil_validasi');
    }
};
