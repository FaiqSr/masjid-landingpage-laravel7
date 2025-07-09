@extends('main_blog')

@section('title', 'Beranda')

@section('top-style')
    <style>
        /* Common */
        p {
            margin: 0;
        }

        /* Hero Carousel */
        .carousel,
        .carousel-item,
        .hero-image {
            height: 75vh;
            width: 100%;
        }

        .hero-image {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .carousel-indicators.custom-indicators {
            position: absolute;
            bottom: 20px;
            z-index: 10;
        }

        .carousel-indicators.custom-indicators button {
            width: 12px;
            height: 12px;
            margin: 0 5px;
            border: 2px solid white;
            background-color: rgba(200, 200, 200, 0.5);
            border-radius: 50%;
            opacity: 1;
            transition: background-color 0.3s ease;
        }

        .carousel-indicators.custom-indicators button.active {
            background-color: white;
        }

        .carousel-control-prev,
        .carousel-control-next {
            display: none;
        }

        .info-wrapper-section {
            padding-bottom: 150px;
            background-color: #007c6c;
        }

        .info-wrapper {
            display: flex;
            /* Menggunakan flexbox */
            flex-wrap: wrap;
            /* Izinkan wrapping di layar kecil */
            align-items: center;
            /* Menyelaraskan item secara vertikal */
            position: absolute;
            top: -90px;
            /* Naikkan sedikit agar lebih menonjol */
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            width: 90%;
            /* Perlebar sedikit */
            max-width: 1140px;
            padding: 2rem 1rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            /* Tambah shadow agar lebih hidup */
        }

        .info-wrapper .info-col {
            /* Kolom akan memakan ruang yang sama */
            flex: 1;
            padding: 0 15px;
            min-width: 280px;
            /* Lebar minimum sebelum wrapping */
        }


        .info-wrapper .title {
            margin: 0;
            font-weight: 600;
        }

        .info-wrapper .address {
            font-size: 1rem;
            text-align: justify;
        }

        .management-swiper {
            width: 100%;
            /* Pastikan kolom swiper mengambil lebar penuh dari jatahnya */
            min-height: 80px;
            /* Beri tinggi minimum agar tidak collapse */
        }

        .pengurus-swiper {
            width: 100%;
            height: 100%;
        }

        .pengurus-swiper .swiper-slide {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .pengurus-swiper .swiper-slide img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .pengurus-swiper .swiper-button-next,
        .pengurus-swiper .swiper-button-prev {
            color: #333;
            --swiper-navigation-size: 22px;
        }



        /* Responsivitas untuk Info Wrapper */
        @media (max-width: 991px) {
            .info-wrapper-section {
                padding-bottom: 0;
            }

            .info-wrapper {
                position: relative;
                /* Kembali ke alur normal di layar kecil */
                top: 0;
                transform: none;
                left: 0;
                width: 100%;
                flex-direction: column;
                align-items: initial;
                /* Susun ke bawah */
                gap: 2rem;
                /* Beri jarak antar item */
                margin-top: -50px;
                /* Tetap menimpa header */
                border-radius: 0;
            }
        }

        /* === AKHIR PERBAIKAN === */


        /* Petugas Harian & Layanan Section */
        .petugas-harian-section,
        .layanan-section {
            background-color: #f7ebd2;
        }

        .layanan-section {
            background-color: #ffffff;
        }

        .card-petugas,
        .card-layanan {
            border-radius: 1rem;
            overflow: hidden;
            border: none;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .petugas-swiper .swiper-pagination-bullet-active,
        .layanan-swiper .swiper-pagination-bullet-active {
            background: #007c6c;
        }

        /* Gallery Section */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            cursor: pointer;
            height: 200px;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-item .overlay {
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
            padding: 1rem;
        }
    </style>
@endsection
@section('content')

    {{-- Bagian Header dengan Carousel --}}
    <header class="bg-primary-gradient position-relative">
        @php
            $sliders = DB::table('sliders')->get();
        @endphp
        <div id="carouselHero" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators custom-indicators">
                @foreach ($sliders as $index => $item)
                    <button type="button" data-bs-target="#carouselHero" data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($sliders as $index => $item)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="hero-image"
                            style="background-image: url('{{ url('public/img/uploads/' . $item->image_url) }}');"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </header>

    {{-- Bagian Info Wrapper (Alamat, Pengurus, Kontak) --}}
    <section class="info-wrapper-section">
        <section class="w-full position-relative">
            @php
                $pengurus = DB::table('pengurus')->get();
            @endphp
            <div class="info-wrapper">
                <div class="info-col">
                    <p class="title">Masjid Agung Kesultanan Jogja</p>
                    <p class="address mt-1">
                        Jl. Rusunawa Pesakih No.14, RT.3/RW.14, Duri Kosambi, Kecamatan Cengkareng, Kota Jakarta Barat,
                        Daerah Khusus Ibukota Jakarta 11750
                    </p>
                </div>

                <div class="info-col management-swiper">
                    <div class="swiper pengurus-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($pengurus as $item)
                                <div class="swiper-slide">
                                    <div>
                                        <img src="{{ asset('public/img/pengurus/' . $item->foto) }}"
                                            alt="Foto {{ $item->nama }}" class="rounded">
                                    </div>
                                    <div>
                                        <p class="fs-3 fw-bold m-0">{{ $item->nama }}</p>
                                        <p class="m-0 small">{{ $item->jabatan }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="info-col">
                    <p class="fw-bold fs-3">Pusat Info Masjid</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="fs-3 text-dark"><i class="fa-brands fa-whatsapp"
                                style="color: #007c6c;"></i></a>
                        <a href="#" class="fs-3 text-dark"><i class="fa-brands fa-facebook"
                                style="color: #007c6c;"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </section>

    {{-- Bagian Petugas Harian --}}
    <section class="petugas-harian-section pt-5 pb-4">
        <div class="container">
            <div class="pb-2 d-flex justify-content-center">
                <h2 class="fw-light mb-2 text-center px-3 py-1 "
                    style="width: fit-content; border: 2px solid #007c6c; border-radius: 0.8rem; color: #007c6c; ">
                    Petugas Harian
                </h2>
            </div>
            @php
                $petugasHarian = DB::table('petugas_harian')->get();
            @endphp
            @if ($petugasHarian->isNotEmpty())
                <div class="swiper petugas-swiper">
                    <div class="swiper-wrapper py-4">
                        @foreach ($petugasHarian as $item)
                            <div class="swiper-slide">
                                <div class="card card-petugas shadow-sm">
                                    <div class="card-header text-light fw-bold text-center"
                                        style="background-color: #007c6c;">
                                        <h5 class="mb-0 py-1">{{ $item->waktu }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <p>{{ $item->imam }}</p>
                                            <p class="text-muted small">Imam</p>
                                        </div>
                                        <hr class="my-2">
                                        <div class="d-flex justify-content-between">
                                            <p>{{ $item->muadzin }}</p>
                                            <p class="text-muted small">Muadzin</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <p>Jadwal petugas harian belum tersedia.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Bagian Layanan Masjid --}}
    @php
        $layanan = DB::table('layanan')->get();
    @endphp
    <section class="container layanan-section pt-5">
        <div style="width: fit-content;">
            <h2
                style="border: 2px solid #007c6c; padding: 0.5rem 1rem; color: #007c6c; font-weight: 300; font-size: 1.5rem;">
                Layanan Masjid</h2>
        </div>

        @if ($layanan->isNotEmpty())
            <div class="swiper layanan-swiper mt-2 mb-4">
                <div class="swiper-wrapper py-4">
                    @foreach ($layanan as $item)
                        <a class="swiper-slide" href="{{ route('layanan.detail', $item->id) }}">
                            <div class="card card-layanan text-center shadow-sm h-100" style="border-radius: 0;">
                                <div class="d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <img src="{{ url('public/img/layanan/' . $item->foto) }}"
                                        alt="Ikon {{ $item->nama }}"
                                        style="max-height: 100%; width: 100%; object-fit: cover;">
                                </div>
                                <div class="card-body pt-4 pb-5" style="background-color: #007c6c;">
                                    <h5 class="card-title fw-bold" style="color: white;">{{ $item->nama }}</h5>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center text-muted mt-5">
                <p>Informasi layanan belum tersedia.</p>
            </div>
        @endif
    </section>

    {{-- Pengumuman --}}
    @php
        // Mengambil 2 pengumuman terakhir berdasarkan tanggal pembuatan
        $pengumuman = DB::table('pengumuman')->orderBy('created_at', 'desc')->limit(2)->get();
    @endphp

    <section class="pengumuman-container pt-5 pb-5" style="background-color: #19ac98;">
        <section class="container">
            {{-- Menggunakan Grid Bootstrap untuk responsivitas --}}
            <div class="row align-items-center g-4">

                <div class="col-lg-6">
                    {{-- Kontainer gambar dibuat relatif untuk posisi overlay --}}
                    <div style="position: relative; border-radius: 1rem; overflow: hidden; height: 350px;">
                        @if ($pengumuman->isNotEmpty())
                            {{-- Mengambil gambar dari pengumuman pertama --}}
                            <img src="{{ asset('public/img/pengumuman/' . $pengumuman->first()->foto) }}"
                                alt="Pengumuman Terbaru" class="w-100 h-100 object-fit-cover">
                        @else
                            {{-- Gambar fallback jika tidak ada pengumuman --}}
                            <img src="{{ asset('public/image/galery/1750964242_beautiful-anime-sakura-cityscape-cartoon-scene.jpg') }}"
                                alt="Pengumuman" class="w-100 h-100 object-fit-cover">
                        @endif

                        <div
                            style="position: absolute; bottom: 0; left: 0; right: 0; padding: 1.5rem; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                            <h3 class="text-white fw-bold">Pengumuman Terbaru</h3>
                            <p class="text-white mb-0">Masjid Iman Kuat</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div style="border: 2px solid #ffffff; border-radius: 2rem; width: fit-content;" class="px-4 py-1 mb-4">
                        <h2 style="color: white; margin: 0;">Pengumuman</h2>
                    </div>

                    @if ($pengumuman->isNotEmpty())
                        @foreach ($pengumuman as $item)
                            <div class="mb-3">
                                <h4 class="text-white fw-bold">{{ $item->name }}</h4>
                                {{-- Konten dipotong agar tidak terlalu panjang, dan tag HTML dihapus --}}
                                <p class="text-white-50">
                                    {{ Str::limit(strip_tags($item->content), 150, '...') }}
                                </p>
                                <a href="{{ url('pengumuman/' . $item->slug) }}"
                                    class="btn btn-outline-light btn-sm mt-2">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                            {{-- Memberi garis pemisah jika ini bukan item terakhir --}}
                            @if (!$loop->last)
                                <hr class="text-white-50 my-4">
                            @endif
                        @endforeach
                    @else
                        <p class="text-white-50">Belum ada pengumuman terbaru saat ini.</p>
                    @endif
                </div>
            </div>
        </section>
    </section>


    @php
        $berita = DB::table('news')->limit(12)->get();
    @endphp
    <section class="container pt-5 pb-5">
        <div style="width: fit-content;">
            <h2
                style="border: 2px solid #007c6c; padding: 0.5rem 1rem; color: #007c6c; font-weight: 300; font-size: 1.5rem;">
                Berita Masjid</h2>
        </div>

        @if ($berita->isNotEmpty())
            <div class="row g-4 mt-2">
                @foreach ($berita as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ url('artikel/' . $item->slug) }}" class="text-decoration-none text-dark">
                            <div class="card shadow-sm h-100">
                                <img src="{{ url('public/img/uploads/' . $item->image_url) }}" class="card-img-top"
                                    alt="{{ $item->title }}" style="height: 180px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <p class="small text-muted mb-2">
                                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</p>
                                    <h5 class="card-title fw-bold"
                                        style="font-family: 'Times New Roman', Times, serif; flex-grow: 1;">
                                        {{ Str::limit($item->title, 60, '...') }}
                                    </h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-muted my-5">
                <p>Informasi berita belum tersedia.</p>
            </div>
        @endif
    </section>
@endsection

@section('bottom-script')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi untuk Swiper Pengurus
            var pengurusSwiper = new Swiper(".pengurus-swiper", {
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });

            // Inisialisasi untuk Swiper Petugas Harian
            var petugasSwiper = new Swiper(".petugas-swiper", {
                slidesPerView: 1.2,
                spaceBetween: 16,
                loop: false,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2
                    },
                    768: {
                        slidesPerView: 3
                    },
                    992: {
                        slidesPerView: 4
                    },
                    1200: {
                        slidesPerView: 5
                    },
                },
            });

            // Inisialisasi Swiper untuk Layanan
            var layananSwiper = new Swiper(".layanan-swiper", {
                loop: true,
                slidesPerView: 1.5,
                spaceBetween: 24,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    992: {
                        slidesPerView: 4,
                    },
                },
            });
        });
    </script>
@endsection
