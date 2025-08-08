@extends('layout.main')

@section('title', $title)

@section('breadcrumbs')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Detail Pendaftar</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ppdb.index') }}">Data Pendaftar</a></li>
            <li class="breadcrumb-item active">{{ $siswa->nama_lengkap }}</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h3 class="profile-username text-center">{{ $siswa->nama_lengkap }}</h4>
                <p class="text-muted text-center">{{ $siswa->nomor_pendaftaran }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item"><b>NISN</b> <a class="float-right">{{ $siswa->nisn }}</a></li>
                    <li class="list-group-item"><b>NIK</b> <a class="float-right">{{ $siswa->nik }}</a></li>
                    <li class="list-group-item"><b>TTL</b> <a class="float-right">{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}</a></li>
                    <li class="list-group-item"><b>Jenis Kelamin</b> <a class="float-right">{{ $siswa->jenis_kelamin }}</a></li>
                    <li class="list-group-item"><b>Sekolah Asal</b> <a class="float-right">{{ $siswa->sekolah_asal }} (Lulus {{ $siswa->tahun_lulus }})</a></li>
                </ul>
            </div>
        </div>
        <div class="card card-info">
            <div class="card-header"><h3 class="card-title">Data Orang Tua / Wali</h3></div>
            <div class="card-body">
                @foreach($orang_tua as $ortu)
                    <strong><i class="fas fa-user mr-1"></i> {{ $ortu->hubungan }}</strong>
                    <p class="text-muted">{{ $ortu->nama_lengkap }} (Pekerjaan: {{ $ortu->pekerjaan ?? '-' }})</p>
                    <hr>
                @endforeach
                <strong><i class="fas fa-phone-alt mr-1"></i> No. Kontak Darurat</strong>
                <p class="text-muted">{{ $orang_tua->first()->no_telepon_ortu ?? '-' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card card-success">
            <div class="card-header"><h3 class="card-title">Informasi Pendaftaran</h3></div>
            <div class="card-body">
                <strong><i class="fas fa-road mr-1"></i> Jalur Pendaftaran</strong>
                <p class="text-muted">{{ $siswa->nama_jalur }}</p>
                <hr>
                <strong><i class="fas fa-info-circle mr-1"></i> Status Pendaftaran</strong>
                <p class="text-muted"><span class="badge badge-info">{{ $siswa->status_pendaftaran }}</span></p>
                <hr>
                <strong><i class="far fa-envelope mr-1"></i> Email Akun</strong>
                <p class="text-muted">{{ $siswa->email }}</p>
            </div>
        </div>
        <div class="card card-warning">
            <div class="card-header"><h3 class="card-title">Berkas Terlampir</h3></div>
            <div class="card-body">
                <ul class="list-unstyled">
                    @forelse($berkas as $file)
                    <li>
                        <a href="{{ url('public/'.$file->path_file) }}" target="_blank" class="btn-link text-secondary">
                        <i class="far fa-fw fa-file-pdf"></i> {{ $file->jenis_berkas }}
                        </a>
                    </li>
                    @empty
                    <p class="text-muted">Tidak ada berkas yang dilampirkan.</p>
                    @endforelse
                </ul>
            </div>
        </div>
        <a href="{{ route('ppdb.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('ppdb.edit', $siswa->id_siswa) }}" class="btn btn-primary float-right">Edit Data</a>
    </div>
</div>
@endsection