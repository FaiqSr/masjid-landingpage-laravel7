@extends('main_blog')

{{-- Judul halaman tetap nama layanan --}}
@section('title', $layanan->nama)

@section('content')
    <div class="container py-4 py-xl-5">

        <div class="row">


            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        {{-- Judul Layanan --}}
                        <h1 class="card-title mb-3" style="font-family: 'Times New Roman', Times, serif;">
                            {{ $layanan->nama }}
                        </h1>

                        {{-- Meta Info: Tanggal & Petugas --}}
                        <div class="d-flex flex-wrap align-items-center mb-4 border-bottom pb-3">
                            <small class="text-muted me-3">
                                <i class="fas fa-calendar-alt me-2"></i>Dibuat pada
                                {{ \Carbon\Carbon::parse($layanan->created_at)->translatedFormat('d F Y') }}
                            </small>
                            <small class="text-muted me-3">
                                <i class="fas fa-user me-2"></i>Petugas: <strong>{{ $layanan->petugas }}</strong>
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-phone me-2"></i>Kontak: <strong>{{ $layanan->kontak }}</strong>
                            </small>
                        </div>

                        @if ($layanan->foto)
                            <div class="mb-4 text-center">
                                <img src="{{ asset('public/img/layanan/' . $layanan->foto) }}" class="img-fluid"
                                    alt="Foto Layanan {{ $layanan->nama }}" style="max-height: 400px;">
                            </div>
                        @endif

                        <div class="article-content">
                            <p>Informasi detail mengenai layanan <strong>{{ $layanan->nama }}</strong>. Untuk keterangan
                                lebih lanjut, silakan hubungi petugas yang bersangkutan melalui nomor kontak yang tertera.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Berita Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @php
                            // Mengambil 5 berita terakhir dari database
                            $recent_news = DB::table('news')->orderBy('created_at', 'desc')->limit(5)->get();
                        @endphp

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
                                            {{ \Carbon\Carbon::parse($news_item->created_at)->translatedFormat('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                                @if (!$loop->last)
                                    <hr class="my-2">
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted">Belum ada berita.</p>
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
