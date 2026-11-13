<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Statistik Sebaran Penyakit - Rumah Semai Helly Seedling</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            color: #111;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16pt;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header h2 {
            font-size: 13pt;
            margin: 4px 0;
            font-weight: normal;
        }
        .header p {
            font-size: 9.5pt;
            margin: 2px 0;
            color: #444;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 10pt;
        }
        .meta-table td {
            padding: 3px 0;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
            margin-top: 10px;
        }
        table.data th, table.data td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: left;
        }
        table.data th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }
        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }
        .font-mono { font-family: monospace; }
        .signatures {
            margin-top: 40px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .sig-box {
            text-align: center;
            width: 250px;
        }
        @media print {
            @page { margin: 1.5cm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #059669; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
            Cetak Dokumen Sekarang (PDF)
        </button>
    </div>

    <!-- Kop Surat Resmi -->
    <div class="header">
        <h1>Rumah Semai Helly Seedling</h1>
        <h2>Laporan Hasil Diagnosa & Sebaran Penyakit Bibit Tanaman Cabai</h2>
        <p>Alamat: Desa Sri Sawahan, Kecamatan Punggur / Bangun Rejo, Kabupaten Lampung Tengah, Lampung</p>
        <p>Sistem Inferensi Cerdas Certainty Factor & Forward Chaining &bull; Tahun 2026</p>
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 18%;"><strong>Periode Data</strong></td>
            <td style="width: 2%;">:</td>
            <td>{{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</td>
            <td style="width: 18%;"><strong>Total Kasus Terekam</strong></td>
            <td style="width: 2%;">:</td>
            <td><strong>{{ $diagnosas->count() }} Kasus</strong></td>
        </tr>
        <tr>
            <td><strong>Dicetak Oleh</strong></td>
            <td>:</td>
            <td>{{ $pengawas->name }} ({{ ucfirst($pengawas->role) }})</td>
            <td><strong>Waktu Cetak</strong></td>
            <td>:</td>
            <td>{{ now()->translatedFormat('d F Y, H:i') }} WIB</td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 14%;">Kode Diagnosa</th>
                <th style="width: 11%;">Tanggal</th>
                <th style="width: 14%;">Lokasi Petak</th>
                <th style="width: 14%;">Petugas Lapangan</th>
                <th>Hasil Diagnosa Penyakit</th>
                <th style="width: 10%;">Akurasi (CF)</th>
                <th style="width: 11%;">Status Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($diagnosas as $index => $d)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-mono">{{ $d->kode_diagnosa }}</td>
                    <td class="text-center">{{ $d->created_at->format('d/m/Y') }}</td>
                    <td>{{ $d->petak->kode_petak }} - {{ $d->petak->nama_petak }}</td>
                    <td>{{ $d->user->name }}</td>
                    <td>
                        <strong>{{ $d->penyakitTerpilih?->nama_penyakit ?? 'Belum Teridentifikasi' }}</strong>
                        @if($d->penyakitTerpilih?->nama_latin)
                            <br><small><em>{{ $d->penyakitTerpilih->nama_latin }}</em></small>
                        @endif
                    </td>
                    <td class="text-center"><strong>{{ $d->persentase_cf }}%</strong></td>
                    <td class="text-center">{{ ucfirst($d->status_tindakan) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px;">Tidak ada riwayat diagnosa pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Pengesahan -->
    <table style="width: 100%; margin-top: 50px; font-size: 10pt;">
        <tr>
            <td style="width: 60%;"></td>
            <td style="text-align: center;">
                Lampung Tengah, {{ now()->translatedFormat('d F Y') }}<br>
                Kepala Rumah Semai & Pakar Tanaman,<br>
                <br><br><br><br>
                <strong><u>Bpk. Helly Sumanto</u></strong><br>
                Rumah Semai Helly Seedling
            </td>
        </tr>
    </table>

</body>
</html>

