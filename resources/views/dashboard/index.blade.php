@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row mb-4">
        @if($role === 'mahasiswa')
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengajuan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_pengajuan'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sedang Diproses</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pengajuan_diproses'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pengajuan_disetujui'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pengajuan_ditolak'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($role === 'admin')
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Belum Dinilai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['belum_dinilai'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sudah Dinilai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['sudah_dinilai'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengajuan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_pengajuan'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($role === 'keuangan')
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Menunggu Validasi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['menunggu_validasi'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Belum Dinilai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['belum_dinilai'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sudah Dinilai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['sudah_dinilai'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total SK</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_sk'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-contract fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($role === 'wadir')
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Keputusan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['menunggu_keputusan'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-gavel fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sudah Diputuskan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['sudah_diputuskan'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-double fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengajuan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_pengajuan'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Keputusan Wadir Terbaru</h6> -->
        <!-- </div>
        <div class="card-body">
            @if($keputusanTerbaru->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Mahasiswa</th>
                                <th>Prodi</th>
                                <th>Status</th>
                                <th>UKT Rekomendasi</th>
                                <th>Berlaku</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keputusanTerbaru as $pengajuan)
                                @php
                                    $validasiWadir = $pengajuan->hasilValidasi->first();
                                @endphp
                                <tr>
                                    <td>{{ $pengajuan->kode }}</td>
                                    <td>{{ $pengajuan->mahasiswa->nama }}</td>
                                    <td>{{ $pengajuan->mahasiswa->prodi->nama ?? '-' }}</td>
                                    <td>
                                        @if($validasiWadir && $validasiWadir->status === 'disetujui')
                                            <span class="badge badge-success">Disetujui</span>
                                        @else
                                            <span class="badge badge-warning">Disarankan Cicilan</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($validasiWadir->rekomendasi_ukt ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $validasiWadir->berlaku_selama ?? '-' }}</td>
                                    <td>{{ $pengajuan->updated_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('list-pengajuan.show', $pengajuan->kode) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted mb-0">Belum ada keputusan Wadir.</p>
            @endif
        </div>
    </div> -->

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">SK Penurunan UKT</h6>
            <div>
                @if(in_array($role, ['keuangan']))
                    <a href="{{ route('sk.create') }}" class="btn btn-sm btn-success mr-2">
                        <i class="fas fa-plus"></i> Tambah SK
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            @if($skTerbaru->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nomor SK</th>
                                <th>Judul</th>
                                <th>Tahun</th>
                                <th>Tanggal Terbit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skTerbaru as $sk)
                                <tr>
                                    <td>{{ $sk->nomor_sk }}</td>
                                    <td>{{ $sk->judul }}</td>
                                    <td>{{ $sk->tahun }}</td>
                                    <td>{{ $sk->tanggal_terbit->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('sk.download', $sk->id) }}" class="btn btn-sm btn-primary" target="_blank">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        @if(in_array($role, ['keuangan']))
                                            <a href="{{ route('sk.edit', $sk->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted mb-0">Belum ada SK yang diupload.</p>
            @endif
        </div>
    </div>

</div>
@endsection
