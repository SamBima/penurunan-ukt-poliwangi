@extends('dashboard.layout.master')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Riwayat Pengajuan Penurunan UKT</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('riwayat-pengajuan') }}">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">-- Semua Status --</option>
                                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Menunggu Persetujuan Keuangan</option>
                                <option value="diterima_keuangan" {{ request('status') == 'diterima_keuangan' ? 'selected' : '' }}>Disetujui Keuangan</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak Keuangan</option>
                                <option value="dinilai_admin" {{ request('status') == 'dinilai_admin' ? 'selected' : '' }}>Divalidasi Admin</option>
                                <option value="dinilai_keuangan" {{ request('status') == 'dinilai_keuangan' ? 'selected' : '' }}>Dinilai Keuangan</option>
                                <option value="dinilai_wadir" {{ request('status') == 'dinilai_wadir' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">Kode Pengajuan</label>
                            <input type="text" name="search" id="search" class="form-control"
                                   value="{{ request('search') }}" placeholder="Masukkan kode...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('riwayat-pengajuan') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($pengajuans->count() > 0)
        @foreach($pengajuans as $pengajuan)
            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-file-alt"></i> {{ $pengajuan->kode }}
                        </h6>
                        @php
                            $statusInfo = [
                                'diajukan' => ['class' => 'warning', 'text' => 'Menunggu Persetujuan Keuangan'],
                                'diterima_keuangan' => ['class' => 'info', 'text' => 'Disetujui Keuangan'],
                                'ditolak' => ['class' => 'danger', 'text' => 'Ditolak Keuangan'],
                                'dinilai_admin' => ['class' => 'info', 'text' => 'Divalidasi Admin'],
                                'dinilai_keuangan' => ['class' => 'info', 'text' => 'Dinilai Keuangan'],
                                'dinilai_wadir' => ['class' => 'success', 'text' => 'Selesai']
                            ];
                            $currentStatus = $statusInfo[$pengajuan->status] ?? ['class' => 'secondary', 'text' => $pengajuan->status];
                        @endphp
                        <span class="badge badge-{{ $currentStatus['class'] }} badge-pill">
                            {{ $currentStatus['text'] }}
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <small class="text-muted d-block">Tanggal Pengajuan</small>
                                <strong>{{ $pengajuan->created_at->format('d M Y, H:i') }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">UKT Saat Ini</small>
                                <strong class="text-danger">Rp {{ number_format($pengajuan->mahasiswa->ukt_awal ?? 0, 0, ',', '.') }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Total Penghasilan Keluarga</small>
                                <strong>Rp {{ number_format($pengajuan->total_gaji, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <div class="progress-wrapper mb-4">
                            <h6 class="text-primary mb-3"><i class="fas fa-tasks"></i> Status Proses</h6>

                            @php
                                $steps = [
                                    ['key' => 'diajukan', 'label' => 'Pengajuan', 'icon' => 'file-alt'],
                                    ['key' => 'diterima_keuangan', 'label' => 'Verifikasi Keuangan', 'icon' => 'check-circle'],
                                    ['key' => 'dinilai_admin', 'label' => 'Divalidasi Admin', 'icon' => 'user-tie'],
                                    ['key' => 'dinilai_keuangan', 'label' => 'Penilaian Keuangan', 'icon' => 'calculator'],
                                    ['key' => 'dinilai_wadir', 'label' => 'Keputusan Wadir', 'icon' => 'gavel']
                                ];

                                $statusIndex = array_search($pengajuan->status, array_column($steps, 'key'));
                                $isDitolak = $pengajuan->status === 'ditolak';
                                
                                // Logika Hybrid untuk Visualisasi Timeline
                                $visualActiveIndex = $statusIndex;
                                if ($pengajuan->status === 'dinilai_admin') {
                                    $visualActiveIndex = 3; // Loncat ke Penilaian Keuangan (Active)
                                } elseif ($pengajuan->status === 'dinilai_keuangan') {
                                    $visualActiveIndex = 4; // Loncat ke Keputusan Wadir (Active)
                                } elseif ($pengajuan->status === 'dinilai_wadir') {
                                    $visualActiveIndex = 5; // Semua Selesai (Hijau)
                                }
                            @endphp

                            @if($isDitolak)
                                <div class="alert alert-danger">
                                    <i class="fas fa-times-circle"></i> <strong>Pengajuan Ditolak oleh Keuangan</strong>
                                    <p class="mb-0 mt-2">Pengajuan Anda tidak dapat diproses lebih lanjut.</p>
                                </div>
                            @else
                                <div class="timeline-progress">
                                    @foreach($steps as $index => $step)
                                        @php
                                            $isCompleted = $visualActiveIndex !== false && $index < $visualActiveIndex;
                                            $isCurrent = $index === $visualActiveIndex;
                                        @endphp

                                        <div class="timeline-step {{ $isCompleted ? 'completed' : '' }} {{ $isCurrent ? 'current' : '' }}">
                                            <div class="step-icon">
                                                @if($isCompleted)
                                                    <i class="fas fa-check"></i>
                                                @else
                                                    <i class="fas fa-{{ $step['icon'] }}"></i>
                                                @endif
                                            </div>
                                            <div class="step-label">{{ $step['label'] }}</div>
                                        </div>

                                        @if($index < count($steps) - 1)
                                            <div class="step-connector {{ $isCompleted ? 'completed' : '' }}"></div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        @if($pengajuan->status === 'dinilai_wadir')
                            @php
                                $hasilWadir = $pengajuan->hasilValidasi->where('validator.role', 'wadir')->first();
                            @endphp

                            @if($hasilWadir)
                                <div class="alert alert-{{ $hasilWadir->status === 'disetujui' ? 'success' : 'warning' }} mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-2">
                                                <i class="fas fa-{{ $hasilWadir->status === 'disetujui' ? 'check-circle' : 'info-circle' }}"></i>
                                                <strong>Hasil Keputusan: {{ $hasilWadir->status === 'disetujui' ? 'DISETUJUI' : 'DISETUJUI DENGAN CICILAN' }}</strong>
                                            </h6>
                                            <div class="row mt-3">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">UKT Baru</small>
                                                    <strong class="text-success h5">Rp {{ number_format($hasilWadir->rekomendasi_ukt, 0, ',', '.') }}</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Berlaku Selama</small>
                                                    <strong>{{ $hasilWadir->berlaku_selama ?? '-' }}</strong>
                                                </div>
                                            </div>
                                            @if($hasilWadir->status === 'disarankan_cicilan')
                                                <div class="mt-2">
                                                    <span class="badge badge-warning badge-lg">
                                                        <i class="fas fa-exclamation-triangle"></i> Pembayaran dengan sistem cicilan
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <div class="savings-info">
                                                <small class="text-muted d-block">Penghematan per Semester</small>
                                                @php
                                                    $penghematan = ($pengajuan->mahasiswa->ukt_awal ?? 0) - $hasilWadir->rekomendasi_ukt;
                                                @endphp
                                                <h4 class="text-success mb-0">
                                                    Rp {{ number_format($penghematan, 0, ',', '.') }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info mb-3">
                                    <i class="fas fa-info-circle"></i> Menunggu keputusan Wadir
                                </div>
                            @endif
                        @elseif(in_array($pengajuan->status, ['dinilai_admin', 'dinilai_keuangan']))
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-clock"></i> <strong>Pengajuan sedang dalam proses penilaian</strong>
                                <p class="mb-0 mt-2 small">Mohon menunggu hingga proses penilaian selesai untuk melihat hasil keputusan.</p>
                            </div>
                        @elseif($pengajuan->status === 'diterima_keuangan')
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-check-circle"></i> <strong>Pengajuan telah disetujui oleh Keuangan</strong>
                                <p class="mb-0 mt-2 small">Pengajuan Anda akan segera diproses oleh Kajur.</p>
                            </div>
                        @elseif($pengajuan->status === 'diajukan')
                            <div class="alert alert-warning mb-3">
                                <i class="fas fa-hourglass-half"></i> <strong>Menunggu Persetujuan Keuangan</strong>
                                <p class="mb-0 mt-2 small">Pengajuan Anda sedang menunggu verifikasi dari bagian Keuangan.</p>
                            </div>
                        @endif

                        <div class="mt-3">
                            <h6 class="text-primary mb-2"><i class="fas fa-comment-alt"></i> Alasan Pengajuan</h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0">{{ Str::limit($pengajuan->alasan_pengajuan, 150) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> Terakhir diupdate: {{ $pengajuan->updated_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" class="btn btn-primary btn-sm"
                                        data-toggle="modal" data-target="#detailModal{{ $pengajuan->id }}">
                                    <i class="fas fa-eye"></i> Lihat Detail Lengkap
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="detailModal{{ $pengajuan->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Pengajuan - {{ $pengajuan->kode }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-primary border-bottom pb-2"><i class="fas fa-users"></i> Data Orang Tua</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="45%">Pekerjaan Ayah</td>
                                            <td><strong>{{ $pengajuan->pekerjaan_ayah }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Penghasilan Ayah</td>
                                            <td><strong>Rp {{ number_format($pengajuan->penghasilan_ayah, 0, ',', '.') }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Pekerjaan Ibu</td>
                                            <td><strong>{{ $pengajuan->pekerjaan_ibu }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Penghasilan Ibu</td>
                                            <td><strong>Rp {{ number_format($pengajuan->penghasilan_ibu, 0, ',', '.') }}</strong></td>
                                        </tr>
                                        <tr class="border-top">
                                            <td>Total Penghasilan</td>
                                            <td><strong class="text-primary">Rp {{ number_format($pengajuan->total_gaji, 0, ',', '.') }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Tanggungan</td>
                                            <td><strong>{{ $pengajuan->jumlah_tanggungan }} orang</strong></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="text-primary border-bottom pb-2"><i class="fas fa-home"></i> Data Rumah & Utilities</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="45%">Daya Listrik</td>
                                            <td><strong>{{ number_format($pengajuan->daya_listrik) }} Watt</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tagihan Listrik</td>
                                            <td><strong>Rp {{ number_format($pengajuan->tagihan_listrik, 0, ',', '.') }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tagihan PDAM</td>
                                            <td><strong>Rp {{ number_format($pengajuan->tagihan_pdam, 0, ',', '.') }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>PBB</td>
                                            <td><strong>Rp {{ number_format($pengajuan->pbb, 0, ',', '.') }}</strong></td>
                                        </tr>
                                        <tr class="border-top">
                                            <td>Jumlah Motor</td>
                                            <td><strong><i class="fas fa-motorcycle text-primary"></i> {{ $pengajuan->jumlah_motor }} unit</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Mobil</td>
                                            <td><strong><i class="fas fa-car text-success"></i> {{ $pengajuan->jumlah_mobil }} unit</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="text-primary border-bottom pb-2"><i class="fas fa-id-card"></i> Data Tambahan</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Kepemilikan Kartu Bantuan:</strong>
                                                <span class="badge badge-{{ $pengajuan->kepemilikan_kartu != 'Tidak Ada' ? 'success' : 'secondary' }}">
                                                    {{ $pengajuan->kepemilikan_kartu }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Pernyataan Teman:</strong>
                                                <span class="badge badge-{{ $pengajuan->pernyataan_teman == 'Ada' ? 'success' : 'secondary' }}">
                                                    {{ $pengajuan->pernyataan_teman }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <p><strong>Alasan Pengajuan:</strong></p>
                                    <div class="bg-light p-3 rounded">{{ $pengajuan->alasan_pengajuan }}</div>
                                </div>
                            </div>

                            @if($pengajuan->hasilValidasi->count() > 0)
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="text-primary border-bottom pb-2"><i class="fas fa-clipboard-check"></i> Hasil Penilaian</h6>

                                        @foreach(['admin' => 'Kajur', 'keuangan' => 'Keuangan', 'wadir' => 'Wadir'] as $role => $label)
                                            @php
                                                $hasil = $pengajuan->hasilValidasi->where('validator.role', $role)->first();
                                                $poin = $pengajuan->pointPengajuan->where('role', $role)->first();
                                            @endphp

                                            @if($hasil)
                                                <div class="card mb-3">
                                                    <div class="card-header bg-light">
                                                        <strong>Penilaian {{ $label }}</strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <p class="mb-1"><strong>Total Poin:</strong> {{ $hasil->hasil_score }}</p>
                                                                <p class="mb-1"><strong>Rekomendasi UKT:</strong> Rp {{ number_format($hasil->rekomendasi_ukt, 0, ',', '.') }}</p>
                                                                <p class="mb-1"><strong>Status:</strong>
                                                                    <span class="badge badge-{{ $hasil->status === 'disetujui' ? 'success' : 'warning' }}">
                                                                        {{ $hasil->status === 'disetujui' ? 'Disetujui' : 'Disetujui dengan Cicilan' }}
                                                                    </span>
                                                                </p>
                                                                @if($role === 'wadir' && $hasil->berlaku_selama)
                                                                    <p class="mb-1"><strong>Berlaku Selama:</strong> {{ $hasil->berlaku_selama }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-8">
                                                                @if($hasil->hasil_wawancara && $hasil->hasil_wawancara !== '-')
                                                                    <p class="mb-1"><strong>Hasil Wawancara:</strong></p>
                                                                    <div class="bg-light p-2 rounded">{{ $hasil->hasil_wawancara }}</div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        @if($poin)
                                                            <hr>
                                                            <p class="mb-2"><strong>Detail Poin:</strong></p>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <small>• Penghasilan Orang Tua: {{ $poin->poin_penghasilan_ortu }}</small><br>
                                                                    <small>• Tagihan: {{ $poin->poin_tagihan }}</small><br>
                                                                    <small>• Kepemilikan: {{ $poin->poin_kepemilikan }}</small><br>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <small>• Kondisi Rumah: {{ $poin->poin_kondisi_rumah }}</small><br>
                                                                    <small>• Kartu Bantuan: {{ $poin->poin_kartu_bantuan }}</small><br>
                                                                    <small>• Pernyataan Teman: {{ $poin->poin_pernyataan_teman }}</small><br>
                                                                    @if($role === 'keuangan')
                                                                        <small>• Jumlah Tanggungan: {{ $poin->poin_jumlah_tanggungan ?? 0 }}</small><br>
                                                                        <small>• Daya Listrik: {{ $poin->poin_daya_listrik ?? 0 }}</small><br>
                                                                        <small>• PBB: {{ $poin->poin_pbb ?? 0 }}</small><br>
                                                                        <small>• Wawancara: {{ $poin->poin_wawancara ?? 0 }}</small><br>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($pengajuan->dokumenPendukung->count() > 0)
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="text-primary border-bottom pb-2"><i class="fas fa-paperclip"></i> Dokumen Pendukung</h6>
                                        <div class="row">
                                            @foreach($pengajuan->dokumenPendukung as $dokumen)
                                                <div class="col-md-3 mb-3">
                                                    <div class="card h-100">
                                                        <div class="card-body text-center">
                                                            <i class="fas fa-file-alt fa-3x text-primary mb-2"></i>
                                                            <h6 class="card-title">{{ $dokumen->jenis_label }}</h6>
                                                            @if($dokumen->keterangan)
                                                                <small class="text-muted">{{ $dokumen->keterangan }}</small>
                                                            @endif
                                                            <div class="mt-2">
                                                                <a href="{{ $dokumen->url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-download"></i> Download
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($pengajuan->link_drive)
                                            <a href="{{ $pengajuan->link_drive }}" target="_blank" class="btn btn-info">
                                                <i class="fab fa-google-drive"></i> Lihat Semua Dokumen di Google Drive
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-muted mb-0">
                    Menampilkan {{ $pengajuans->firstItem() ?? 0 }} - {{ $pengajuans->lastItem() ?? 0 }}
                    dari {{ $pengajuans->total() }} pengajuan
                </p>
                {{ $pengajuans->links() }}
            </div>
        </div>
    @else
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox text-gray-300" style="font-size: 5rem;"></i>
                    <h5 class="text-gray-600 mt-3 mb-2">Belum Ada Pengajuan</h5>
                    <p class="text-gray-500 mb-4">
                        @if(request()->hasAny(['status', 'search']))
                            Tidak ada pengajuan yang sesuai dengan filter yang dipilih.
                        @else
                            Anda belum pernah mengajukan penurunan UKT.
                        @endif
                    </p>
                    @if(request()->hasAny(['status', 'search']))
                        <a href="{{ route('riwayat-pengajuan') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset Filter
                        </a>
                    @else
                        <a href="{{ route('pengajuan') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Buat Pengajuan Baru
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.timeline-progress {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 0;
}

.timeline-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    flex: 1;
}

.step-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 10px;
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
}

.timeline-step.completed .step-icon {
    background: #28a745;
    color: white;
    border-color: #28a745;
}

.timeline-step.current .step-icon {
    background: #007bff;
    color: white;
    border-color: #007bff;
    animation: pulse 2s infinite;
}

.step-label {
    font-size: 12px;
    text-align: center;
    color: #6c757d;
    font-weight: 500;
}

.timeline-step.completed .step-label,
.timeline-step.current .step-label {
    color: #495057;
    font-weight: 600;
}

.step-connector {
    height: 3px;
    background: #e9ecef;
    flex: 1;
    margin: 0 -10px;
    position: relative;
    top: -10px;
}

.step-connector.completed {
    background: #28a745;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
    }
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.savings-info {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    padding: 15px;
    border-radius: 10px;
    border: 2px solid #28a745;
}

@media (max-width: 768px) {
    .timeline-progress {
        flex-direction: column;
    }

    .step-connector {
        display: none;
    }

    .timeline-step {
        margin-bottom: 15px;
    }

    .step-icon {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
}

.badge-pill {
    padding: 8px 15px;
    font-size: 13px;
    font-weight: 600;
}

.alert {
    border-left: 4px solid;
}

.alert-success {
    border-left-color: #28a745;
}

.alert-warning {
    border-left-color: #ffc107;
}

.alert-danger {
    border-left-color: #dc3545;
}

.modal-xl {
    max-width: 1200px;
}

.modal-body {
    max-height: 70vh;
    overflow-y: auto;
}

.table-borderless td {
    padding: 8px 5px;
}

.table-borderless tr:hover {
    background-color: #f8f9fa;
}

.card h-100 {
    height: 100%;
}

.progress-wrapper {
    background: #f8f9fc;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #e3e6f0;
}

.card-header.bg-light {
    background-color: #f8f9fc !important;
    border-bottom: 2px solid #e3e6f0;
}

html {
    scroll-behavior: smooth;
}

.btn:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

.pagination {
    margin-bottom: 0;
}

.page-link {
    color: #007bff;
}

.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}

.fa-inbox {
    opacity: 0.3;
}

.border-bottom {
    border-bottom: 2px solid #e3e6f0 !important;
}

.text-truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.badge {
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.05);
}

.card-footer.bg-white {
    background-color: #fff !important;
    border-top: 1px solid #e3e6f0;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-group .btn {
    margin-right: 5px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

[data-toggle="tooltip"] {
    cursor: help;
}

@media print {
    .card-footer,
    .modal-footer,
    .btn,
    .no-print {
        display: none !important;
    }

    .card {
        box-shadow: none !important;
        border: 1px solid #dee2e6 !important;
    }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading {
    animation: spin 1s linear infinite;
}

.modal-body::-webkit-scrollbar {
    width: 8px;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.modal').on('show.bs.modal', function() {
        $(this).find('.modal-body').scrollTop(0);
    });

    $('form').on('submit', function() {
        var btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
    });

    var formChanged = false;
    $('input, select, textarea').on('change', function() {
        formChanged = true;
    });

    $(window).on('beforeunload', function() {
        if (formChanged) {
            return 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
        }
    });

    $('form').on('submit', function() {
        formChanged = false;
    });
});

function printModal(modalId) {
    var content = document.querySelector('#' + modalId + ' .modal-body').innerHTML;
    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
    printWindow.document.write('</head><body>');
    printWindow.document.write(content);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection
