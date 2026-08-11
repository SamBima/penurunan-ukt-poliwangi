@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Arsip Pengajuan</h1>
        @php
            $backUrl = (request('source') === 'arsip') ? route('arsip-pengajuan') : route('list-pengajuan');
        @endphp
        <a href="{{ $backUrl }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengajuan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>ID Pemohon</strong></td>
                                    <td>: {{ $pengajuan->kode }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Mahasiswa</strong></td>
                                    <td>: {{ $pengajuan->mahasiswa->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <td><strong>NIM</strong></td>
                                    <td>: {{ $pengajuan->mahasiswa->nim }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Program Studi</strong></td>
                                    <td>: {{ $pengajuan->mahasiswa->prodi->nama }}</td>
                                </tr>
                                <tr>
                                    <td><strong>UKT Saat Ini</strong></td>
                                    <td>: {{ $pengajuan->mahasiswa->formatted_ukt_awal }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status Akhir</strong></td>
                                    <td>: 
                                        @php
                                            $finalStatus = $pengajuan->hasilValidasi->where('validator.role', 'wadir')->first();
                                            $label = 'Belum Ada Keputusan';
                                            $badge = 'secondary';
                                            
                                            if ($finalStatus) {
                                                if ($finalStatus->status == 'disetujui') {
                                                    $label = 'Disetujui';
                                                    $badge = 'success';
                                                } else {
                                                    $label = 'Disarankan Cicilan';
                                                    $badge = 'warning';
                                                }
                                            } elseif ($pengajuan->status == 'ditolak') {
                                                $label = 'Ditolak';
                                                $badge = 'danger';
                                            }
                                        @endphp
                                        <span class="badge badge-{{ $badge }}">{{ $label }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Tanggal Pengajuan</strong></td>
                                    <td>: {{ $pengajuan->created_at->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Penghasilan Ayah</strong></td>
                                    <td>: {{ $pengajuan->formatted_penghasilan_ayah }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pekerjaan Ayah</strong></td>
                                    <td>: {{ $pengajuan->pekerjaan_ayah }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Penghasilan Ibu</strong></td>
                                    <td>: {{ $pengajuan->formatted_penghasilan_ibu }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pekerjaan Ibu</strong></td>
                                    <td>: {{ $pengajuan->pekerjaan_ibu }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Penghasilan</strong></td>
                                    <td>: <strong>{{ $pengajuan->formatted_total_gaji }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Keluarga & Ekonomi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Jumlah Tanggungan</strong></td>
                                    <td>: {{ $pengajuan->jumlah_tanggungan }} orang</td>
                                </tr>
                                <tr>
                                    <td><strong>Daya Listrik</strong></td>
                                    <td>: {{ $pengajuan->daya_listrik }} VA</td>
                                </tr>
                                <tr>
                                    <td><strong>Tagihan Listrik</strong></td>
                                    <td>: Rp {{ number_format($pengajuan->tagihan_listrik, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tagihan PDAM</strong></td>
                                    <td>: Rp {{ number_format($pengajuan->tagihan_pdam, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>PBB</strong></td>
                                    <td>: Rp {{ number_format($pengajuan->pbb, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Motor</strong></td>
                                    <td>: {{ $pengajuan->jumlah_motor }} unit</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Mobil</strong></td>
                                    <td>: {{ $pengajuan->jumlah_mobil }} unit</td>
                                </tr>
                                <tr>
                                    <td><strong>Kepemilikan Kartu</strong></td>
                                    <td>: {{ $pengajuan->kepemilikan_kartu }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Alasan Pengajuan & Dokumen</h6>
                </div>
                <div class="card-body">
                    <p><strong>Alasan:</strong> {{ $pengajuan->alasan_pengajuan }}</p>

                    @if($pengajuan->pernyataan_teman)
                    <p><strong>Pernyataan Teman:</strong> {{ $pengajuan->pernyataan_teman }}</p>
                    @endif

                    @if($pengajuan->link_drive)
                    <p>
                        <strong>Link Drive:</strong> 
                        <a href="{{ $pengajuan->link_drive }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-external-link-alt"></i> Buka Link
                        </a>
                    </p>
                    @endif
                    
                    <hr>
                    
                    @if($pengajuan->dokumenPendukung->count() > 0)
                        <div class="row">
                            @foreach($pengajuan->dokumenPendukung as $dokumen)
                            <div class="col-md-4 mb-3">
                                <div class="card border h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title mb-0 small font-weight-bold">{{ $dokumen->jenis_label }}</h6>
                                    </div>
                                    <div class="card-body text-center p-2">
                                        <a href="{{ $dokumen->url }}" target="_blank" class="btn btn-sm btn-block btn-primary">
                                            <i class="fas fa-eye"></i> Lihat Dokumen
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning">Tidak ada dokumen pendukung.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Validasi</h6>
                </div>
                <div class="card-body">
                    @if($pengajuan->hasilValidasi->count() > 0)
                        @foreach($pengajuan->hasilValidasi as $validasi)
                        <div class="border-left-primary shadow-sm p-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="font-weight-bold text-primary">{{ $validasi->validator_name }}</h6>
                                    <small class="text-muted d-block mb-2">{{ ucfirst($validasi->validator->role ?? '-') }} • {{ $validasi->created_at->format('d M Y H:i') }}</small>
                                </div>
                            </div>
                            <div class="small">
                                @if($validasi->hasil_wawancara && $validasi->hasil_wawancara != '-')
                                <p class="mb-1"><strong>Catatan/Wawancara:</strong><br>{{ $validasi->hasil_wawancara }}</p>
                                @endif
                                
                                @if($validasi->hasil_score > 0)
                                <p class="mb-1"><strong>Skor:</strong> {{ $validasi->hasil_score }}</p>
                                @endif
                                
                                <p class="mb-1"><strong>Rekomendasi UKT:</strong><br>
                                <span class="text-info font-weight-bold">{{ $validasi->formatted_rekomendasi_ukt }}</span></p>
                                
                                <p class="mb-0">
                                    <strong>Keputusan:</strong>
                                    <span class="badge badge-{{ $validasi->status == 'disetujui' ? 'success' : 'warning' }}">
                                        {{ $validasi->status_label }}
                                    </span>
                                </p>
                                
                                @if($validasi->berlaku_selama)
                                <p class="mt-1 mb-0"><strong>Berlaku:</strong> {{ $validasi->berlaku_selama }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">Belum ada riwayat validasi.</div>
                    @endif
                    
                    @if($pengajuan->status == 'ditolak')
                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-times-circle"></i> Pengajuan ini telah <strong>DITOLAK</strong>.
                        </div>
                    @endif
                </div>
            </div>

            {{-- ===== CARD HASIL SAW DI DETAIL ARSIP ===== --}}
            @php
                $poinKeuanganArsip = $pengajuan->pointPengajuan->where('role', 'keuangan')->first();
                $poinRumahSAW = $poinKeuanganArsip->poin_kondisi_rumah ?? 0;
                
                $allDataset = \App\Models\PengajuanPenurunanUkt::all();

                $minGaji       = $allDataset->map(fn($p) => (float) $p->total_gaji)->where(fn($v) => $v > 0)->min() ?? 500000;
                $maxGaji       = $allDataset->map(fn($p) => (float) $p->total_gaji)->max() ?? 5000000;

                $minTanggungan = $allDataset->map(fn($p) => (int) $p->jumlah_tanggungan)->where(fn($v) => $v > 0)->min() ?? 1;
                $maxTanggungan = $allDataset->map(fn($p) => (int) $p->jumlah_tanggungan)->max() ?? 7;

                $minDaya       = $allDataset->map(fn($p) => (int) $p->daya_listrik)->where(fn($v) => $v > 0)->min() ?? 450;
                $maxDaya       = $allDataset->map(fn($p) => (int) $p->daya_listrik)->max() ?? 2200;

                $minListrik    = $allDataset->map(fn($p) => (float) $p->tagihan_listrik)->where(fn($v) => $v > 0)->min() ?? 20000;
                $maxListrik    = $allDataset->map(fn($p) => (float) $p->tagihan_listrik)->max() ?? 2000000;

                $minPdam       = $allDataset->map(fn($p) => (float) $p->tagihan_pdam)->where(fn($v) => $v > 0)->min() ?? 20000;
                $maxPdam       = $allDataset->map(fn($p) => (float) $p->tagihan_pdam)->max() ?? 1000000;

                $minPbb        = $allDataset->map(fn($p) => (float) $p->pbb)->where(fn($v) => $v > 0)->min() ?? 20000;
                $maxPbb        = $allDataset->map(fn($p) => (float) $p->pbb)->max() ?? 1000000;

                $minMotor      = $allDataset->map(fn($p) => (int) $p->jumlah_motor)->where(fn($v) => $v > 0)->min() ?? 1;
                $maxMotor      = $allDataset->map(fn($p) => (int) $p->jumlah_motor)->max() ?? 5;

                $minMobil      = $allDataset->map(fn($p) => (int) $p->jumlah_mobil)->where(fn($v) => $v > 0)->min() ?? 1;
                $maxMobil      = $allDataset->map(fn($p) => (int) $p->jumlah_mobil)->max() ?? 3;

                $allRumah      = \Illuminate\Support\Facades\DB::table('point_pengajuan')->pluck('poin_kondisi_rumah');
                $minRumah      = $allRumah->where(fn($v) => $v > 0)->min() ?? 10;
                $maxRumah      = $allRumah->max() ?? 80;

                $allKartu      = $allDataset->map(fn($p) => abs($p->poin_kepemilikan_kartu));
                $minKartu      = $allKartu->where(fn($v) => $v > 0)->min() ?? 5;
                $maxKartu      = $allKartu->max() ?? 15;

                $sawCriteria = [
                    ['label'=>'Penghasilan Orang Tua', 'icon'=>'fa-money-bill-wave', 'nilai'=>(float)$pengajuan->total_gaji,          'min'=>$minGaji,       'max'=>$maxGaji,       'bobot'=>0.25, 'tipe'=>'cost',   'display'=>'Rp ' . number_format($pengajuan->total_gaji, 0, ',', '.')],
                    ['label'=>'Jumlah Tanggungan',     'icon'=>'fa-users',          'nilai'=>(int)$pengajuan->jumlah_tanggungan,     'min'=>$minTanggungan, 'max'=>$maxTanggungan, 'bobot'=>0.15, 'tipe'=>'benefit', 'display'=>$pengajuan->jumlah_tanggungan . ' Orang'],
                    ['label'=>'Daya Listrik',           'icon'=>'fa-bolt',           'nilai'=>(int)$pengajuan->daya_listrik,          'min'=>$minDaya,       'max'=>$maxDaya,       'bobot'=>0.08, 'tipe'=>'cost',   'display'=>$pengajuan->daya_listrik . ' VA'],
                    ['label'=>'Tagihan Listrik',        'icon'=>'fa-file-invoice',   'nilai'=>(float)$pengajuan->tagihan_listrik,     'min'=>$minListrik,    'max'=>$maxListrik,    'bobot'=>0.08, 'tipe'=>'cost',   'display'=>'Rp ' . number_format($pengajuan->tagihan_listrik, 0, ',', '.')],
                    ['label'=>'Tagihan PDAM',           'icon'=>'fa-tint',           'nilai'=>(float)$pengajuan->tagihan_pdam,        'min'=>$minPdam,       'max'=>$maxPdam,       'bobot'=>0.05, 'tipe'=>'cost',   'display'=>'Rp ' . number_format($pengajuan->tagihan_pdam, 0, ',', '.')],
                    ['label'=>'PBB',                   'icon'=>'fa-home',           'nilai'=>(float)$pengajuan->pbb,                 'min'=>$minPbb,        'max'=>$maxPbb,        'bobot'=>0.05, 'tipe'=>'cost',   'display'=>'Rp ' . number_format($pengajuan->pbb, 0, ',', '.')],
                    ['label'=>'Jumlah Motor',           'icon'=>'fa-motorcycle',     'nilai'=>(int)$pengajuan->jumlah_motor,          'min'=>$minMotor,      'max'=>$maxMotor,      'bobot'=>0.07, 'tipe'=>'cost',   'display'=>$pengajuan->jumlah_motor . ' Unit'],
                    ['label'=>'Jumlah Mobil',           'icon'=>'fa-car',            'nilai'=>(int)$pengajuan->jumlah_mobil,          'min'=>$minMobil,      'max'=>$maxMobil,      'bobot'=>0.07, 'tipe'=>'cost',   'display'=>$pengajuan->jumlah_mobil . ' Unit'],
                    ['label'=>'Kondisi Rumah',          'icon'=>'fa-house-damage',   'nilai'=>(int)$poinRumahSAW,                     'min'=>$minRumah,      'max'=>$maxRumah,      'bobot'=>0.10, 'tipe'=>'cost',   'display'=>$poinRumahSAW . ' Poin'],
                    ['label'=>'Kepemilikan Kartu',      'icon'=>'fa-id-card',        'nilai'=>(int)abs($pengajuan->poin_kepemilikan_kartu), 'min'=>$minKartu, 'max'=>$maxKartu,      'bobot'=>0.10, 'tipe'=>'benefit', 'display'=>$pengajuan->kepemilikan_kartu],
                ];

                $sawScore = 0;
                foreach ($sawCriteria as &$c) {
                    $cMin = $c['min'];
                    $cMax = $c['max'];
                    $xij  = $c['nilai'];

                    if (strtolower($c['tipe']) === 'benefit') {
                        $c['normalized'] = ($cMax > 0 && $xij > 0) ? round($xij / $cMax, 4) : 0;
                    } else {
                        // ATURAN KHUSUS: Jika nilai asli Xij = 0, maka Rij = 0
                        if ($xij == 0) {
                            $c['normalized'] = 0.0;
                        } else {
                            $c['normalized'] = round($cMin / $xij, 4);
                        }
                    }

                    $c['weighted'] = round($c['normalized'] * $c['bobot'], 4);
                    $sawScore += $c['weighted'];
                }
                unset($c);
                $sawScore = round($sawScore, 4);
                $sawPersen = round($sawScore * 100, 1);

                $uktAwal = (int) ($pengajuan->mahasiswa->ukt_awal ?? 0);

                if ($sawScore >= 0.70) {
                    $rawTariff = 500000;
                    if ($uktAwal > 0 && $rawTariff >= $uktAwal) {
                        $sawLabel = 'Tidak Layak';
                        $sawBadge = 'danger';
                        $sawIcon = 'fa-times-circle';
                        $sawRecStatus = 'UKT Tetap / diangsur';
                        $sawRecTariff = 'UKT Tetap (Tidak Ada Penurunan)';
                    } else {
                        $sawLabel = 'Sangat Layak';
                        $sawBadge = 'success';
                        $sawIcon = 'fa-check-circle';
                        $sawRecStatus = 'Disetujui Penurunan Sampai Lulus';
                        $sawRecTariff = 'Rp ' . number_format($rawTariff, 0, ',', '.');
                    }
                } elseif ($sawScore >= 0.50) {
                    $rawTariff = 2000000;
                    if ($uktAwal > 0 && $rawTariff >= $uktAwal) {
                        $lowerTiers = array_filter([1000000, 500000], fn($t) => $t < $uktAwal);
                        if (!empty($lowerTiers)) {
                            $rawTariff = max($lowerTiers);
                            $sawLabel = 'Layak';
                            $sawBadge = 'primary';
                            $sawIcon = 'fa-thumbs-up';
                            $sawRecStatus = 'Disetujui Penurunan 2 Semester';
                            $sawRecTariff = 'Rp ' . number_format($rawTariff, 0, ',', '.');
                        } else {
                            $sawLabel = 'Tidak Layak';
                            $sawBadge = 'danger';
                            $sawIcon = 'fa-times-circle';
                            $sawRecStatus = 'UKT Tetap / diangsur';
                            $sawRecTariff = 'UKT Tetap (Tidak Ada Penurunan)';
                        }
                    } else {
                        $sawLabel = 'Layak';
                        $sawBadge = 'primary';
                        $sawIcon = 'fa-thumbs-up';
                        $sawRecStatus = 'Disetujui Penurunan 2 Semester';
                        $sawRecTariff = 'Rp ' . number_format($rawTariff, 0, ',', '.');
                    }
                } elseif ($sawScore >= 0.30) {
                    $rawTariff = 3000000;
                    if ($uktAwal > 0 && $rawTariff >= $uktAwal) {
                        $lowerTiers = array_filter([2000000, 1000000, 500000], fn($t) => $t < $uktAwal);
                        if (!empty($lowerTiers)) {
                            $rawTariff = max($lowerTiers);
                            $sawLabel = 'Kurang Layak';
                            $sawBadge = 'warning';
                            $sawIcon = 'fa-exclamation-circle';
                            $sawRecStatus = 'Disetujui Penurunan 1 Semester';
                            $sawRecTariff = 'Rp ' . number_format($rawTariff, 0, ',', '.');
                        } else {
                            $sawLabel = 'Tidak Layak';
                            $sawBadge = 'danger';
                            $sawIcon = 'fa-times-circle';
                            $sawRecStatus = 'UKT Tetap / diangsur';
                            $sawRecTariff = 'UKT Tetap (Tidak Ada Penurunan)';
                        }
                    } else {
                        $sawLabel = 'Kurang Layak';
                        $sawBadge = 'warning';
                        $sawIcon = 'fa-exclamation-circle';
                        $sawRecStatus = 'Disetujui Penurunan 1 Semester';
                        $sawRecTariff = 'Rp ' . number_format($rawTariff, 0, ',', '.');
                    }
                } else {
                    $sawLabel = 'Tidak Layak';
                    $sawBadge = 'danger';
                    $sawIcon = 'fa-times-circle';
                    $sawRecStatus = 'UKT Tetap / diangsur';
                    $sawRecTariff = 'UKT Tetap (Tidak Ada Penurunan)';
                }
            @endphp

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-calculator"></i> Hasil Perhitungan SAW
                        <small class="text-muted font-weight-normal">(Simple Additive Weighting)</small>
                    </h6>
                    <span class="badge badge-{{ $sawBadge }} px-3 py-2">
                        <i class="fas {{ $sawIcon }}"></i> {{ $sawLabel }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h3 class="font-weight-bold text-{{ $sawBadge }}">{{ $sawPersen }}%</h3>
                        <div class="progress" style="height: 18px; border-radius: 9px;">
                            <div class="progress-bar bg-{{ $sawBadge }} progress-bar-striped"
                                 role="progressbar"
                                 style="width: {{ $sawPersen }}%;"
                                 aria-valuenow="{{ $sawPersen }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $sawPersen }}%
                            </div>
                        </div>
                        <small class="text-muted mt-1 d-block">Skor akhir SAW: <strong>{{ number_format($sawScore, 4) }}</strong> / 1.00</small>
                    </div>

                    <hr>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered small">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>Kriteria</th>
                                    <th>Nilai (X<sub>ij</sub>)</th>
                                    <th>Bobot (W<sub>j</sub>)</th>
                                    <th>Hasil Normalisasi (R<sub>ij</sub>)</th>
                                    <th>Nilai Terbobot (R<sub>ij</sub> &times; W<sub>j</sub>)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sawCriteria as $c)
                                <tr class="text-center">
                                    <td class="text-left"><i class="fas {{ $c['icon'] }} text-muted mr-1"></i> {{ $c['label'] }}</td>
                                    <td>{{ $c['display'] }}</td>
                                    <td>{{ number_format($c['bobot'] * 100, 0) }}%</td>
                                    <td>
                                        <span class="badge badge-{{ $c['normalized'] >= 0.5 ? 'success' : ($c['normalized'] >= 0.25 ? 'warning' : 'danger') }}">
                                            {{ number_format($c['normalized'], 4) }}
                                        </span>
                                    </td>
                                    <td><strong>{{ number_format($c['weighted'], 4) }}</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-info">
                                <tr class="text-center font-weight-bold">
                                    <td colspan="4" class="text-right">Nilai Akhir Preferensi SAW (V<sub>i</sub>)</td>
                                    <td>{{ number_format($sawScore, 4) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="alert alert-info mt-3 border-left-info shadow-sm">
                        <h6 class="font-weight-bold text-info"><i class="fas fa-magic"></i> Rekomendasi Hasil Perhitungan SAW:</h6>
                        <hr class="my-2">
                        <div class="row">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <small class="text-muted d-block font-weight-bold">Rekomendasi Keputusan:</small>
                                <span class="h6 font-weight-bold text-dark">{{ $sawRecStatus }}</span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block font-weight-bold">Rekomendasi Tarif UKT Baru:</small>
                                <span class="h6 font-weight-bold text-success">{{ $sawRecTariff }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
