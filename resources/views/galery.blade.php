@extends('main_blog')

@section('title', 'Galeri Kami')

@section('content')

    <div class="container py-4 py-xl-5">
        <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
            @forelse ($data as $item)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        @if ($item->image_url)
                            {{-- Asumsi kolom gambar adalah 'image_url' --}}
                            <img class="card-img-top" src="{{ asset('img/uploads/' . $item->image_url) }}"
                                alt="{{ $item->title ?? 'Foto Galeri' }}" style="object-fit: cover; height: 250px;">
                        @else
                            {{-- Fallback image jika image_url kosong. Pastikan Anda memiliki file public/img/empty.png --}}
                            <img class="card-img-top" src="{{ asset('img/empty.png') }}" alt="No Image Available"
                                style="object-fit: cover; height: 250px;">
                        @endif
                        <div class="card-body p-3">
                            <h5 class="card-title mb-0">{{ $item->title ?? 'Foto Galeri' }}</h5>
                            @if (isset($item->description))
                                {{-- Asumsi kolom deskripsi adalah 'description' --}}
                                <p class="card-text text-muted small mt-1">{{ Str::limit($item->description, 70) }}</p>
                            @endif
                        </div>
                        <div class="card-footer bg-white border-top-0 pt-0">
                            {{-- Tombol untuk melihat gambar lebih besar (opsional, bisa diubah ke modal) --}}
                            <a href="{{ asset('img/uploads/' . $item->image_url) }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                Lihat Gambar <i class="fas fa-external-link-alt ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada gambar di galeri.</p>
                </div>
            @endforelse
            test
        </div>
    </div>
@endsection
