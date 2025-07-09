@extends('main_blog')

@section('title', 'Daftar Pengumuman')

@section('content')
    <div class="container pt-5 py-xl-5">

        {{-- Judul Halaman --}}
        <div class="row mb-4 pt-5">
            <div class="col">
                <h1 class="text-center" style="font-family: 'Times New Roman', Times, serif;">Pengumuman Masjid</h1>
                <p class="text-center text-muted">Informasi dan pengumuman terbaru seputar kegiatan masjid.</p>
            </div>
        </div>

        {{-- Daftar Kartu Pengumuman --}}
        <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-lg-3">
            @if ($pengumuman->isNotEmpty())
                @foreach ($pengumuman as $item)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <a href="{{ route('pengumuman.detail', $item->slug) }}">
                                <img class="card-img-top w-100 d-block fit-cover" style="height: 200px;"
                                    src="{{ asset('public/img/pengumuman/' . $item->foto) }}" alt="{{ $item->name }}">
                            </a>
                            <div class="card-body p-4 d-flex flex-column">
                                <h4 class="card-title">{{ Str::limit($item->name, 50, '...') }}</h4>
                                <p class="card-text text-muted mb-4">
                                    {{ Str::limit(strip_tags($item->content), 100, '...') }}
                                </p>

                                {{-- Tombol dan Tanggal di bagian bawah kartu --}}
                                <div class="mt-auto">
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a class="btn btn-outline-primary btn-sm"
                                            href="{{ route('pengumuman.detail', $item->slug) }}">
                                            Baca Selengkapnya
                                        </a>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        Belum ada pengumuman yang dipublikasikan.
                    </div>
                </div>
            @endif
        </div>

        {{-- Tautan Pagination --}}
        <div class="row mt-5">
            <div class="col d-flex justify-content-center">
                {{ $pengumuman->links() }}
            </div>
        </div>

    </div>
@endsection
