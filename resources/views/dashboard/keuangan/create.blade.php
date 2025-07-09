@extends('layout.main')
@section('title', 'Buat Laporan Keuangan Baru')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Buat Laporan Baru</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('keuangan.index') }}">Keuangan</a></li>
                <li class="breadcrumb-item active">Buat Laporan</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Laporan Keuangan</h3>
        </div>
        <form action="{{ route('keuangan.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    {{-- Kolom Periode Laporan --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="periode">Periode Laporan</label>
                            <input type="date" class="form-control @error('periode') is-invalid @enderror" id="periode"
                                name="periode" value="{{ old('periode', date('Y-m-01')) }}">
                            <small class="form-text text-muted">Pilih tanggal awal bulan untuk periode laporan.</small>
                            @error('periode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- Kolom Akun --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="akun">Nama Laporan / Akun</label>
                            <input type="text" class="form-control @error('akun') is-invalid @enderror" id="akun"
                                name="akun" value="{{ old('akun') }}"
                                placeholder="Contoh: Kas Masjid, Dana Anak Yatim">
                            @error('akun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan (Opsional)</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan"
                        value="{{ old('keterangan') }}" placeholder="Contoh: Laporan bulanan operasional masjid">
                </div>

                <div class="form-group">
                    <label for="saldo_awal_display">Saldo Awal</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        {{-- Input yang dilihat pengguna, dengan format --}}
                        <input type="text" class="form-control @error('saldo_awal') is-invalid @enderror"
                            id="saldo_awal_display"
                            value="{{ old('saldo_awal') ? number_format(old('saldo_awal'), 0, ',', '.') : 0 }}">
                        {{-- Input tersembunyi untuk mengirim nilai angka asli ke server --}}
                        <input type="hidden" name="saldo_awal" id="saldo_awal" value="{{ old('saldo_awal', 0) }}">
                    </div>
                    @error('saldo_awal')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Buat Laporan</button>
                <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        // Script untuk format angka otomatis pada input Saldo Awal
        const saldoDisplay = document.getElementById('saldo_awal_display');
        const saldoHidden = document.getElementById('saldo_awal');

        saldoDisplay.addEventListener('keyup', function(e) {
            // 1. Ambil nilai, hapus semua karakter kecuali angka
            let rawValue = e.target.value.replace(/[^0-9]/g, '');

            // 2. Simpan nilai angka asli ke input tersembunyi
            saldoHidden.value = rawValue === '' ? 0 : rawValue;

            // 3. Format nilai dengan pemisah ribuan untuk ditampilkan
            if (rawValue) {
                const formattedValue = new Intl.NumberFormat('id-ID').format(rawValue);
                e.target.value = formattedValue;
            } else {
                e.target.value = '';
            }
        });
    </script>
@endsection
