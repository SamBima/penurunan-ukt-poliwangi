<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sk_penurunan_ukt', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sk')->unique();
            $table->string('judul');
            $table->year('tahun');
            $table->date('tanggal_terbit');
            $table->text('keterangan')->nullable();
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sk_penurunan_ukt');
    }
};
