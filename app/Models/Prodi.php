<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';

    protected $fillable = [
        'jurusan_id',
        'nama',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function scopeByJurusan($query, $jurusanId)
    {
        return $query->where('jurusan_id', $jurusanId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('nama', 'like', '%' . $search . '%');
    }

    public function getNamaLengkapAttribute()
    {
        return $this->jurusan->nama . ' - ' . $this->nama;
    }

    public function getTotalMahasiswaAttribute()
    {
        return $this->mahasiswa()->count();
    }
}
