@extends('layout.main')
@section('title', 'Detail Laporan: ' . $header->akun)

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Detail Laporan Keuangan</h1>
        </div>
    </div>
@endsection

@section('content')
    {{-- Informasi Header --}}
    <div class="card card-widget widget-user-2">
        <div class="widget-user-header bg-info">
            <h3 class="widget-user-username">{{ $header->akun }}</h3>
            <h5 class="widget-user-desc">Periode: {{ \Carbon\Carbon::parse($header->periode)->translatedFormat('F Y') }}</h5>
        </div>
        <div class="card-footer p-0">
            <ul class="nav flex-column">
                <li class="nav-item"><a href="#" class="nav-link">Saldo Awal <span
                            class="float-right badge bg-primary">Rp
                            {{ number_format($header->saldo_awal, 0, ',', '.') }}</span></a></li>
                <li class="nav-item"><a href="#" class="nav-link">Total Debet (Masuk) <span
                            class="float-right badge bg-success">Rp
                            {{ number_format($header->total_debet, 0, ',', '.') }}</span></a></li>
                <li class="nav-item"><a href="#" class="nav-link">Total Kredit (Keluar) <span
                            class="float-right badge bg-danger">Rp
                            {{ number_format($header->total_kredit, 0, ',', '.') }}</span></a></li>
                <li class="nav-item"><a href="#" class="nav-link"><strong>Saldo Akhir</strong> <span
                            class="float-right badge bg-dark"><strong>Rp
                                {{ number_format($header->saldo_akhir, 0, ',', '.') }}</strong></span></a></li>
            </ul>
        </div>
    </div>

    {{-- Form Tambah Transaksi --}}
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Transaksi Baru</h3>
        </div>
        <form action="{{ route('keuangan.detail.store', $header->id) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal_transaksi"
                            class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                            value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-5 form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan"
                            class="form-control @error('keterangan') is-invalid @enderror"
                            placeholder="Contoh: Infaq Jumat, Bayar Listrik">
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Tipe</label>
                        <select name="tipe" class="form-control @error('tipe') is-invalid @enderror">
                            <option value="D">Debet (Masuk)</option>
                            <option value="K">Kredit (Keluar)</option>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Nilai (Rp)</label>
                        <input type="number" name="nilai" class="form-control @error('nilai') is-invalid @enderror"
                            min="1">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Kembali ke Daftar Laporan</a>
            </div>
        </form>
    </div>

    {{-- Tabel Detail Transaksi --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Rincian Transaksi</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="20px">No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detail as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->translatedFormat('d F Y') }}</td>
                            <td>{{ $item->keterangan }}</td>
                            @if ($item->tipe == 'D')
                                <td class="text-success">Rp {{ number_format($item->nilai, 0, ',', '.') }}</td>
                                <td></td>
                            @else
                                <td></td>
                                <td class="text-danger">Rp {{ number_format($item->nilai, 0, ',', '.') }}</td>
                            @endif
                            <td>
                                <a href="{{ route('keuangan.detail.destroy', $item->id) }}" class="btn btn-xs btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus transaksi ini?')"><i
                                        class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        @if (session('sukses'))
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: ' &nbsp; {{ session('sukses') }}'
            });
        @endif
        @if ($errors->any())
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
            });
            Toast.fire({
                icon: 'error',
                title: ' &nbsp; Gagal menambahkan transaksi, periksa kembali isian Anda.'
            });
        @endif
    </script>
@endsection
