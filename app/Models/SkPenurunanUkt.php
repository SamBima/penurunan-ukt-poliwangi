<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkPenurunanUkt extends Model
{
    use HasFactory;

    protected $table = 'sk_penurunan_ukt';

    protected $fillable = [
        'nomor_sk',
        'judul',
        'tahun',
        'tanggal_terbit',
        'keterangan',
        'file_path',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];
}
