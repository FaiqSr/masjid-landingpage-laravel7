@extends('layout.main')
@section('title', 'Edit Layanan')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Layanan</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Edit Layanan</h3>
        </div>
        <form action="{{ route('layanan.update', $layanan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama Layanan</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                        name="nama" value="{{ old('nama', $layanan->nama) }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Foto Saat Ini</label>
                    <div>
                        <img src="{{ url('public/img/layanan/' . $layanan->foto) }}" alt="{{ $layanan->nama }}"
                            width="150">
                    </div>
                </div>
                <div class="form-group">
                    <label for="foto">Ganti Foto/Ikon</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto"
                        name="foto">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection
