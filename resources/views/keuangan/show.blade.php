@extends('main_blog')

@section('title', 'Detail Laporan: ' . $header->akun)

@section('content')
    <div class="container pt-5 py-xl-5">

        {{-- Judul Halaman --}}
        <div class="row mb-4 pt-5">
            <div class="col">
                <h1 class="text-center" style="font-family: 'Times New Roman', Times, serif;">Detail Laporan Keuangan</h1>
                <h4 class="text-center text-muted">{{ $header->akun }} - Periode
                    {{ \Carbon\Carbon::parse($header->periode)->translatedFormat('F Y') }}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                {{-- Ringkasan Laporan --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between"><span>Saldo Awal</span> <span
                                    class="fw-bold">Rp {{ number_format($header->saldo_awal, 2, ',', '.') }}</span></li>
                            <li class="list-group-item d-flex justify-content-between"><span>Total Pemasukan (Debet)</span>
                                <span class="text-success fw-bold">Rp
                                    {{ number_format($header->total_debet, 2, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between"><span>Total Pengeluaran
                                    (Kredit)</span> <span class="text-danger fw-bold">Rp
                                    {{ number_format($header->total_kredit, 2, ',', '.') }}</span></li>
                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <h4>Saldo Akhir</h4>
                                <h4 class="fw-bold">Rp {{ number_format($header->saldo_akhir, 2, ',', '.') }}</h4>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Tabel Rincian Transaksi --}}
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Rincian Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="20px">No</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th class="text-end">Debet (Masuk)</th>
                                        <th class="text-end">Kredit (Keluar)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($detail as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->translatedFormat('d M Y') }}
                                            </td>
                                            <td>{{ $item->keterangan }}</td>
                                            @if ($item->tipe == 'D')
                                                <td class="text-end text-success">Rp
                                                    {{ number_format($item->nilai, 2, ',', '.') }}</td>
                                                <td class="text-end"></td>
                                            @else
                                                <td class="text-end"></td>
                                                <td class="text-end text-danger">Rp
                                                    {{ number_format($item->nilai, 2, ',', '.') }}</td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Belum ada rincian
                                                transaksi untuk periode ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('keuangan.list') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Laporan
                    </a>
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">

                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Berita Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @forelse($recent_news as $news_item)
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('public/img/uploads/' . $news_item->image_url) }}"
                                    alt="{{ $news_item->title }}" class="me-3 rounded"
                                    style="width: 70px; height: 70px; object-fit: cover;">
                                <div>
                                    <a href="{{ route('artikel.detail', $news_item->slug) }}"
                                        class="text-decoration-none text-dark fw-bold" style="font-size: 0.9rem;">
                                        {{ Str::limit($news_item->title, 55, '...') }}
                                    </a>
                                    <p class="small text-muted mb-0">
                                        {{ \Carbon\Carbon::parse($news_item->created_at)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr class="my-2">
                            @endif
                        @empty
                            <p class="text-muted">Tidak ada berita lainnya.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
