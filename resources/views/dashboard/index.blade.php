@extends('dashboard.layout.master')

@section('content')
<!-- Light blue page header -->
<div style="background-color: #badefc; padding: 24px; border-bottom: 1px solid rgba(0,0,0,0.05); margin-top: -1px;">
    <h1 style="color: #0b1a30; font-weight: 700; font-size: 26px; margin: 0; font-family: 'Inter', sans-serif;">Dashboard</h1>
</div>

<div class="container-fluid py-4" style="background-color: #f1f5f9;">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 8px;">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row mb-4">
        <!-- Left Column: Main Card -->
        <div class="col-xl-4 col-md-5 mb-4">
            <div class="card h-100" style="background: #ffffff; border-radius: 8px; border: none; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 24px 20px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center h-100">
                    <div style="background-color: #f0f9ff; width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                        @if(in_array($role, ['admin', 'keuangan', 'wadir']))
                            <i class="fas fa-exclamation-triangle" style="color: #0284c7; font-size: 28px;"></i>
                        @else
                            <i class="fas fa-exclamation-triangle" style="color: #0284c7; font-size: 28px;"></i>
                        @endif
                    </div>
                    @if(in_array($role, ['admin', 'keuangan', 'wadir']))
                        <div style="color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Total Pengajuan</div>
                        <div style="color: #0b1a30; font-size: 26px; font-weight: 700;">{{ $stats['total_pengajuan'] }} Pengajuan</div>
                    @else
                        <div style="color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Total Pengajuan</div>
                        <div style="color: #0b1a30; font-size: 26px; font-weight: 700;">{{ $stats['total_pengajuan'] }} Pengajuan</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Status Summary Card -->
        <div class="col-xl-8 col-md-7 mb-4">
            <div class="card h-100" style="background: #ffffff; border-radius: 8px; border: none; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 24px 20px;">
                <div class="card-body">
                    @if($role === 'mahasiswa')
                        <h2 style="color: #0284c7; font-size: 16px; font-weight: 700; margin-bottom: 20px; font-family: 'Inter', sans-serif;">Status Pengajuan</h2>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="d-flex align-items-center p-3" style="border: 1px solid #e2e8f0; border-radius: 6px; background-color: #f8fafc;">
                                    <div style="width: 12px; height: 12px; background-color: #ef4444; border-radius: 2px; margin-right: 12px; flex-shrink: 0;"></div>
                                    <div>
                                        <div style="font-size: 14px; font-weight: 700; color: #1e293b;">Ditolak</div>
                                        <div style="font-size: 13px; color: #64748b;">{{ $stats['pengajuan_ditolak'] }} Pengajuan</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="d-flex align-items-center p-3" style="border: 1px solid #e2e8f0; border-radius: 6px; background-color: #f8fafc;">
                                    <div style="width: 12px; height: 12px; background-color: #f97316; border-radius: 2px; margin-right: 12px; flex-shrink: 0;"></div>
                                    <div>
                                        <div style="font-size: 14px; font-weight: 700; color: #1e293b;">Sedang Diproses</div>
                                        <div style="font-size: 13px; color: #64748b;">{{ $stats['pengajuan_diproses'] }} Pengajuan</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="d-flex align-items-center p-3" style="border: 1px solid #e2e8f0; border-radius: 6px; background-color: #f8fafc;">
                                    <div style="width: 12px; height: 12px; background-color: #22c55e; border-radius: 2px; margin-right: 12px; flex-shrink: 0;"></div>
                                    <div>
                                        <div style="font-size: 14px; font-weight: 700; color: #1e293b;">Disetujui</div>
                                        <div style="font-size: 13px; color: #64748b;">{{ $stats['pengajuan_disetujui'] }} Pengajuan</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif(in_array($role, ['admin', 'keuangan', 'wadir']))
                        <h2 style="color: #0284c7; font-size: 16px; font-weight: 700; margin-bottom: 20px; font-family: 'Inter', sans-serif;">Status Penilaian</h2>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="d-flex align-items-center p-3" style="border: 1px solid #e2e8f0; border-radius: 6px; background-color: #f8fafc;">
                                    <div style="width: 12px; height: 12px; background-color: #f97316; border-radius: 2px; margin-right: 12px; flex-shrink: 0;"></div>
                                    <div>
                                        <div style="font-size: 14px; font-weight: 700; color: #1e293b;">Belum Dinilai</div>
                                        <div style="font-size: 13px; color: #64748b;">{{ $stats['belum_dinilai'] }} Pengajuan</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="d-flex align-items-center p-3" style="border: 1px solid #e2e8f0; border-radius: 6px; background-color: #f8fafc;">
                                    <div style="width: 12px; height: 12px; background-color: #22c55e; border-radius: 2px; margin-right: 12px; flex-shrink: 0;"></div>
                                    <div>
                                        <div style="font-size: 14px; font-weight: 700; color: #1e293b;">Sudah Dinilai</div>
                                        <div style="font-size: 13px; color: #64748b;">{{ $stats['sudah_dinilai'] }} Pengajuan</div>
                                    </div>
                                </div>
                            </div>
                            @if($role === 'keuangan')
                            <div class="col-sm-6 mb-3">
                                <div class="d-flex align-items-center p-3" style="border: 1px solid #e2e8f0; border-radius: 6px; background-color: #f8fafc;">
                                    <div style="width: 12px; height: 12px; background-color: #0ea5e9; border-radius: 2px; margin-right: 12px; flex-shrink: 0;"></div>
                                    <div>
                                        <div style="font-size: 14px; font-weight: 700; color: #1e293b;">Menunggu Validasi</div>
                                        <div style="font-size: 13px; color: #64748b;">{{ $stats['menunggu_validasi'] }} Pengajuan</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SK Penurunan Table -->
    <h2 style="font-size: 20px; font-weight: 700; color: #0b1a30; margin: 32px 0 16px 0; font-family: 'Inter', sans-serif;">SK Penurunan UKT</h2>
    <div class="card mb-4" style="background: #ffffff; border-radius: 8px; border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); padding: 24px;">
        @if(in_array($role, ['keuangan']))
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('sk.create') }}" class="btn btn-sm btn-success" style="background-color: #22c55e; border: none; border-radius: 4px; padding: 6px 16px; font-size: 13px; font-weight: 600;">
                    <i class="fas fa-plus mr-1"></i> Tambah SK
                </a>
            </div>
        @endif
        
        @if($skTerbaru->count() > 0)
            <div class="table-responsive">
                <table class="table">
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
                                <td style="font-weight: 600; color: #1e293b;">{{ $sk->nomor_sk }}</td>
                                <td>{{ $sk->judul }}</td>
                                <td>{{ $sk->tahun }}</td>
                                <td>{{ $sk->tanggal_terbit->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('sk.download', $sk->id) }}" class="btn btn-sm btn-primary" style="background-color: #0284c7; border: none; border-radius: 4px; padding: 6px 12px; font-size: 12px; font-weight: 600;" target="_blank">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </a>
                                    @if(in_array($role, ['keuangan']))
                                        <a href="{{ route('sk.edit', $sk->id) }}" class="btn btn-sm btn-warning" style="background-color: #f59e0b; border: none; border-radius: 4px; padding: 6px 10px; font-size: 12px; margin-left: 4px;">
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
            <p class="text-center text-muted py-4 mb-0">Belum ada SK yang diupload.</p>
        @endif
    </div>
</div>
@endsection

