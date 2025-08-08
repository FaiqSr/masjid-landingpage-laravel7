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

        <section class="pt-5 pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="fw-bold">Cek Status & Cetak Bukti Pendaftaran</h2>
                    <p class="text-muted mb-4">Masukkan Nomor Induk Kependudukan (NIK) calon siswa yang terdaftar untuk melihat detail dan mengunduh bukti pendaftaran.</p>
                    
                    <form action="{{ route('ppdb.search') }}" method="POST">
                        @csrf
                        <div class="input-group input-group-lg shadow-sm">
                            <input type="text" class="form-control" name="nik" placeholder="Masukkan 16 digit NIK Calon Siswa..." style="border-radius: 0;" required minlength="16" maxlength="16" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            <button class="btn" style="border-radius: 0; color: #007c6c; border: 2px solid #007c6c;" type="submit">
                                <i class="fas fa-search me-2"></i>Cari Pendaftaran
                            </button>
                        </div>
                    </form>

                    @if (session('error'))
                        <div class="alert alert-danger mt-3 shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    
    @php
        $berita = DB::table('news')->limit(12)->get();
    @endphp
    <section class="container pt-5 pb-5">
        <div style="width: fit-content;">
            <h2
                style="border: 2px solid #007c6c; padding: 0.5rem 1rem; color: #007c6c; font-weight: 300; font-size: 1.5rem;">
                Berita Sekolah</h2>
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
