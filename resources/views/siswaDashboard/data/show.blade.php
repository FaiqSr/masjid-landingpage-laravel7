@extends('layout.siswaDashboard') {{-- Pastikan nama layout siswa Anda benar --}}

@section('title', $title)

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Data Pendaftaran Saya</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.siswa.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Saya</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')

    @if(session('gagal'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle"></i> {{ session('gagal') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    <div class="row">
        {{-- KOLOM KIRI --}}
        <div class="col-md-7">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Data Pribadi</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr><th style="width: 35%;">Nama Lengkap</th><td>{{ $siswa->nama_lengkap }}</td></tr>
                            <tr><th>NISN</th><td>{{ $siswa->nisn }}</td></tr>
                            <tr><th>NIK</th><td>{{ $siswa->nik }}</td></tr>
                            <tr><th>Nomor KK</th><td>{{ $siswa->no_kk }}</td></tr>
                            <tr><th>Tempat, Tanggal Lahir</th><td>{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}</td></tr>
                            <tr><th>Jenis Kelamin</th><td>{{ $siswa->jenis_kelamin }}</td></tr>
                            <tr><th>Anak Ke / Jml. Saudara</th><td>{{ $siswa->anak_ke }} dari {{ $siswa->jumlah_saudara }} bersaudara</td></tr>
                            <tr><th>Alamat</th><td>{{ $siswa->alamat_lengkap }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">Data Orang Tua / Wali</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            @foreach ($orang_tua as $ortu)
                                <tr>
                                    <th style="width: 35%;">Nama {{ $ortu->hubungan }}</th>
                                    <td>{{ $ortu->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan {{ $ortu->hubungan }}</th>
                                    <td>{{ $ortu->pekerjaan ?? '-' }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th>No. Kontak Darurat</th>
                                <td>{{ $orang_tua->first()->no_telepon_ortu ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN --}}
        <div class="col-md-5">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">Informasi Pendaftaran</h3>
                </div>
                <div class="card-body p-0">
                     <table class="table table-bordered table-striped">
                        <tbody>
                            <tr><th style="width: 40%;">Nomor Pendaftaran</th><td>{{ $siswa->nomor_pendaftaran }}</td></tr>
                            <tr><th>Status Pendaftaran</th><td><span class="badge badge-info">{{ $siswa->status_pendaftaran }}</span></td></tr>
                            <tr><th>Jalur Pendaftaran</th><td>{{ $siswa->nama_jalur }}</td></tr>
                            <tr><th>Sekolah Asal</th><td>{{ $siswa->sekolah_asal }} (Lulus {{ $siswa->tahun_lulus }})</td></tr>
                            <tr><th>Email Akun</th><td>{{ $siswa->email }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">Berkas Terlampir</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($berkas as $file)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $file->jenis_berkas }}
                            <a href="{{ url('public/'.$file->path_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </li>
                        @empty
                        <li class="list-group-item text-muted">Tidak ada berkas yang dilampirkan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            @if ($siswa->status_pendaftaran == 'Menunggu Verifikasi')
            <a href="{{ route('siswa.data.edit') }}" class="btn btn-primary btn-block">
                <i class="fas fa-edit mr-2"></i><b>Ubah Data Pendaftaran</b>
            </a>
            @else
            <div class="alert alert-warning text-center">
                <i class="icon fas fa-lock"></i>
                Data sudah dikunci dan tidak dapat diubah lagi.
            </div>
            @endif
        </div>
    </div>
@endsection