<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DokumenPendukung extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pendukung';

    protected $fillable = [
        'pengajuan_id',
        'jenis_dokumen',
        'keterangan',
        'path',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPenurunanUkt::class, 'pengajuan_id');
    }

    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_dokumen', $jenis);
    }

    public function getJenisLabelAttribute()
    {
        $jenisLabels = [
            'foto_rumah' => 'Foto Rumah',
            'foto_mobil' => 'Foto Mobil',
            'foto_motor' => 'Foto Motor',
            'tagihan_listrik' => 'Tagihan Listrik',
            'lainnya' => 'Lainnya',
        ];

        return $jenisLabels[$this->jenis_dokumen] ?? $this->jenis_dokumen;
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }

    public function getFileNameAttribute()
    {
        return basename($this->path);
    }

    public function getFileExtensionAttribute()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    public function isImage()
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        return in_array(strtolower($this->file_extension), $imageExtensions);
    }

    public function isPdf()
    {
        return strtolower($this->file_extension) === 'pdf';
    }

    public function getFileSizeAttribute()
    {
        if (Storage::exists($this->path)) {
            $bytes = Storage::size($this->path);
            $units = ['B', 'KB', 'MB', 'GB'];

            for ($i = 0; $bytes > 1024; $i++) {
                $bytes /= 1024;
            }

            return round($bytes, 2) . ' ' . $units[$i];
        }

        return 'Unknown';
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($dokumen) {
            if (Storage::exists($dokumen->path)) {
                Storage::delete($dokumen->path);
            }
        });
    }
}
