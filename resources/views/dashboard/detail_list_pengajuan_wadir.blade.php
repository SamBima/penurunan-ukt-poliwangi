@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengajuan Penurunan UKT</h1>
        <a href="{{ route('list-pengajuan') }}" class="btn btn-secondary">
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

            @if($poinAdmin)
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">Penilaian Kajur</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Penghasilan Orang Tua:</strong> {{ $poinAdmin->poin_penghasilan_ortu }} poin</p>
                            <p class="mb-1"><strong>Tagihan Bulanan:</strong> {{ $poinAdmin->poin_tagihan }} poin</p>
                            <p class="mb-1"><strong>Kepemilikan Kendaraan:</strong> {{ $poinAdmin->poin_kepemilikan }} poin</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Kondisi Rumah:</strong> {{ $poinAdmin->poin_kondisi_rumah }} poin</p>
                            <p class="mb-1"><strong>Kartu Bantuan:</strong> {{ $poinAdmin->poin_kartu_bantuan }} poin</p>
                            <p class="mb-1"><strong>Pernyataan Teman:</strong> {{ $poinAdmin->poin_pernyataan_teman }} poin</p>
                        </div>
                    </div>
                    <hr>
                    <h5 class="text-success"><strong>Total Poin Kajur: {{ $poinAdmin->total_poin }}</strong></h5>
                    <small class="text-muted">Dinilai oleh: {{ $poinAdmin->user->name }} pada {{ $poinAdmin->created_at->format('d M Y H:i') }}</small>
                </div>
            </div>
            @endif

            @if($poinKeuangan)
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">Penilaian Keuangan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Penghasilan Orang Tua:</strong> {{ $poinKeuangan->poin_penghasilan_ortu }} poin</p>
                            <p class="mb-1"><strong>Tagihan Bulanan:</strong> {{ $poinKeuangan->poin_tagihan }} poin</p>
                            <p class="mb-1"><strong>Kepemilikan Kendaraan:</strong> {{ $poinKeuangan->poin_kepemilikan }} poin</p>
                            <p class="mb-1"><strong>Kondisi Rumah:</strong> {{ $poinKeuangan->poin_kondisi_rumah }} poin</p>
                            <p class="mb-1"><strong>Kartu Bantuan:</strong> {{ $poinKeuangan->poin_kartu_bantuan }} poin</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Pernyataan Teman:</strong> {{ $poinKeuangan->poin_pernyataan_teman }} poin</p>
                            <p class="mb-1"><strong>Jumlah Tanggungan:</strong> {{ $poinKeuangan->poin_jumlah_tanggungan }} poin</p>
                            <p class="mb-1"><strong>Daya Listrik:</strong> {{ $poinKeuangan->poin_daya_listrik }} poin</p>
                            <p class="mb-1"><strong>PBB:</strong> {{ $poinKeuangan->poin_pbb }} poin</p>
                            <p class="mb-1"><strong>Wawancara:</strong> {{ $poinKeuangan->poin_wawancara }} poin</p>
                        </div>
                    </div>
                    <hr>
                    <h5 class="text-info"><strong>Total Poin Keuangan: {{ $poinKeuangan->total_poin }}</strong></h5>
                    <small class="text-muted">Dinilai oleh: {{ $poinKeuangan->user->name }} pada {{ $poinKeuangan->created_at->format('d M Y H:i') }}</small>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Keputusan Akhir</h6>
                </div>
                <div class="card-body">
                    @php
                        $validasiAdmin = $pengajuan->hasilValidasi->where('validator.role', 'admin')->first();
                        $validasiKeuangan = $pengajuan->hasilValidasi->where('validator.role', 'keuangan')->first();
                    @endphp

                    @if($validasiAdmin)
                    <div class="alert alert-success">
                        <h6 class="font-weight-bold"><i class="fas fa-user-tie"></i> Rekomendasi UKT dari Kajur</h6>
                        <h4 class="text-success mb-0">{{ $validasiAdmin->formatted_rekomendasi_ukt }}</h4>
                    </div>
                    @endif

                    @if($validasiKeuangan)
                    <div class="alert alert-info">
                        <h6 class="font-weight-bold"><i class="fas fa-calculator"></i> Rekomendasi UKT dari Keuangan</h6>
                        <h4 class="text-info mb-0">{{ $validasiKeuangan->formatted_rekomendasi_ukt }}</h4>
                    </div>
                    @endif

                    <div class="alert alert-secondary">
                        <small><strong>UKT Saat Ini:</strong> {{ $pengajuan->mahasiswa->formatted_ukt_awal }}</small>
                    </div>

                    <form action="{{ route('list-pengajuan.validasi', $pengajuan->kode) }}" method="POST" id="validasiForm">
                        @csrf
                        <input type="hidden" name="pengajuan_id" value="{{ $pengajuan->id }}">

                        <div class="form-group">
                            <label for="rekomendasi_ukt"><strong>Tingkat Penurunan</strong></label>
                            <select class="form-control" id="rekomendasi_ukt" name="rekomendasi_ukt" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="0">Turun 0 Tingkat (Tetap)</option>
                                <option value="1">Turun 1 Tingkat</option>
                                <option value="2">Turun 2 Tingkat</option>
                                <option value="3">Turun 3 Tingkat</option>
                                <option value="4">Turun 4 Tingkat</option>
                                <option value="5">Turun 5 Tingkat</option>
                                <option value="6">Turun 6 Tingkat</option>
                                <option value="7">Turun 7 Tingkat</option>
                            </select>
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Pilih tingkat penurunan UKT yang akan diberikan
                            </small>
                        </div>

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
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Validasi</h6>
                </div>
                <div class="card-body">
                    @foreach($pengajuan->hasilValidasi as $validasi)
                    <div class="border-left-primary shadow-sm p-3 mb-3">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="font-weight-bold">{{ $validasi->validator_name }}</h6>
                                <small class="text-muted">{{ $validasi->validator_role }} • {{ $validasi->created_at->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                        <hr class="my-2">
                        @if($validasi->hasil_wawancara && $validasi->hasil_wawancara !== '-')
                        <p class="mb-1"><strong>Wawancara:</strong> {{ $validasi->hasil_wawancara }}</p>
                        @endif
                        @if($validasi->hasil_score > 0)
                        <p class="mb-1"><strong>Skor:</strong> {{ $validasi->hasil_score }}/1000</p>
                        @endif
                        <p class="mb-1"><strong>Rekomendasi UKT:</strong> {{ $validasi->formatted_rekomendasi_ukt }}</p>
                        <p class="mb-0">
                            <strong>Status:</strong>
                            <span class="badge badge-{{ $validasi->status == 'disetujui' ? 'success' : 'warning' }}">
                                {{ $validasi->status_label }}
                            </span>
                        </p>
                        @if($validasi->berlaku_selama)
                        <p class="mb-0"><strong>Berlaku:</strong> {{ $validasi->berlaku_selama }}</p>
                        @endif
                        @if($validasi->persentase_penurunan > 0)
                        <small class="text-success">
                            <i class="fas fa-arrow-down"></i> Penurunan {{ $validasi->formatted_persentase_penurunan }}
                        </small>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
