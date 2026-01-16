<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('point_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_penurunan_ukt')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('role', ['admin', 'keuangan', 'kajur']);

            // Poin untuk Admin
            $table->integer('poin_penghasilan_ortu')->nullable();
            $table->integer('poin_tagihan')->nullable();
            $table->integer('poin_kepemilikan')->nullable();
            $table->integer('poin_kondisi_rumah')->nullable();
            $table->integer('poin_kartu_bantuan')->nullable();
            $table->integer('poin_pernyataan_teman')->nullable();

            // Poin untuk Keuangan (semua field admin + tambahan)
            $table->integer('poin_jumlah_tanggungan')->nullable();
            $table->integer('poin_daya_listrik')->nullable();
            $table->integer('poin_pbb')->nullable();
            $table->integer('poin_wawancara')->nullable();

            // Total poin
            $table->integer('total_poin')->default(0);

            $table->timestamps();

            // Unique constraint: satu user dengan role tertentu hanya bisa menilai satu kali per pengajuan
            $table->unique(['pengajuan_id', 'user_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_pengajuan');
    }
};
