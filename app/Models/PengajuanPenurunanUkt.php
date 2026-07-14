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

    public function getPoinTotalGajiAttribute()
    {
        $totalGaji = $this->total_gaji;

        if ($totalGaji == 0) {
            return 0;
        } elseif ($totalGaji < 1000000) {
            return 5;
        } elseif ($totalGaji < 1500000) {
            return 10;
        } elseif ($totalGaji < 2000000) {
            return 20;
        } elseif ($totalGaji < 2500000) {
            return 30;
        } elseif ($totalGaji < 3000000) {
            return 40;
        } elseif ($totalGaji < 3500000) {
            return 50;
        } elseif ($totalGaji < 4000000) {
            return 60;
        } elseif ($totalGaji < 4500000) {
            return 70;
        } else {
            return 80;
        }
    }

    public function getPoinJumlahTanggunganAttribute()
    {
        $poinMap = [
            0 => 80,
            1 => 70,
            2 => 60,
            3 => 50,
            4 => 40,
            5 => 30,
            6 => 20,
            7 => 10,
        ];

        return $poinMap[$this->jumlah_tanggungan] ?? 10;
    }

    public function getPoinTagihanListrikAttribute()
    {
        $tagihanListrik = $this->tagihan_listrik;

        if ($tagihanListrik < 49999) {
            return 10;
        } elseif ($tagihanListrik < 99999) {
            return 20;
        } elseif ($tagihanListrik < 149999) {
            return 30;
        } elseif ($tagihanListrik < 199999) {
            return 40;
        } elseif ($tagihanListrik < 249999) {
            return 50;
        } elseif ($tagihanListrik < 299999) {
            return 60;
        } elseif ($tagihanListrik < 350000) {
            return 70;
        } elseif ($tagihanListrik < 2000000) {
            return 80;
        } else {
            return 90;
        }
    }
    
    public function getPoinPBBAttribute()
    {
        $pbb = $this->pbb;

        if ($pbb < 49999) {
            return 10;
        } elseif ($pbb < 99999) {
            return 20;
        } elseif ($pbb < 149999) {
            return 30;
        } elseif ($pbb < 199999) {
            return 40;
        } elseif ($pbb < 249999) {
            return 50;
        } elseif ($pbb < 299999) {
            return 60;
        } elseif ($pbb < 350000) {
            return 70;
        } elseif ($pbb < 2000000) {
            return 80;
        } else {
            return 100;
        }
    }
    
    public function getPoinTagihanPDAMAttribute()
    {
        $tagihanPDAM = $this->tagihan_pdam;

        if ($tagihanPDAM < 49999) {
            return 10;
        } elseif ($tagihanPDAM < 99999) {
            return 20;
        } elseif ($tagihanPDAM < 149999) {
            return 30;
        } elseif ($tagihanPDAM < 199999) {
            return 40;
        } elseif ($tagihanPDAM < 249999) {
            return 50;
        } elseif ($tagihanPDAM < 299999) {
            return 60;
        } elseif ($tagihanPDAM < 350000) {
            return 70;
        } elseif ($tagihanPDAM < 2000000) {
            return 80;
        } else {
            return 100;
        }
    }

    public function getPoinDayaListrikAttribute()
    {
        $daya = (int) $this->daya_listrik;

        if ($daya >= 0 && $daya <= 450) {
            return 10;
        } elseif ($daya <= 900) {
            return 20;
        } elseif ($daya <= 1300) {
            return 30;
        } else {
            return 40;
        }
    }

    public function getPoinJumlahMotorAttribute()
    {
        $motor = (int) $this->jumlah_motor;
        if ($motor === 0) return 0;
        if ($motor === 1) return 10;
        if ($motor === 2) return 15;
        if ($motor === 3) return 20;
        if ($motor === 4) return 25;
        if ($motor === 5) return 30;
        if ($motor === 6) return 35;
        if ($motor === 7) return 40;
        return 45;
    }

    public function getPoinJumlahMobilAttribute()
    {
        $mobil = (int) $this->jumlah_mobil;
        if ($mobil === 0) return 0;
        if ($mobil === 1) return 10;
        if ($mobil === 2) return 20;
        if ($mobil === 3) return 30;
        if ($mobil === 4) return 40;
        if ($mobil === 5) return 50;
        if ($mobil === 6) return 60;
        if ($mobil === 7) return 70;
        return 80;
    }

    public function getPoinKepemilikanKartuAttribute()
    {
        return match($this->kepemilikan_kartu) {
            'kip', 'pkh', 'bpnt' => -15,
            'tidak_ada' => 0,
            'KKS' => -10,
            'SKTM' => -5,
        };
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
