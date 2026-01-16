<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'user_id',
        'nim',
        'nama_lengkap',
        'prodi_id',
        'jalur_masuk',
        'no_hp',
        'semester_saat_ini',
        'ukt_awal',
        'piutang_semester_lalu',
    ];

    protected $casts = [
        'ukt_awal' => 'integer',
        'piutang_semester_lalu' => 'integer',
        'semester_saat_ini' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function jurusan()
    {
        return $this->hasOneThrough(Jurusan::class, Prodi::class, 'id', 'id', 'prodi_id', 'jurusan_id');
    }

    public function pengajuanPenurunanUkt()
    {
        return $this->hasMany(PengajuanPenurunanUkt::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('nim', 'like', '%' . $search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $search . '%');
    }

    public function scopeByProdi($query, $prodiId)
    {
        return $query->where('prodi_id', $prodiId);
    }

    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester_saat_ini', $semester);
    }

    public function getPengajuanAktifAttribute()
    {
        return $this->pengajuanPenurunanUkt()
                   ->whereIn('status', ['diajukan', 'dinilai_admin', 'dinilai_keuangan', 'dinilai_wadir'])
                   ->latest()
                   ->first();
    }

    public function getFormattedUktAwalAttribute()
    {
        return 'Rp ' . number_format($this->ukt_awal, 0, ',', '.');
    }

    public function getFormattedPiutangAttribute()
    {
        return 'Rp ' . number_format($this->piutang_semester_lalu, 0, ',', '.');
    }

    public function hasActivePengajuan()
    {
        return $this->pengajuanPenurunanUkt()
                   ->whereIn('status', ['diajukan', 'dinilai_admin', 'dinilai_keuangan', 'dinilai_wadir'])
                   ->exists();
    }
}
