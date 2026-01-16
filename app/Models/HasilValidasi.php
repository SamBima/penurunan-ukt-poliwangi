<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilValidasi extends Model
{
    use HasFactory;

    protected $table = 'hasil_validasi';

    protected $fillable = [
        'pengajuan_id',
        'user_id',
        'catatan',
        'hasil_wawancara',
        'hasil_score',
        'rekomendasi_ukt',
        'status',
        'berlaku_selama',
    ];

    protected $casts = [
        'hasil_score' => 'integer',
        'rekomendasi_ukt' => 'integer',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPenurunanUkt::class, 'pengajuan_id');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mahasiswa()
    {
        return $this->hasOneThrough(
            Mahasiswa::class,
            PengajuanPenurunanUkt::class,
            'id',
            'id',
            'pengajuan_id',
            'mahasiswa_id'
        );
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByValidator($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'disetujui' => 'Disetujui',
            'disarankan_cicilan' => 'Disarankan Cicilan',
        ];

        return $statusLabels[$this->status] ?? $this->status;
    }

    public function getFormattedRekomendasiUktAttribute()
    {
        return 'Rp ' . number_format($this->rekomendasi_ukt, 0, ',', '.');
    }

    public function getValidatorNameAttribute()
    {
        return $this->validator->name ?? 'Unknown';
    }

    public function getValidatorRoleAttribute()
    {
        return ucfirst($this->validator->role) ?? 'unknown';
    }

    public function getPersentasePenurunanAttribute()
    {
        if ($this->pengajuan && $this->pengajuan->mahasiswa && $this->rekomendasi_ukt) {
            $uktAwal = $this->pengajuan->mahasiswa->ukt_awal;
            if ($uktAwal > 0) {
                $penurunan = (($uktAwal - $this->rekomendasi_ukt) / $uktAwal) * 100;
                return round($penurunan, 2);
            }
        }
        return 0;
    }

    public function getFormattedPersentasePenurunanAttribute()
    {
        return $this->persentase_penurunan . '%';
    }
}
