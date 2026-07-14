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
                                    <td>: <strong>{{ $pengajuan->formatted_total_gaji }}</strong> <span class="badge badge-primary ml-1">{{ $pengajuan->poin_total_gaji }} Poin</span></td>
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
                                    <td>: {{ $pengajuan->jumlah_tanggungan }} orang <span class="badge badge-primary ml-1">{{ $pengajuan->poin_jumlah_tanggungan }} Poin</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Daya Listrik</strong></td>
                                    <td>: {{ $pengajuan->daya_listrik }} VA <span class="badge badge-primary ml-1">{{ $pengajuan->poin_daya_listrik }} Poin</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Tagihan Listrik</strong></td>
                                    <td>: Rp {{ number_format($pengajuan->tagihan_listrik, 0, ',', '.') }} <span class="badge badge-primary ml-1">{{ $pengajuan->poin_tagihan_listrik }} Poin</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Tagihan PDAM</strong></td>
                                    <td>: Rp {{ number_format($pengajuan->tagihan_pdam, 0, ',', '.') }} <span class="badge badge-primary ml-1">{{ $pengajuan->poin_tagihan_pdam }} Poin</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>PBB</strong></td>
                                    <td>: Rp {{ number_format($pengajuan->pbb, 0, ',', '.') }} <span class="badge badge-primary ml-1">{{ $pengajuan->poin_pbb }} Poin</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Motor</strong></td>
                                    <td>: {{ $pengajuan->jumlah_motor }} unit <span class="badge badge-primary ml-1">{{ $pengajuan->poin_jumlah_motor }} Poin</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Mobil</strong></td>
                                    <td>: {{ $pengajuan->jumlah_mobil }} unit <span class="badge badge-primary ml-1">{{ $pengajuan->poin_jumlah_mobil }} Poin</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Kepemilikan Kartu</strong></td>
                                    <td>: {{ $pengajuan->kepemilikan_kartu }} <span class="badge badge-primary ml-1">{{ $pengajuan->poin_kepemilikan_kartu }} Poin</span></td>
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
                    <h6 class="m-0 font-weight-bold">Penilaian Admin</h6>
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
                    <h5 class="text-success"><strong>Total Poin Admin: {{ $poinAdmin->total_poin }}</strong></h5>
                    <small class="text-muted">Dinilai oleh: {{ $poinAdmin->user->name }} pada {{ $poinAdmin->created_at->format('d M Y H:i') }}</small>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Penilaian Keuangan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('list-pengajuan.validasi', $pengajuan->kode) }}" method="POST" id="validasiForm">
                        @csrf
                        <input type="hidden" name="pengajuan_id" value="{{ $pengajuan->id }}">

                        <h6 class="text-primary mb-3"><i class="fas fa-calculator"></i> Penilaian Poin Keuangan</h6>

                        @php
                            $totalNilaiSistem = $pengajuan->poin_total_gaji + $pengajuan->poin_jumlah_tanggungan + $pengajuan->poin_daya_listrik + $pengajuan->poin_tagihan_listrik + $pengajuan->poin_tagihan_pdam + $pengajuan->poin_pbb + $pengajuan->poin_jumlah_motor + $pengajuan->poin_jumlah_mobil + $pengajuan->poin_kepemilikan_kartu;
                        @endphp

                        <div class="form-group">
                            <label for="poin_wawancara"><strong>Rekomendasi Sistem</strong></label>
                            <input type="number" class="form-control bg-light font-weight-bold text-center"
                                id="poin_wawancara"
                                name="poin_wawancara"
                                value="{{ $existingPoint->poin_wawancara ?? $totalNilaiSistem }}"
                                readonly>
                            <small class="text-muted">
                                <i class="fas fa-info-circle text-primary"></i>
                                <strong>Total nilai dari sistem: {{ $totalNilaiSistem }}</strong>
                            </small>
                        </div>

                        <hr>

                        {{-- <div class="form-group">
                            <label for="hasil_wawancara"><strong>Hasil Wawancara</strong></label>
                            <textarea class="form-control" id="hasil_wawancara" name="hasil_wawancara" rows="3"
                                placeholder="Rangkuman hasil wawancara...">{{ old('hasil_wawancara') }}</textarea>
                        </div> --}}
                        <input type="hidden" name="hasil_wawancara" value="-">

                        <div class="form-group">
                            <label for="status"><strong>Rekomendasi</strong></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">Pilih Rekomendasi</option>
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
                        <p class="mb-1"><strong>Skor:</strong> {{ $validasi->hasil_score }}/1000</p>
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
