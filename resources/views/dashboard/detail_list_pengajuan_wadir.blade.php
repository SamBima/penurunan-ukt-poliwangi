@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengajuan Penurunan UKT</h1>
        @php
            $backUrl = (request('source') === 'arsip') ? route('arsip-pengajuan') : route('list-pengajuan');
        @endphp
        <a href="{{ $backUrl }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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
                                    <td><strong>Status</strong></td>
                                    <td>: <span class="badge badge-info">{{ $pengajuan->status_label }}</span></td>
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
                    <h6 class="m-0 font-weight-bold text-primary">Alasan Pengajuan</h6>
                </div>
                <div class="card-body">
                    <p>{{ $pengajuan->alasan_pengajuan }}</p>

                    @if($pengajuan->pernyataan_teman)
                    <hr>
                    <h6><strong>Pernyataan Teman:</strong></h6>
                    <p>{{ $pengajuan->pernyataan_teman }}</p>
                    @endif

                    @if($pengajuan->link_drive)
                    <hr>
                    <h6><strong>Link Drive:</strong></h6>
                    <a href="{{ $pengajuan->link_drive }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-external-link-alt"></i> Buka Link Drive
                    </a>
                    @endif
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dokumen Pendukung</h6>
                </div>
                <div class="card-body">
                    @if($pengajuan->dokumenPendukung->count() > 0)
                        <div class="row">
                            @foreach($pengajuan->dokumenPendukung as $dokumen)
                            <div class="col-md-4 mb-3">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title mb-0">{{ $dokumen->jenis_label }}</h6>
                                        <small class="text-muted">{{ $dokumen->file_size }}</small>
                                    </div>
                                    <div class="card-body text-center">
                                        @if($dokumen->isImage())
                                            <img src="{{ $dokumen->url }}" class="img-fluid mb-2" style="max-height: 150px;">
                                        @elseif($dokumen->isPdf())
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                        @else
                                            <i class="fas fa-file fa-3x text-secondary mb-2"></i>
                                        @endif
                                        <br>
                                        <a href="{{ $dokumen->url }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </div>
                                    @if($dokumen->keterangan)
                                    <div class="card-footer">
                                        <small>{{ $dokumen->keterangan }}</small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Tidak ada dokumen pendukung yang diupload.
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Keputusan Akhir</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('list-pengajuan.validasi', $pengajuan->kode) }}" method="POST" id="validasiForm">
                        @csrf
                        <input type="hidden" name="pengajuan_id" value="{{ $pengajuan->id }}">

                        <div class="form-group">
                            <label for="status"><strong>Keputusan Akhir</strong></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">Pilih Keputusan</option>
                                <option value="disetujui|1 Semester">Disetujui Penurunan 1 Semester</option>
                                <option value="disetujui|2 Semester">Disetujui Penurunan 2 Semester</option>
                                <option value="disetujui|3 Semester">Disetujui Penurunan 3 Semester</option>
                                <option value="disetujui|4 Semester">Disetujui Penurunan 4 Semester</option>
                                <option value="disetujui|Sampai Lulus">Disetujui Sampai Lulus</option>
                                <option value="disarankan_cicilan|1 Semester">UKT tetap / diangsur</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="rekomendasi_ukt"><strong>Keputusan Penurunan Tarif UKT</strong></label>
                            <select class="form-control" id="rekomendasi_ukt" name="rekomendasi_ukt" required>
                                <option value="">Pilih Tarif UKT</option>
                                <option value="0">UKT Tetap (Tidak Ada Penurunan)</option>
                                <option value="500000">500.000</option>
                                <option value="1000000">1.000.000</option>
                                <option value="2000000">2.000.000</option>
                                <option value="3000000">3.000.000</option>
                                <option value="4000000">4.000.000</option>
                                <option value="5000000">5.000.000</option>
                                <option value="6000000">6.000.000</option>
                                <option value="7000000">7.000.000</option>
                            </select>
                        </div>

                        <div class="alert alert-warning">
                            <small>
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Perhatian:</strong><br>
                                Keputusan ini akan menjadi keputusan final untuk pengajuan penurunan UKT. Pastikan semua informasi sudah benar sebelum menyimpan.
                            </small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-check-circle"></i> Simpan Keputusan Akhir
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if($pengajuan->hasilValidasi->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Rekomendasi</h6>
                </div>
                <div class="card-body">
                    @foreach($pengajuan->hasilValidasi as $validasi)
                    <div class="card shadow-sm border-left-primary mb-3">
                        <div class="card-body p-3">
                            <h6 class="font-weight-bold mb-1" style="color: #2e3d55;">{{ $validasi->validator_name }}</h6>
                            <small class="text-muted d-block mb-2">{{ $validasi->validator_role }} • {{ $validasi->created_at->format('d M Y H:i') }}</small>
                            <hr class="my-2">
                            <p class="mb-1 text-dark"><strong>Wawancara:</strong> {{ $validasi->hasil_wawancara ?? '-' }}</p>
                            <p class="mb-1 text-dark"><strong>Rekomendasi UKT:</strong> {{ $validasi->formatted_rekomendasi_ukt }}</p>
                            <p class="mb-1 text-dark">
                                <strong>Status:</strong>
                                <span class="badge badge-{{ $validasi->status === 'disetujui' ? 'success' : 'warning' }} px-2 py-1 font-weight-bold">
                                    {{ $validasi->status_label }}
                                </span>
                            </p>
                            @if($validasi->persentase_penurunan > 0)
                            <p class="text-success font-weight-bold mb-0 mt-1 small">
                                <i class="fas fa-arrow-down text-success"></i> Penurunan {{ $validasi->formatted_persentase_penurunan }}
                            </p>
                            @endif
                        </div>
                    </div>

                    @if($validasi->validator && $validasi->validator->role === 'keuangan')
                        @php
                            $poinRumahSAW = $poinKeuangan->poin_kondisi_rumah ?? 0;
                            
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
                                ['label'=>'Penghasilan Orang Tua', 'icon'=>'fa-money-bill-wave', 'nilai'=>(float)$pengajuan->total_gaji,          'min'=>$minGaji,       'max'=>$maxGaji,       'bobot'=>0.25, 'tipe'=>'cost'],
                                ['label'=>'Jumlah Tanggungan',     'icon'=>'fa-users',          'nilai'=>(int)$pengajuan->jumlah_tanggungan,     'min'=>$minTanggungan, 'max'=>$maxTanggungan, 'bobot'=>0.15, 'tipe'=>'benefit'],
                                ['label'=>'Daya Listrik',           'icon'=>'fa-bolt',           'nilai'=>(int)$pengajuan->daya_listrik,          'min'=>$minDaya,       'max'=>$maxDaya,       'bobot'=>0.08, 'tipe'=>'cost'],
                                ['label'=>'Tagihan Listrik',        'icon'=>'fa-file-invoice',   'nilai'=>(float)$pengajuan->tagihan_listrik,     'min'=>$minListrik,    'max'=>$maxListrik,    'bobot'=>0.08, 'tipe'=>'cost'],
                                ['label'=>'Tagihan PDAM',           'icon'=>'fa-tint',           'nilai'=>(float)$pengajuan->tagihan_pdam,        'min'=>$minPdam,       'max'=>$maxPdam,       'bobot'=>0.05, 'tipe'=>'cost'],
                                ['label'=>'PBB',                   'icon'=>'fa-home',           'nilai'=>(float)$pengajuan->pbb,                 'min'=>$minPbb,        'max'=>$maxPbb,        'bobot'=>0.05, 'tipe'=>'cost'],
                                ['label'=>'Jumlah Motor',           'icon'=>'fa-motorcycle',     'nilai'=>(int)$pengajuan->jumlah_motor,          'min'=>$minMotor,      'max'=>$maxMotor,      'bobot'=>0.07, 'tipe'=>'cost'],
                                ['label'=>'Jumlah Mobil',           'icon'=>'fa-car',            'nilai'=>(int)$pengajuan->jumlah_mobil,          'min'=>$minMobil,      'max'=>$maxMobil,      'bobot'=>0.07, 'tipe'=>'cost'],
                                ['label'=>'Kondisi Rumah',          'icon'=>'fa-house-damage',   'nilai'=>(int)$poinRumahSAW,                     'min'=>$minRumah,      'max'=>$maxRumah,      'bobot'=>0.10, 'tipe'=>'cost'],
                                ['label'=>'Kepemilikan Kartu',      'icon'=>'fa-id-card',        'nilai'=>(int)abs($pengajuan->poin_kepemilikan_kartu), 'min'=>$minKartu, 'max'=>$maxKartu,      'bobot'=>0.10, 'tipe'=>'benefit'],
                            ];

                            $sawScore = 0;
                            foreach ($sawCriteria as $c) {
                                $cMin = $c['min'];
                                $cMax = $c['max'];
                                $xij  = $c['nilai'];

                                if (strtolower($c['tipe']) === 'benefit') {
                                    // Rumus Benefit: Rij = Xij / max(Xj)
                                    $norm = ($cMax > 0 && $xij > 0) ? round($xij / $cMax, 4) : 0;
                                } else {
                                    // Rumus Cost: Rij = min(Xj) / Xij
                                    // ATURAN KHUSUS: Jika nilai asli Xij = 0, maka Rij = 0
                                    if ($xij == 0) {
                                        $norm = 0.0;
                                    } else {
                                        $norm = round($cMin / $xij, 4);
                                    }
                                }
                                $sawScore += round($norm * $c['bobot'], 4);
                            }
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
                        
                        <div class="card shadow-sm border-left-info mb-3">
                            <div class="card-body p-3">
                                <h6 class="font-weight-bold mb-2 text-info"><i class="fas fa-calculator text-info mr-1"></i> Rekomendasi Hasil Perhitungan SAW</h6>
                                <div class="text-center mb-3">
                                    <h4 class="font-weight-bold text-{{ $sawBadge }} mb-1">{{ $sawPersen }}% ({{ $sawLabel }})</h4>
                                    <div class="progress mb-2" style="height: 12px; border-radius: 6px;">
                                        <div class="progress-bar bg-{{ $sawBadge }} progress-bar-striped progress-bar-animated"
                                             role="progressbar"
                                             style="width: {{ $sawPersen }}%;"
                                             aria-valuenow="{{ $sawPersen }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <small class="text-muted">Skor SAW: <strong>{{ $sawScore }}</strong> / 1.00</small>
                                </div>
                                <div class="alert alert-info py-2 px-3 mb-0 small">
                                    <div class="row">
                                        <div class="col-6 border-right">
                                            <span class="text-muted d-block font-weight-bold mb-1">Rekomendasi Keputusan:</span>
                                            <span class="font-weight-bold text-dark">{{ $sawRecStatus }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="text-muted d-block font-weight-bold mb-1">Rekomendasi Tarif UKT:</span>
                                            <span class="font-weight-bold text-success">{{ $sawRecTariff }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
