<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            margin: 30px 40px;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            font-size: 18px;
            margin: 0;
        }

        .header h3 {
            font-size: 16px;
            margin: 5px 0;
        }

        .header p {
            margin: 5px 0;
        }

        .section-title {
            background-color: #007c6c;
            color: #fff;
            padding: 8px;
            font-weight: bold;
            text-align: center;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .data-table th, .data-table td {
            padding: 8px 10px;
            border: 1px solid #ccc;
            vertical-align: top;
        }

        .data-table th {
            background-color: #f0f0f0;
            width: 35%;
            font-weight: 600;
        }

        .photo-signature-wrapper {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .photo-section {
            width: 120px;
            height: 160px;
            border: 1px solid #ccc;
            text-align: center;
            padding: 5px;
            font-size: 11px;
        }

        .photo-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .signature-section {
            text-align: center;
            width: 220px;
            
            position: fixed;
            right: 0;
            bottom: 10rem
        }

        .signature-section p {
            margin: 0;
        }

        .signature-space {
            margin-top: 60px;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #888;
        }
    </style>
</head>
<body>
    @php $setting = DB::table('tbl_setting')->first(); @endphp

    <div class="header">
        <h2>BUKTI PENDAFTARAN</h2>
        <h3>PENERIMAAN PESERTA DIDIK BARU (PPDB)</h3>
        <p><strong>{{ $setting->nama ?? 'SEKOLAH HARAPAN BANGSA' }}</strong><br>
        TAHUN AJARAN {{ $siswa->tahun_ajaran }}</p>
    </div>

    <div class="section-title">DATA CALON SISWA</div>
    <table class="data-table">
        <tr><th>Nomor Pendaftaran</th><td>{{ $siswa->nomor_pendaftaran }}</td></tr>
        <tr><th>Status Pendaftaran</th><td><strong>{{ strtoupper($siswa->status_pendaftaran) }}</strong></td></tr>
        <tr><th>Jalur Pendaftaran</th><td>{{ $siswa->nama_jalur }}</td></tr>
        <tr><th>Nama Lengkap</th><td>{{ $siswa->nama_lengkap }}</td></tr>
        <tr><th>NISN / NIK</th><td>{{ $siswa->nisn }} / {{ $siswa->nik }}</td></tr>
        <tr><th>Tempat, Tanggal Lahir</th><td>{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') }}</td></tr>
        <tr><th>Jenis Kelamin</th><td>{{ $siswa->jenis_kelamin }}</td></tr>
        <tr><th>Sekolah Asal</th><td>{{ $siswa->sekolah_asal }} (Lulus Tahun: {{ $siswa->tahun_lulus }})</td></tr>
    </table>

    <div class="section-title">DATA ORANG TUA / WALI</div>
    <table class="data-table">
        @foreach($orang_tua as $ortu)
            <tr><th>Nama {{ $ortu->hubungan }}</th><td>{{ $ortu->nama_lengkap }}</td></tr>
        @endforeach
        <tr><th>No. Telepon Darurat</th><td>{{ $orang_tua->first()->no_telepon_ortu ?? '-' }}</td></tr>
    </table>

    <p>Dokumen ini adalah bukti pendaftaran yang sah. Harap simpan dengan baik dan bawa saat melakukan verifikasi fisik (jika diperlukan).</p>

    <div class="photo-signature-wrapper">
        <div class="photo-section">
            @if($pas_foto && file_exists(public_path($pas_foto->path_file)))
                <img src="{{ public_path($pas_foto->path_file) }}" alt="Pas Foto">
            @else
                <p>Pas Foto<br>3x4</p>
            @endif
        </div>

        <div class="signature-section">
            <p>...,..........</p>
            <p></p>
            <div class="signature-space">________________________</div>
        </div>
    </div>

    <div class="footer">
        Dicetak oleh sistem pada {{ date('d-m-Y H:i:s') }} - {{ $setting->nama ?? 'PPDB Online' }}
    </div>
</body>
</html>
