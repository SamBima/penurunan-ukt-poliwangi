@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Arsip Pengajuan</h1>
        <a href="{{ route('arsip-pengajuan') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Arsip
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
        </div>
    </div>
</div>
@endsection
