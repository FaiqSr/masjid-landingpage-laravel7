@extends('layout.main')

@section('title', $title)

@section('breadcrumbs')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Edit Pendaftar</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ppdb.index') }}">Data Pendaftar</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Edit Data {{ $siswa->nama_lengkap }}</h3>
    </div>
    <form action="{{ route('ppdb.update', $siswa->id_siswa) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="nisn">NISN</label>
                    <input type="text" class="form-control" id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn) }}">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nik">NIK</label>
                    <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $siswa->nik) }}">
                </div>
                 <div class="form-group col-md-6">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                        <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="row">
                 <div class="form-group col-md-6">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                </div>
            </div>

            <div class="row">
                 <div class="form-group col-md-8">
                    <label for="sekolah_asal">Sekolah Asal</label>
                    <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal" value="{{ old('sekolah_asal', $siswa->sekolah_asal) }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="tahun_lulus">Tahun Lulus</label>
                    <input type="number" class="form-control" id="tahun_lulus" name="tahun_lulus" value="{{ old('tahun_lulus', $siswa->tahun_lulus) }}">
                </div>
            </div>

            <hr>
            <h5 class="text-bold">Status Pendaftaran</h5>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="id_jalur_pendaftaran">Jalur Pendaftaran</label>
                    <select name="id_jalur_pendaftaran" id="id_jalur_pendaftaran" class="form-control select2bs4">
                        @foreach($jalur_pendaftaran as $jalur)
                            <option value="{{ $jalur->id_jalur }}" {{ old('id_jalur_pendaftaran', $siswa->id_jalur_pendaftaran) == $jalur->id_jalur ? 'selected' : '' }}>
                                {{ $jalur->nama_jalur }}
                            </option>
                        @endforeach
                    </select>
                </div>
                 <div class="form-group col-md-6">
                    <label for="status_pendaftaran">Status Pendaftaran</label>
                    <select name="status_pendaftaran" id="status_pendaftaran" class="form-control">
                        <option value="Menunggu Verifikasi" {{ old('status_pendaftaran', $siswa->status_pendaftaran) == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="Terverifikasi" {{ old('status_pendaftaran', $siswa->status_pendaftaran) == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="Diterima" {{ old('status_pendaftaran', $siswa->status_pendaftaran) == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="Ditolak" {{ old('status_pendaftaran', $siswa->status_pendaftaran) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="Cadangan" {{ old('status_pendaftaran', $siswa->status_pendaftaran) == 'Cadangan' ? 'selected' : '' }}>Cadangan</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <a href="{{ route('ppdb.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary float-right">Update Data</button>
        </div>
    </form>
</div>
@endsection