@extends('dashboard.layout.master')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengajuan Penurunan UKT</h1>
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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Pengajuan Penurunan UKT</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('pengajuan') }}" method="POST" enctype="multipart/form-data" id="pengajuanForm">
                @csrf

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary mb-3">Data Orang Tua</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="penghasilan_ayah">Penghasilan Ayah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('penghasilan_ayah') is-invalid @enderror"
                                   id="penghasilan_ayah" name="penghasilan_ayah"
                                   value="{{ old('penghasilan_ayah') }}" required>
                            @error('penghasilan_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pekerjaan_ayah">Pekerjaan Ayah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                                   id="pekerjaan_ayah" name="pekerjaan_ayah"
                                   value="{{ old('pekerjaan_ayah') }}" required>
                            @error('pekerjaan_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="penghasilan_ibu">Penghasilan Ibu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('penghasilan_ibu') is-invalid @enderror"
                                   id="penghasilan_ibu" name="penghasilan_ibu"
                                   value="{{ old('penghasilan_ibu') }}" required>
                            @error('penghasilan_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pekerjaan_ibu">Pekerjaan Ibu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                                   id="pekerjaan_ibu" name="pekerjaan_ibu"
                                   value="{{ old('pekerjaan_ibu') }}" required>
                            @error('pekerjaan_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total_gaji">Total Gaji Keluarga <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('total_gaji') is-invalid @enderror"
                                   id="total_gaji" name="total_gaji"
                                   value="{{ old('total_gaji') }}" required readonly>
                            @error('total_gaji')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah_tanggungan">Jumlah Tanggungan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah_tanggungan') is-invalid @enderror"
                                   id="jumlah_tanggungan" name="jumlah_tanggungan"
                                   value="{{ old('jumlah_tanggungan') }}" required min="0">
                            @error('jumlah_tanggungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary mb-3">Data Rumah</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="daya_listrik">Daya Listrik (Watt) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('daya_listrik') is-invalid @enderror"
                                   id="daya_listrik" name="daya_listrik"
                                   value="{{ old('daya_listrik') }}" required>
                            @error('daya_listrik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tagihan_listrik">Tagihan Listrik (Rp) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tagihan_listrik') is-invalid @enderror"
                                   id="tagihan_listrik" name="tagihan_listrik"
                                   value="{{ old('tagihan_listrik') }}" required>
                            @error('tagihan_listrik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tagihan_pdam">Tagihan PDAM (Rp) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tagihan_pdam') is-invalid @enderror"
                                   id="tagihan_pdam" name="tagihan_pdam"
                                   value="{{ old('tagihan_pdam') }}" required>
                            @error('tagihan_pdam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pbb">PBB (Rp) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pbb') is-invalid @enderror"
                                   id="pbb" name="pbb"
                                   value="{{ old('pbb') }}" required>
                            @error('pbb')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary mb-3">Data Kendaraan</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah_motor">Jumlah Motor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jumlah_motor') is-invalid @enderror"
                                   id="jumlah_motor" name="jumlah_motor"
                                   value="{{ old('jumlah_motor') }}" min="0" required>
                            @error('jumlah_motor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah_mobil">Jumlah Mobil <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jumlah_mobil') is-invalid @enderror"
                                   id="jumlah_mobil" name="jumlah_mobil"
                                   value="{{ old('jumlah_mobil') }}" min="0" required>
                            @error('jumlah_mobil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary mb-3">Data Tambahan</h5>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="kepemilikan_kartu">Kepemilikan Kartu Bantuan <span class="text-danger">*</span></label>
                            <select class="form-control @error('kepemilikan_kartu') is-invalid @enderror"
                                    id="kepemilikan_kartu" name="kepemilikan_kartu" required>
                                <option value="">-- Pilih Kepemilikan Kartu --</option>
                                <option value="KIP" {{ old('kepemilikan_kartu') == 'KIP' ? 'selected' : '' }}>KIP (Kartu Indonesia Pintar)</option>
                                <option value="SKTM" {{ old('kepemilikan_kartu') == 'SKTM' ? 'selected' : '' }}>SKTM (Surat Keterangan Tidak Mampu)</option>
                                <option value="KKS" {{ old('kepemilikan_kartu') == 'KKS' ? 'selected' : '' }}>KKS (Kartu Keluarga Sejahtera)</option>
                                <option value="Tidak Ada" {{ old('kepemilikan_kartu') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                            </select>
                            @error('kepemilikan_kartu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="pernyataan_teman">Pernyataan dari Teman <span class="text-danger">*</span></label>
                            <select class="form-control @error('pernyataan_teman') is-invalid @enderror"
                                    id="pernyataan_teman" name="pernyataan_teman" required>
                                <option value="">-- Pilih Pernyataan --</option>
                                <option value="Ada" {{ old('pernyataan_teman') == 'Ada' ? 'selected' : '' }}>Ada</option>
                                <option value="Tidak Ada" {{ old('pernyataan_teman') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                            </select>
                            @error('pernyataan_teman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="alasan_pengajuan">Alasan Pengajuan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alasan_pengajuan') is-invalid @enderror"
                                      id="alasan_pengajuan" name="alasan_pengajuan" rows="4" required>{{ old('alasan_pengajuan') }}</textarea>
                            <small class="form-text text-muted">Jelaskan alasan mengapa mengajukan penurunan UKT. Minimal 10 karakter.</small>
                            @error('alasan_pengajuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="link_drive">Link Google Drive <span class="text-danger">*</span></label>
                            <input type="url" class="form-control @error('link_drive') is-invalid @enderror"
                                   id="link_drive" name="link_drive"
                                   value="{{ old('link_drive') }}"
                                   placeholder="https://drive.google.com/..." required>
                            <small class="form-text text-muted">Link folder Google Drive yang berisi dokumen pendukung</small>
                            @error('link_drive')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary mb-3">Dokumen Pendukung</h5>
                        <p class="text-muted">Upload dokumen pendukung sesuai kebutuhan.
                            <span class="text-danger">*</span> Wajib isi 4 dokumen utama.</p>
                    </div>

                    <div id="dokumen-container" class="row">
                        @php
                            $dokumenWajib = [
                                'foto_rumah' => 'Foto Rumah',
                                'foto_mobil' => 'Foto Mobil',
                                'foto_motor' => 'Foto Motor',
                                'tagihan_listrik' => 'Tagihan Listrik',
                            ];
                            $i = 0;
                        @endphp
                        @foreach ($dokumenWajib as $key => $label)
                            <div class="col-12 mb-3 dokumen-item">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-end">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Jenis Dokumen</label>
                                                    <input type="text" class="form-control" value="{{ $label }}" readonly>
                                                    <input type="hidden" name="dokumen[{{ $i }}][jenis]" value="{{ $key }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <input type="text" class="form-control"
                                                        name="dokumen[{{ $i }}][keterangan]"
                                                        placeholder="Keterangan dokumen (opsional)">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>File <span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control-file"
                                                        name="dokumen[{{ $i }}][file]"
                                                        accept=".jpg,.jpeg,.png,.pdf" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $i++; @endphp
                        @endforeach
                    </div>

                    <div class="col-12">
                        <button type="button" class="btn btn-secondary" id="add-dokumen">
                            <i class="fas fa-plus"></i> Tambah Dokumen Lainnya
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i> Ajukan Penurunan UKT
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const penghasilanAyah = document.getElementById('penghasilan_ayah');
    const penghasilanIbu = document.getElementById('penghasilan_ibu');
    const totalGaji = document.getElementById('total_gaji');

    function calculateTotal() {
        const ayah = parseInt(penghasilanAyah.value) || 0;
        const ibu = parseInt(penghasilanIbu.value) || 0;
        totalGaji.value = ayah + ibu;
    }

    penghasilanAyah.addEventListener('input', calculateTotal);
    penghasilanAyah.addEventListener('change', calculateTotal);
    penghasilanIbu.addEventListener('input', calculateTotal);
    penghasilanIbu.addEventListener('change', calculateTotal);

    let dokumenIndex = 4;
    document.getElementById('add-dokumen').addEventListener('click', function() {
        const container = document.getElementById('dokumen-container');
        const newDokumen = document.createElement('div');
        newDokumen.className = 'col-12 mb-3 dokumen-item';
        newDokumen.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jenis Dokumen</label>
                                <input type="text" class="form-control" value="Lainnya" readonly>
                                <input type="hidden" name="dokumen[${dokumenIndex}][jenis]" value="lainnya">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Keterangan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    name="dokumen[${dokumenIndex}][keterangan]"
                                    placeholder="Nama dokumen" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>File</label>
                                <input type="file" class="form-control-file"
                                    name="dokumen[${dokumenIndex}][file]"
                                    accept=".jpg,.jpeg,.png,.pdf" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-block remove-dokumen">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(newDokumen);
        dokumenIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-dokumen') || e.target.closest('.remove-dokumen')) {
            e.target.closest('.dokumen-item').remove();
        }
    });
});
</script>
@endsection
