@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profile Mahasiswa</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
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
                    <h6 class="m-0 font-weight-bold text-primary">Lengkapi Data Profil</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile-mahasiswa') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nim">NIM</label>
                            <input type="text" name="nim" id="nim"
                                class="form-control @error('nim') is-invalid @enderror"
                                value="{{ old('nim', $mahasiswa->nim ?? '') }}" required>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap"
                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap ?? Auth::user()->name) }}" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="prodi_id">Program Studi</label>
                            <select name="prodi_id" id="prodi_id"
                                class="form-control @error('prodi_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Prodi --</option>
                                @foreach ($prodi as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('prodi_id', $mahasiswa->prodi_id ?? '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prodi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jalur_masuk">Jalur Masuk</label>
                            <input type="text" name="jalur_masuk" id="jalur_masuk"
                                class="form-control @error('jalur_masuk') is-invalid @enderror"
                                value="{{ old('jalur_masuk', $mahasiswa->jalur_masuk ?? '') }}" required>
                            @error('jalur_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="text" name="no_hp" id="no_hp"
                                class="form-control @error('no_hp') is-invalid @enderror"
                                value="{{ old('no_hp', $mahasiswa->no_hp ?? '') }}" required>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="semester_saat_ini">Semester Saat Ini</label>
                            <input type="number" name="semester_saat_ini" id="semester_saat_ini"
                                class="form-control @error('semester_saat_ini') is-invalid @enderror"
                                value="{{ old('semester_saat_ini', $mahasiswa->semester_saat_ini ?? '') }}" required>
                            @error('semester_saat_ini')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="ukt_awal">UKT Awal</label>
                            <input type="number" step="0.01" name="ukt_awal" id="ukt_awal"
                                class="form-control @error('ukt_awal') is-invalid @enderror"
                                value="{{ old('ukt_awal', $mahasiswa->ukt_awal ?? '') }}" required>
                            @error('ukt_awal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Profile User & Ganti Password -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Data Akun</h6>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Role:</strong> {{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Ganti Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="password_lama">Password Lama</label>
                            <input type="password" name="password_lama" id="password_lama"
                                class="form-control @error('password_lama') is-invalid @enderror" required>
                            @error('password_lama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning btn-block">
                            <i class="fas fa-key"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
