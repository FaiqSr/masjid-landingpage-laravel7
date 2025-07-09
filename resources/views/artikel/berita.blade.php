@extends('main_blog')

@section('title', 'berita')

@section('content')
    <div class="container pt-5 py-xl-5">

        <div class="row mb-4 pt-5">
            <div class="col">
                <h1 class="text-center" style="font-family: 'Times New Roman', Times, serif;">Berita Masjid</h1>
                <p class="text-center text-muted">Berita terbaru seputar kegiatan masjid.</p>
            </div>
        </div>

        <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
            @foreach ($data as $item)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        @if ($item->image_url)
                            <img class="card-img-top" src="{{ asset('public/img/uploads/' . $item->image_url) }}"
                                alt="Thumbnail Berita" style="object-fit: cover; height: 200px;">
                        @else
                            <img class="card-img-top" src="{{ asset('img/empty.png') }}" alt="No Image Available"
                                style="object-fit: cover; height: 200px;">
                        @endif
                        <div class="card-body p-4">
                            <h4 class="card-title">{{ $item->title }}</h4>
                            <p class="card-text text-muted small mb-2">
                                <i class="far fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                            </p>
                            <p class="card-text">{!! Str::limit(strip_tags($item->content), 150, '...') !!}</p>
                        </div>
                        <div class="card-footer bg-white border-top-0 pt-0">
                            <a href="{{ route('artikel.detail', $item->slug) }}" class="btn btn-success btn-sm">
                                Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mt-5">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center mb-0">
                    {{-- Tombol "Previous" --}}
                    <li class="page-item {{ $data->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $data->previousPageUrl() }}" aria-label="Previous">Back</a>
                    </li>

                    {{-- Nomor halaman --}}
                    @for ($i = 1; $i <= $data->lastPage(); $i++)
                        <li class="page-item {{ $data->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    {{-- Tombol "Next" --}}
                    <li class="page-item {{ $data->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $data->nextPageUrl() }}" aria-label="Next">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
