@extends('main_blog')

@section('title', $title)

@section('content')
<div class="container my-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Bukti Pendaftaran Peserta Didik Baru</h4>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">{{ $siswa->nama_lengkap }}</h3>
                        <p class="fs-5 text-muted">{{ $siswa->nomor_pendaftaran }}</p>
                    </div>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%;">Status Pendaftaran</th>
                                <td>
                                    <span class="badge fs-6 
                                        @if($siswa->status_pendaftaran == 'Diterima') bg-success 
                                        @elseif($siswa->status_pendaftaran == 'Ditolak') bg-danger 
                                        @else bg-warning text-dark @endif">
                                        {{ $siswa->status_pendaftaran }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Jalur Pendaftaran</th>
                                <td>{{ $siswa->nama_jalur }}</td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td>{{ $siswa->nisn }}</td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td>{{ $siswa->nik }}</td>
                            </tr>
                             <tr>
                                <th>Tempat, Tanggal Lahir</th>
                                <td>{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Sekolah Asal</th>
                                <td>{{ $siswa->sekolah_asal }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="alert alert-info mt-4">
                        <strong>Informasi:</strong> Simpan bukti pendaftaran ini dengan baik. Anda akan membutuhkannya untuk proses selanjutnya.
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('ppdb.result.download', $siswa->id_siswa) }}" class="btn btn-danger btn-lg shadow">
                            <i class="fas fa-file-pdf me-2"></i> Download Bukti Pendaftaran (PDF)
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection