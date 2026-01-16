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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
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
                    <h6 class="m-0 font-weight-bold text-primary">Form Penilaian Admin</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('list-pengajuan.validasi', $pengajuan->kode) }}" method="POST" id="validasiForm">
                        @csrf
                        <input type="hidden" name="pengajuan_id" value="{{ $pengajuan->id }}">

                        <h6 class="text-primary mb-3"><i class="fas fa-calculator"></i> Penilaian Poin</h6>

                        <div class="form-group">
                            <label for="poin_penghasilan_ortu"><strong>Poin Penghasilan Orang Tua</strong></label>
                            <input type="number" class="form-control" id="poin_penghasilan_ortu"
                                name="poin_penghasilan_ortu" min="0" max="100"
                                placeholder="0-100" required
                                value="{{ old('poin_penghasilan_ortu', $existingPoint->poin_penghasilan_ortu ?? '') }}">
                            <small class="text-muted">Total: {{ $pengajuan->formatted_total_gaji }}</small>
                        </div>

                        <div class="form-group">
                            <label for="poin_tagihan"><strong>Poin Tagihan Bulanan</strong></label>
                            <input type="number" class="form-control" id="poin_tagihan"
                                name="poin_tagihan" min="0" max="100"
                                placeholder="0-100" required
                                value="{{ old('poin_tagihan', $existingPoint->poin_tagihan ?? '') }}">
                            <small class="text-muted">Listrik + PDAM</small>
                        </div>

                        <div class="form-group">
                            <label for="poin_kepemilikan"><strong>Poin Kepemilikan Kendaraan</strong></label>
                            <input type="number" class="form-control" id="poin_kepemilikan"
                                name="poin_kepemilikan" min="0" max="100"
                                placeholder="0-100" required
                                value="{{ old('poin_kepemilikan', $existingPoint->poin_kepemilikan ?? '') }}">
                            <small class="text-muted">Motor: {{ $pengajuan->jumlah_motor }}, Mobil: {{ $pengajuan->jumlah_mobil }}</small>
                        </div>

                        <div class="form-group">
                            <label for="poin_kondisi_rumah"><strong>Poin Kondisi Rumah</strong></label>
                            <input type="number" class="form-control" id="poin_kondisi_rumah"
                                name="poin_kondisi_rumah" min="0" max="100"
                                placeholder="0-100" required
                                value="{{ old('poin_kondisi_rumah', $existingPoint->poin_kondisi_rumah ?? '') }}">
                            <small class="text-muted">Dari foto rumah & dokumen</small>
                        </div>

                        <div class="form-group">
                            <label for="poin_kartu_bantuan"><strong>Poin Kartu Bantuan</strong></label>
                            <input type="number" class="form-control" id="poin_kartu_bantuan"
                                name="poin_kartu_bantuan" min="0" max="100"
                                placeholder="0-100" required
                                value="{{ old('poin_kartu_bantuan', $existingPoint->poin_kartu_bantuan ?? '') }}">
                            <small class="text-muted">Kartu: {{ $pengajuan->kepemilikan_kartu }}</small>
                        </div>

                        <div class="form-group">
                            <label for="poin_pernyataan_teman"><strong>Poin Pernyataan Teman</strong></label>
                            <input type="number" class="form-control" id="poin_pernyataan_teman"
                                name="poin_pernyataan_teman" min="0" max="100"
                                placeholder="0-100" required
                                value="{{ old('poin_pernyataan_teman', $existingPoint->poin_pernyataan_teman ?? '') }}">
                            <small class="text-muted">Status: {{ $pengajuan->pernyataan_teman }}</small>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="poin_jumlah_tanggungan"><strong>Poin Jumlah Tanggungan</strong></label>
                            <input type="number" class="form-control" id="poin_jumlah_tanggungan"
                                name="poin_jumlah_tanggungan" min="0" max="100"
                                placeholder="0-100" required
                                value="{{ old('poin_jumlah_tanggungan', $existingPoint->poin_jumlah_tanggungan ?? '') }}">
                            <small class="text-muted">Tanggungan: {{ $pengajuan->jumlah_tanggungan }} orang</small>
                        </div>

                        <div class="form-group">
                            <label for="poin_daya_listrik"><strong>Poin Daya Listrik</strong></label>
                            <input type="number" class="form-control" id="poin_daya_listrik"
                                name="poin_daya_listrik" min="0" max="100"
                                placeholder="0-100" required
                                value="{{ old('poin_daya_listrik', $existingPoint->poin_daya_listrik ?? '') }}">
                            <small class="text-muted">Daya: {{ $pengajuan->daya_listrik }} VA</small>
                        </div>

                        <div class="form-group">
                            <label for="poin_pbb"><strong>Poin PBB</strong></label>
                            <input type="number" class="form-control" id="poin_pbb"
                                name="poin_pbb" min="0" max="100"
                                placeholder="0-100" required
                                value="{{ old('poin_pbb', $existingPoint->poin_pbb ?? '') }}">
                            <small class="text-muted">PBB: Rp {{ number_format($pengajuan->pbb, 0, ',', '.') }}</small>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="poin_wawancara"><strong>Poin Wawancara</strong></label>
                            <input type="number" class="form-control" id="poin_wawancara"
                                name="poin_wawancara" min="0" max="100"
                                placeholder="0-100" required
                                value="{{ old('poin_wawancara', $existingPoint->poin_wawancara ?? '') }}">
                            <small class="text-muted">Berdasarkan hasil wawancara</small>
                        </div>

                        <div class="form-group">
                            <label for="hasil_wawancara"><strong>Hasil Wawancara</strong></label>
                            <textarea class="form-control" id="hasil_wawancara" name="hasil_wawancara" rows="3"
                                placeholder="Rangkuman hasil wawancara...">{{ old('hasil_wawancara') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="rekomendasi_ukt"><strong>Rekomendasi UKT Baru</strong></label>
                            <select class="form-control" id="rekomendasi_ukt" name="rekomendasi_ukt" required>
                                <option value="">Pilih Tingkat UKT</option>
                                <option value="0">Turun 0 Tingkat (Tetap)</option>
                                <option value="7">Turun 7 Tingkat</option>
                                <option value="6">Turun 6 Tingkat</option>
                                <option value="5">Turun 5 Tingkat</option>
                                <option value="4">Turun 4 Tingkat</option>
                                <option value="3">Turun 3 Tingkat</option>
                                <option value="2">Turun 2 Tingkat</option>
                                <option value="1">Turun 1 Tingkat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status"><strong>Keputusan Akhir</strong></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">Pilih Keputusan</option>
                                <option value="disetujui">Disetujui</option>
                                <option value="disarankan_cicilan">Disarankan Cicilan</option>
                            </select>
                        </div>

                        <div class="alert alert-info">
                            <small>
                                <i class="fas fa-info-circle"></i>
                                <strong>UKT Saat Ini:</strong> {{ $pengajuan->mahasiswa->formatted_ukt_awal }}<br>
                                <strong>Validator:</strong> {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                            </small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-save"></i> Simpan Hasil Penilaian
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
                        @if($validasi->hasil_wawancara)
                        <p class="mb-1"><strong>Wawancara:</strong> {{ $validasi->hasil_wawancara }}</p>
                        @endif
                        <p class="mb-1"><strong>Skor:</strong> {{ $validasi->hasil_score }}/500</p>
                        <p class="mb-1"><strong>Rekomendasi UKT:</strong> {{ $validasi->formatted_rekomendasi_ukt }}</p>
                        <p class="mb-0">
                            <strong>Status:</strong>
                            <span class="badge badge-{{ $validasi->status == 'disetujui' ? 'success' : 'warning' }}">
                                {{ $validasi->status_label }}
                            </span>
                        </p>
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
