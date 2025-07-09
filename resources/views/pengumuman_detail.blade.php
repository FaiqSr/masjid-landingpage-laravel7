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
    <div class="container py-4 py-xl-5">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
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
                        <a href="{{ route('beranda') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
