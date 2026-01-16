<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPenurunanUkt extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_penurunan_ukt';

    protected $fillable = [
        'mahasiswa_id',
        'kode',
        'penghasilan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ibu',
        'pekerjaan_ibu',
        'total_gaji',
        'jumlah_tanggungan',
        'daya_listrik',
        'tagihan_listrik',
        'tagihan_pdam',
        'pbb',
        'jumlah_motor',
        'jumlah_mobil',
        'kepemilikan_kartu',
        'pernyataan_teman',
        'alasan_pengajuan',
        'link_drive',
        'status',
    ];

    protected $casts = [
        'penghasilan_ayah' => 'integer',
        'penghasilan_ibu' => 'integer',
        'total_gaji' => 'integer',
        'jumlah_tanggungan' => 'integer',
        'daya_listrik' => 'integer',
        'tagihan_listrik' => 'integer',
        'tagihan_pdam' => 'integer',
        'pbb' => 'integer',
        'jumlah_motor' => 'integer',
        'jumlah_mobil' => 'integer',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dokumenPendukung()
    {
        return $this->hasMany(DokumenPendukung::class, 'pengajuan_id');
    }

    public function hasilValidasi()
    {
        return $this->hasMany(HasilValidasi::class, 'pengajuan_id');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('kode', 'like', '%' . $search . '%')
                    ->orWhereHas('mahasiswa', function($q) use ($search) {
                        $q->where('nama_lengkap', 'like', '%' . $search . '%')
                          ->orWhere('nim', 'like', '%' . $search . '%');
                    });
    }

    public static function generateKode()
    {
        $year = date('Y');
        $month = date('m');
        $lastPengajuan = self::whereYear('created_at', $year)
                            ->whereMonth('created_at', $month)
                            ->count();

        $sequence = str_pad($lastPengajuan + 1, 4, '0', STR_PAD_LEFT);
        return "UKT-{$year}{$month}-{$sequence}";
    }

    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'diajukan' => 'Diajukan Ke Keuangan',
            'diterima_keuangan' => 'Diterima Keuangan',
            'dinilai_admin' => 'Dinilai Kajur',
            'dinilai_keuangan' => 'Dinilai Keuangan',
            'dinilai_wadir' => 'Dinilai Wadir',
            'disarankan_cicilan' => 'Disarankan Cicilan',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ];

        return $statusLabels[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getFormattedTotalGajiAttribute()
    {
        return 'Rp ' . number_format($this->total_gaji, 0, ',', '.');
    }

    public function getFormattedPenghasilanAyahAttribute()
    {
        return 'Rp ' . number_format($this->penghasilan_ayah, 0, ',', '.');
    }

    public function getFormattedPenghasilanIbuAttribute()
    {
        return 'Rp ' . number_format($this->penghasilan_ibu, 0, ',', '.');
    }

    public function isCompleted()
    {
        return in_array($this->status, ['disarankan_cicilan', 'disetujui']);
    }

    public function isInReview()
    {
        return in_array($this->status, ['dinilai_admin', 'dinilai_keuangan', 'dinilai_wadir']);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengajuan) {
            if (empty($pengajuan->kode)) {
                $pengajuan->kode = self::generateKode();
            }
        });
    }

    public function pointPengajuan()
    {
        return $this->hasMany(PointPengajuan::class, 'pengajuan_id');
    }

    public function pointByRole($role)
    {
        return $this->pointPengajuan()->where('role', $role)->first();
    }
}
