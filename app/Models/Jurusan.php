<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected $fillable = [
        'nama',
    ];

    public function prodi()
    {
        return $this->hasMany(Prodi::class);
    }

    public function mahasiswa()
    {
        return $this->hasManyThrough(Mahasiswa::class, Prodi::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('nama', 'like', '%' . $search . '%');
    }

    public function getTotalMahasiswaAttribute()
    {
        return $this->mahasiswa()->count();
    }
}
