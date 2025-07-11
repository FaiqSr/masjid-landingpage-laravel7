@extends('main_blog')

@section('title', 'Galeri Kami')

@section('top-style')

    <style>
        .gallery-item {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 128, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: translateY(100%);
            transition: all 0.4s ease;
        }

        .gallery-item:hover .overlay {
            opacity: 1;
            transform: translateY(0);
        }

        .overlay-text {
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="container pt-5 py-xl-5">

        <div class="row mb-4 pt-5">
            <div class="col">
                <h1 class="text-center" style="font-family: 'Times New Roman', Times, serif;">Layanan Masjid</h1>
            </div>
        </div>

        <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">

            @if ($data->isNotEmpty())
                @foreach ($data as $layanan)
                    <a class="col-md-3" href="{{ route('layanan.detail', $layanan->id) }}">
                        <div class="gallery-item">
                            <div style="height: 200px;">
                                <img src="{{ asset('public/img/layanan/' . $layanan->foto) }}" alt="Gambar"
                                    class="w-100 h-100 object-fit-cover">
                            </div>
                            <div class="overlay">
                                <div class="overlay-text">{{ $layanan->nama }}</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="" style="flex: 0 0 auto; width: 100%;">
                    <div class="alert alert-warning text-center">
                        Belum ada layanan yang dipublikasikan.
                    </div>
                </div>
            @endif


        </div>
        <div class="row mt-5">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item {{ $data->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $data->previousPageUrl() }}" aria-label="Previous">Back</a>
                    </li>

                    @for ($i = 1; $i <= $data->lastPage(); $i++)
                        <li class="page-item {{ $data->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <li class="page-item {{ $data->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $data->nextPageUrl() }}" aria-label="Next">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

@endsection
