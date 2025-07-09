@extends('layout.main')
@section('title', 'Tambah Layanan Baru')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Layanan</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Layanan</h3>
        </div>
        <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama Layanan</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                        name="nama" value="{{ old('nama') }}" placeholder="Contoh: Layanan Ambulans">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="foto">Foto/Ikon Layanan</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto"
                        name="foto">
                    <small class="form-text text-muted">Disarankan menggunakan gambar/ikon dengan latar transparan
                        (PNG).</small>
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection
