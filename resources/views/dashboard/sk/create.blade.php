@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah SK Penurunan UKT</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

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
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah SK</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('sk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nomor_sk">Nomor SK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nomor_sk') is-invalid @enderror"
                                   id="nomor_sk" name="nomor_sk" value="{{ old('nomor_sk') }}"
                                   placeholder="Contoh: SK/001/UKT/2024" required>
                            @error('nomor_sk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tahun">Tahun <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('tahun') is-invalid @enderror"
                                   id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}"
                                   min="2000" max="{{ date('Y') + 1 }}" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal_terbit">Tanggal Terbit <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_terbit') is-invalid @enderror"
                                   id="tanggal_terbit" name="tanggal_terbit" value="{{ old('tanggal_terbit') }}" required>
                            @error('tanggal_terbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="judul">Judul SK <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror"
                           id="judul" name="judul" value="{{ old('judul') }}"
                           placeholder="Contoh: Surat Keputusan Penurunan UKT Semester Genap 2024" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                              id="keterangan" name="keterangan" rows="3"
                              placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="file">File SK (PDF) <span class="text-danger">*</span></label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                               id="file" name="file" accept=".pdf" required>
                        <label class="custom-file-label" for="file">Pilih file...</label>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">Format: PDF, Maksimal 10MB</small>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan SK
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass('selected').html(fileName);

        let title = fileName.replace(/\.[^/.]+$/, "");
        $('#judul').val(title);
    });
});
</script>
@endpush
