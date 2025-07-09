@extends('main_blog')

@section('title', $pengumuman->name)

@section('top-style')
    <style>
        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .article-content {
            line-height: 1.8;
            color: #333;
        }
    </style>
@endsection

@section('content')
    <div class="container pt-5 py-xl-5">
        <div class="row g-4 pt-5">

            <div class="col-lg-8">
                <div class="card border-0">
                    <div class="card-body p-4">

                        <h1 class="card-title mb-3" style="font-family: 'Times New Roman', Times, serif;">
                            {{ $pengumuman->name }}</h1>

                        <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-2"></i>Diposting pada
                                {{ \Carbon\Carbon::parse($pengumuman->created_at)->translatedFormat('l, d F Y') }}
                            </small>
                        </div>

                        @if ($pengumuman->foto)
                            <div class="mb-4 text-center">
                                <img src="{{ asset('public/img/pengumuman/' . $pengumuman->foto) }}"
                                    class="img-fluid rounded shadow-sm" alt="Gambar Utama {{ $pengumuman->name }}"
                                    style="max-height: 450px;">
                            </div>
                        @endif

                        <div class="article-content mt-4">
                            {!! $pengumuman->content !!}
                        </div>

                        <hr class="my-4">

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('pengumuman') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Lihat Semua Pengumuman
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 pt-5 ">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Pengumuman Lainnya</h5>
                    </div>
                    <div class="card-body">
                        @forelse($other_announcements as $item)
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('public/img/pengumuman/' . $item->foto) }}" alt="{{ $item->name }}"
                                    class="me-3 rounded" style="width: 70px; height: 70px; object-fit: cover;">
                                <div>
                                    <a href="{{ route('pengumuman.detail', $item->slug) }}"
                                        class="text-decoration-none text-dark fw-bold" style="font-size: 0.9rem;">
                                        {{ Str::limit($item->name, 55, '...') }}
                                    </a>
                                    <p class="small text-muted mb-0">
                                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr class="my-2">
                            @endif
                        @empty
                            <p class="text-muted">Tidak ada pengumuman lainnya.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
