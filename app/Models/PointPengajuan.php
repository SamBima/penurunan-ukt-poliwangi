<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PointPengajuan extends Model
{
    use HasFactory;

    protected $table = 'point_pengajuan';

    protected $fillable = [
        'pengajuan_id',
        'user_id',
        'role',
        'poin_penghasilan_ortu',
        'poin_tagihan',
        'poin_kepemilikan',
        'poin_kondisi_rumah',
        'poin_kartu_bantuan',
        'poin_pernyataan_teman',
        'poin_jumlah_tanggungan',
        'poin_daya_listrik',
        'poin_pbb',
        'poin_wawancara',
        'total_poin',
    ];

    protected $casts = [
        'poin_penghasilan_ortu' => 'integer',
        'poin_tagihan' => 'integer',
        'poin_kepemilikan' => 'integer',
        'poin_kondisi_rumah' => 'integer',
        'poin_kartu_bantuan' => 'integer',
        'poin_pernyataan_teman' => 'integer',
        'poin_jumlah_tanggungan' => 'integer',
        'poin_daya_listrik' => 'integer',
        'poin_pbb' => 'integer',
        'poin_wawancara' => 'integer',
        'total_poin' => 'integer',
    ];

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(PengajuanPenurunanUkt::class, 'pengajuan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate total poin based on role
     */
    public function calculateTotalPoin(): int
    {
        $total = 0;

        // Poin untuk semua role
        $total += $this->poin_penghasilan_ortu ?? 0;
        $total += $this->poin_tagihan ?? 0;
        $total += $this->poin_kepemilikan ?? 0;
        $total += $this->poin_kondisi_rumah ?? 0;
        $total += $this->poin_kartu_bantuan ?? 0;
        $total += $this->poin_pernyataan_teman ?? 0;

        // Poin tambahan untuk keuangan
        if ($this->role === 'keuangan') {
            $total += $this->poin_jumlah_tanggungan ?? 0;
            $total += $this->poin_daya_listrik ?? 0;
            $total += $this->poin_pbb ?? 0;
            $total += $this->poin_wawancara ?? 0;
        }

        return $total;
    }

    /**
     * Get role label
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Admin',
            'keuangan' => 'Keuangan',
            'kajur' => 'Kajur',
            default => ucfirst($this->role)
        };
    }

    /**
     * Boot method to auto calculate total
     */
    protected static function booted(): void
    {
        static::saving(function ($pointPengajuan) {
            $pointPengajuan->total_poin = $pointPengajuan->calculateTotalPoin();
        });
    }
}
