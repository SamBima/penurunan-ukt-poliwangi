<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Akhir Keputusan Penurunan UKT</title>
    <style>
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            color: #333;
            margin: 0;
            padding: 30px;
            font-size: 12px;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header h3 {
            margin: 5px 0 0 0;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: normal;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 10px;
            color: #666;
        }

        .title-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .title-container h4 {
            margin: 0;
            font-size: 13px;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .title-container p {
            margin: 5px 0 0 0;
            font-size: 11px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 11px;
        }

        .info-table td {
            padding: 3px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
        }

        .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        .text-center {
            text-align: center !important;
        }

        .badge {
            display: inline-block;
            padding: 3px 6px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 3px;
            border: 1px solid #000;
        }

        .footer {
            margin-top: 40px;
            width: 100%;
            font-size: 11px;
        }

        .footer-table {
            width: 100%;
            border: none;
        }

        .footer-table td {
            border: none;
            padding: 0;
        }

        .sign-area {
            float: right;
            text-align: center;
            width: 250px;
        }

        .sign-space {
            height: 70px;
        }

        @media print {
            body {
                padding: 0;
                background-color: #fff;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: A4 portrait;
                margin: 1.5cm;
            }
        }
    </style>
</head>
<body>
    
    <div class="no-print" style="background: #e3f2fd; border: 1px solid #90caf9; padding: 12px; margin-bottom: 20px; border-radius: 4px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <strong>Mode Cetak Laporan PDF:</strong> Klik tombol Cetak di samping jika printer dialog tidak otomatis terbuka.
        </div>
        <button onclick="window.print()" style="background: #1976d2; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; font-weight: bold; cursor: pointer;">
            Cetak Sekarang
        </button>
    </div>

    <!-- Kop Surat -->
    <div class="header">
        <h2>Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi</h2>
        <h3>Politeknik Negeri Banyuwangi</h3>
        <p>Jalan Raya Jember KM 13 Labanasem, Kabat, Banyuwangi 68461 | Telepon: (0333) 636780</p>
    </div>

    <!-- Judul Dokumen -->
    <div class="title-container">
        <h4>Laporan Hasil Akhir Keputusan Penurunan UKT</h4>
        <p>Tahun Akademik: {{ now()->year }}/{{ now()->year + 1 }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%">Tanggal Cetak</td>
            <td width="2%">:</td>
            <td>{{ now()->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Dicetak Oleh</td>
            <td>:</td>
            <td>Staff Keuangan ({{ Auth::user()->name }})</td>
        </tr>
        <tr>
            <td>Jumlah Penerima</td>
            <td>:</td>
            <td><strong>{{ $pengajuan->count() }} Mahasiswa</strong></td>
        </tr>
    </table>

    <!-- Tabel Data Mahasiswa -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="30%">Nama Lengkap</th>
                <th width="15%">NIM</th>
                <th width="30%">Program Studi</th>
                <th width="20%">Keputusan Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuan as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $item->mahasiswa->nama_lengkap }}</strong></td>
                    <td>{{ $item->mahasiswa->nim }}</td>
                    <td>{{ $item->mahasiswa->prodi->nama ?? '-' }}</td>
                    <td>
                        @if($item->status === 'dinilai_wadir')
                            @php
                                $wadirDecision = $item->hasilValidasi->where('validator.role', 'wadir')->first();
                            @endphp
                            @if($wadirDecision)
                                <span>Disetujui<br><small style="color: #28a745; font-weight: bold;">Rp {{ number_format($wadirDecision->rekomendasi_ukt, 0, ',', '.') }}</small></span>
                            @else
                                <span>Disetujui Wadir</span>
                            @endif
                        @elseif($item->status === 'ditolak')
                            <span style="color: #dc3545; font-weight: bold;">Ditolak</span>
                        @else
                            <span>{{ ucwords(str_replace('_', ' ', $item->status)) }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data keputusan akhir pengajuan ukt.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="footer">
        <div class="sign-area">
            <p>Banyuwangi, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Mengetahui,<br><strong>Staff Bagian Keuangan</strong></p>
            <div class="sign-space"></div>
            <p><strong><u>{{ Auth::user()->name }}</u></strong><br>NIP. -</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
