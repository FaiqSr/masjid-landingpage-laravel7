@extends('main_blog')

@section('title', $new->title)

@section('top-style')
    <style>
        /* Menjaga gambar di dalam konten agar responsif */
        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
        }

        .article-content {
            line-height: 1.8;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4 py-xl-5">
        <div class="row">

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        {{-- Judul Berita --}}
                        <h1 class="card-title mb-3">{{ $new->title }}</h1>

                        {{-- Meta Info: Foto Admin dan Tanggal --}}
                        <div class="d-flex align-items-center mb-3 border-bottom pb-3">
                            @if ($new->admin_photo_url)
                                <img src="{{ asset('public/img/uploads/' . $new->admin_photo_url) }}"
                                    class="rounded-circle me-3" alt="Foto Admin"
                                    style="width: 45px; height: 45px; object-fit: cover;">
                            @endif
                            <small class="text-muted">
                                Diposting pada {{ \Carbon\Carbon::parse($new->created_at)->translatedFormat('d F Y') }}
                            </small>
                        </div>

                        {{-- Gambar Utama Berita --}}
                        @if ($new->image_url)
                            <div class="mb-4 text-center">
                                <img src="{{ asset('public/img/uploads/' . $new->image_url) }}" class="img-fluid rounded"
                                    alt="Thumbnail Berita" style="max-height: 450px;">
                            </div>
                        @endif

                        {{-- Konten Berita --}}
                        <div class="article-content mt-4">
                            {!! $new->content !!}
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Berita Lainnya</h5>
                    </div>
                    <div class="card-body">
                        @if ($recent_news->isNotEmpty())
                            @foreach ($recent_news as $news_item)
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
                                            {{ \Carbon\Carbon::parse($news_item->created_at)->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                @if (!$loop->last)
                                    <hr class="my-2">
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted">Tidak ada berita lainnya.</p>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('artikel') }}" class="btn btn-outline-success w-100">
                                Lihat Semua Berita <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
