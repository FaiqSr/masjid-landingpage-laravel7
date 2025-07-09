@extends('layout.main')
@section('title', 'Tambah Data Pengurus')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Pengurus Harian Waktu {{ $data->waktu }}</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Petugas Harian Waktu {{ $data->waktu }}</h3>
        </div>
        <form action="{{ route('petugas.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $data->id }}" name="id">
            <div class="card-body">
                <div class="form-group">
                    <label for="imam">Imam</label>
                    <input type="text" class="form-control @error('imam') is-invalid @enderror" id="imam"
                        name="imam" value="{{ old('imam', $data->imam) }}" placeholder="Masukkan nama imam">
                    @error('imam')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="muadzin">Muadzin</label>
                    <input type="text" class="form-control @error('muadzin') is-invalid @enderror" id="muadzin"
                        name="muadzin" value="{{ old('muadzin', $data->muadzin) }}" placeholder="Contoh: Ketua DKM">
                    @error('muadzin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('petugas.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection
