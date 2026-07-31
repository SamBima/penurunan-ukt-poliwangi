@extends('dashboard.layout.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar SK Penurunan UKT</h1>
        @if(in_array(Auth::user()->role, ['keuangan', 'wadir']))
            <a href="{{ route('sk.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah SK Baru
            </a>
        @endif
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Surat Keputusan</h6>
        </div>
        <div class="card-body">
            @if($skList->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor SK</th>
                                <th>Judul</th>
                                <th>Tahun</th>
                                <th>Tanggal Terbit</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skList as $index => $sk)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $sk->nomor_sk }}</td>
                                    <td>{{ $sk->judul }}</td>
                                    <td>{{ $sk->tahun }}</td>
                                    <td>{{ $sk->tanggal_terbit->format('d F Y') }}</td>
                                    <td>{{ $sk->keterangan ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('sk.download', $sk->id) }}" class="btn btn-sm btn-primary mb-1" title="Download">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        @if(in_array(Auth::user()->role, ['keuangan', 'wadir']))
                                            <a href="{{ route('sk.edit', $sk->id) }}" class="btn btn-sm btn-warning mb-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('sk.destroy', $sk->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SK ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger mb-1" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted">Belum ada SK yang diupload.</p>
            @endif
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [[3, "desc"], [4, "desc"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush
