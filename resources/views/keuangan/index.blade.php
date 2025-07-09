@extends('main_blog')

@section('title', 'Laporan Keuangan Masjid')

@section('content')
    <div class="container pt-5 py-xl-5">

        {{-- Judul Halaman --}}
        <div class="row mb-4 pt-5">
            <div class="col">
                <h1 class="text-center" style="font-family: 'Times New Roman', Times, serif;">Laporan Keuangan Masjid</h1>
                <p class="text-center text-muted">Transparansi dana umat untuk kemaslahatan bersama.</p>
            </div>
        </div>

        {{-- Tabel Daftar Laporan --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Nama Laporan / Akun</th>
                                <th class="text-end">Saldo Akhir</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporan as $item)
                                <tr>
                                    <td class="fw-bold">{{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}
                                    </td>
                                    <td>
                                        {{ $item->akun }}
                                        <br>
                                        <small class="text-muted">{{ $item->keterangan }}</small>
                                    </td>
                                    <td class="text-end fw-bold">Rp {{ number_format($item->saldo_akhir, 2, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('keuangan.detail', $item->id) }}" class="btn btn-sm btn-primary">
                                            Lihat Rincian
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Belum ada laporan keuangan yang dipublikasikan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tautan Pagination --}}
        <div class="row mt-4">
            <div class="col d-flex justify-content-center">
                {{ $laporan->links() }}
            </div>
        </div>

    </div>
@endsection
