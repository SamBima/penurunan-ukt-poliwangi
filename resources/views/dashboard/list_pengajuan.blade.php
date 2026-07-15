@extends('dashboard.layout.master')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ isset($isArsip) && $isArsip ? 'Arsip Pengajuan Penurunan UKT' : 'List Daftar Pemohon Penurunan UKT Terbaru' }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ isset($isArsip) && $isArsip ? route('arsip-pengajuan') : route('list-pengajuan') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">Pencarian</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   placeholder="Cari berdasarkan kode, nama, atau NIM"
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="semester">Semester/Tahun Akademik</label>
                            <select class="form-control" id="semester" name="semester">
                                <option value="">Semua Semester</option>
                                @foreach($semesterOptions as $key => $label)
                                    <option value="{{ $key }}" {{ request('semester') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="{{ route('list-pengajuan') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-reload"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengajuan Penurunan UKT</h6>
            <div class="d-flex align-items-center">
                <span class="text-muted mr-3">
                    Menampilkan {{ $pengajuan->firstItem() }} - {{ $pengajuan->lastItem() }}
                    dari {{ $pengajuan->total() }} data
                </span>
                @if(Auth::user()->role === 'keuangan' && !(isset($isArsip) && $isArsip))
                <form action="{{ route('list-pengajuan.bulk-keuangan') }}" method="POST" class="d-inline mb-0" id="bulkForm">
                    @csrf
                    <input type="hidden" name="action" id="bulkAction" value="">
                    <button type="button" class="btn btn-sm btn-success mr-2 font-weight-bold" onclick="confirmBulk('terima')">
                        <i class="fas fa-check-double"></i> Terima Semua
                    </button>
                    <button type="button" class="btn btn-sm btn-danger font-weight-bold" onclick="confirmBulk('tolak')">
                        <i class="fas fa-times-circle"></i> Tolak Semua
                    </button>
                </form>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th width="12%">ID Pemohon</th>
                            <th width="18%">Nama Mahasiswa</th>
                            <th width="10%">NIM</th>
                            <th width="12%">Semester/Tahun</th>
                            <th width="12%">Status</th>
                            <th width="31%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($pengajuan->currentPage() - 1) * $pengajuan->perPage() }}</td>
                            <td>
                                <span class="badge badge-info">{{ $item->kode }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm mr-2">
                                        <div class="avatar-title bg-primary rounded-circle text-white">
                                            {{ strtoupper(substr($item->mahasiswa->nama_lengkap, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <strong>{{ $item->mahasiswa->nama_lengkap }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $item->mahasiswa->program_studi ?? 'Program Studi' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="font-weight-bold">{{ $item->mahasiswa->nim }}</span>
                            </td>
                            <td>
                                @php
                                    $bulan = date('n', strtotime($item->created_at));
                                    $tahun = date('Y', strtotime($item->created_at));
                                    $semester = ($bulan >= 7 && $bulan <= 12) ? 'Ganjil' : 'Genap';
                                @endphp
                                <span class="badge badge-secondary">{{ $semester }}/{{ $tahun }}</span>
                            </td>
                            <td>
                                @php
                                    $badgeClass = '';
                                    $statusLabel = ucwords(str_replace('_', ' ', $item->status));

                                    switch($item->status) {
                                        case 'diajukan':
                                            $badgeClass = 'badge-warning';
                                            $statusLabel = 'Diajukan Ke Keuangan';
                                            break;
                                        case 'diterima_keuangan':
                                            $badgeClass = 'badge-primary';
                                            break;
                                        case 'dinilai_admin':
                                        case 'dinilai_keuangan':
                                            $badgeClass = 'badge-info';
                                            break;
                                        case 'dinilai_wadir': // Handle Wadir decision
                                            $hasilWadir = $item->hasilValidasi->where('validator.role', 'wadir')->first();
                                            if ($hasilWadir) {
                                                if ($hasilWadir->status === 'disetujui') {
                                                    $badgeClass = 'badge-success';
                                                    $statusLabel = 'Disetujui';
                                                } else {
                                                    $badgeClass = 'badge-warning';
                                                    $statusLabel = 'Disarankan Cicilan';
                                                }
                                            } else {
                                                $badgeClass = 'badge-success';
                                                $statusLabel = 'Selesai';
                                            }
                                            break;
                                        case 'disarankan_cicilan': // Fallback if status updated
                                            $badgeClass = 'badge-warning';
                                            $statusLabel = 'Disarankan Cicilan';
                                            break;
                                        case 'disetujui':
                                            $badgeClass = 'badge-success';
                                            break;
                                        case 'ditolak':
                                            $badgeClass = 'badge-danger';
                                            break;
                                        default:
                                            $badgeClass = 'badge-secondary';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td>
                                @if(Auth::user()->role === 'keuangan' && $item->status === 'diajukan')
                                    <div class="btn-group mb-2" role="group">
                                        <form action="{{ route('list-pengajuan.approve', $item->kode) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin menerima pengajuan ini?')">
                                                <i class="fas fa-check"></i> Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('list-pengajuan.reject', $item->kode) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger ml-1" onclick="return confirm('Yakin ingin menolak pengajuan ini?')">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                        <a href="{{ route('list-pengajuan.show', ['kode' => $item->kode, 'source' => (isset($isArsip) && $isArsip) ? 'arsip' : 'list']) }}" 
                                            class="btn btn-sm btn-outline-primary ml-1" 
                                            title="Lihat Detail">
                                             <i class="fas fa-eye"></i> Lihat Form & Berkas
                                         </a>
                                    </div>
                                @elseif($item->status !== 'diajukan' || Auth::user()->role !== 'keuangan')
                                    <div class="btn-group mb-2" role="group">
                                        <a href="{{ route('list-pengajuan.show', ['kode' => $item->kode, 'source' => (isset($isArsip) && $isArsip) ? 'arsip' : 'list']) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i> Lihat Form & Berkas
                                        </a>
                                    </div>
                                @endif
                                <div class="mt-1">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i>
                                        {{ $item->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak ada data pengajuan</h5>
                                    <p class="text-muted">Belum ada pengajuan penurunan UKT yang sesuai dengan filter yang dipilih.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pengajuan->hasPages())
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info">
                        Menampilkan {{ $pengajuan->firstItem() }} sampai {{ $pengajuan->lastItem() }}
                        dari {{ $pengajuan->total() }} entri
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers">
                        <ul class="pagination justify-content-end">
                            @if ($pengajuan->onFirstPage())
                                <li class="paginate_button page-item previous disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="paginate_button page-item previous">
                                    <a href="{{ $pengajuan->previousPageUrl() }}" class="page-link">Previous</a>
                                </li>
                            @endif

                            @foreach ($pengajuan->getUrlRange(1, $pengajuan->lastPage()) as $page => $url)
                                @if ($page == $pengajuan->currentPage())
                                    <li class="paginate_button page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="paginate_button page-item">
                                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            @if ($pengajuan->hasMorePages())
                                <li class="paginate_button page-item next">
                                    <a href="{{ $pengajuan->nextPageUrl() }}" class="page-link">Next</a>
                                </li>
                            @else
                                <li class="paginate_button page-item next disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75em;
}

.btn-group .btn {
    margin-right: 2px;
}

.dataTables_info {
    padding-top: 0.5rem;
    font-size: 0.875rem;
    color: #6c757d;
}

.dataTables_paginate {
    padding-top: 0.5rem;
}

.pagination {
    margin-bottom: 0;
}

.paginate_button {
    display: inline;
}

.page-link {
    padding: 0.375rem 0.75rem;
    margin-left: -1px;
    color: #007bff;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #dee2e6;
}

.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    cursor: auto;
    background-color: #fff;
    border-color: #dee2e6;
}
</style>

@if(Auth::user()->role === 'keuangan')
<script>
function confirmBulk(action) {
    const actionLabel = action === 'terima' ? 'menerima (menyetujui dengan rekomendasi)' : 'menolak';
    if (confirm(`Apakah Anda yakin ingin ${actionLabel} semua pengajuan yang belum dinilai?`)) {
        document.getElementById('bulkAction').value = action;
        document.getElementById('bulkForm').submit();
    }
}
</script>
@endif
@endsection
