@php
    // Mengambil data pengaturan sekali di atas untuk digunakan di seluruh halaman
    $setting = DB::table('tbl_setting')->first();
@endphp
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title') - {{ $setting->nama ?? 'Website Masjid' }}</title>

    @if ($setting && $setting->icon)
        <link rel="icon" type="image/png" href="{{ asset('public/img/settings/' . $setting->icon) }}">
    @else
        {{-- Ikon default jika tidak ada di pengaturan --}}
        <link rel="icon" type="image/png" href="{{ asset('public/img/default_icon.png') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('public/theme/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('public/theme/css/swiper-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/css/Articles-Cards-images.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/css/Features-Cards-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/css/Simple-Slider-swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/css/Simple-Slider.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('top-style')

    {{-- STYLING ASLI DARI ANDA (TIDAK ADA PERUBAHAN) --}}
    <style>
        body {
            font-family: 'fira-sans', 'Times New Roman', Times, serif;
        }


        .navbar-custom {
            background-color: #ffffff;
            transition: none;
            padding: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-custom .nav-link {
            color: #333;
            margin-left: 15px;
            font-weight: 500;
        }

        .navbar-custom .nav-link:hover {
            color: #6c63ff;
            /* Ungu muda */
        }

        .navbar-custom .navbar-brand img {
            height: 50px;
        }

        body {
            padding-top: 7.5rem;
        }

        .running-text-container {
            background-color: #007c6c;
            overflow: hidden;
            width: 100%;
            white-space: nowrap;
            position: relative;
        }

        .running-text-content {
            display: inline-block;
            animation: marquee 30s linear infinite;
            padding-left: 100%;
            color: #333;
            font-weight: 500;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        @media (min-width: 991px) {
            .navbar-custom {
                display: flex;
                flex-direction: column;
            }

            .running-text-content {
                display: inline-block;
                animation: marquee 30s linear infinite;
                padding-left: 83%;
                color: #333;
                font-weight: 500;
            }
        }

        .running-text-content:hover {
            animation-play-state: running;
        }

        #prayer-times-section {
            position: absolute;
            bottom: -70px;
        }

        .location-date {
            display: flex;
            gap: 2rem;
        }

        .location-date strong {
            font-size: 1rem;
            color: #343a40;
        }

        .prayer-time .name {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .prayer-time .time {
            font-size: 1.1rem;
            color: #007c6c;
        }

        .prayer-time:nth-child(odd) {
            background-color: #f8f9fa;
        }

        .prayer-time:nth-child(even) {
            background-color: #e9ecef;
        }

        @media (max-width: 990px) {
            body {
                padding-top: 13rem;
            }

            #prayer-times-section {
                right: 0;
                left: 0;
                bottom: -6.5rem;
            }

            #prayer-times-section .container {
                text-align: center;
            }

            #prayer-times-bar {
                font-size: 10rem;
                margin-top: 10px;
            }

            .prayer-time {
                margin-bottom: 5px;
            }
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom">
        <div class="running-text-container py-1" id="runningText">
            <div class="running-text-content text-light">
                {{ $setting->running_text ?? 'Selamat datang di Website Masjid Kami.' }}
            </div>
        </div>
        <div class="container py-4">
            <a class="navbar-brand d-flex align-items-center" href="/">
                @if ($setting && $setting->logo)
                    <img src="{{ asset('public/img/settings/' . $setting->logo) }}" alt="Logo Masjid">
                @endif
                <span class="ms-2 fw-bold">{{ $setting->nama ?? 'Masjid Iman Kuat' }}</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <style>
                /* Buka dropdown saat hover */
                .nav-item.dropdown:hover .dropdown-menu {
                    display: block;
                    margin-top: 0;
                }
            </style>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center" style="font-family: sans-serif">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">BERANDA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profil') }}">PROFIL</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('galery') }}">GALERI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('artikel') }}">BERITA</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="informasiDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            INFORMASI
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="informasiDropdown">
                            <li><a class="dropdown-item" href="{{ route('layanan') }}">Layanan Masjid</a></li>
                            <li><a class="dropdown-item" href="{{ route('pengumuman') }}">Pengumuman</a></li>
                            <li><a class="dropdown-item" href="{{ route('keuangan.list') }}">Keuangan Masjid</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('login_page') }}">LOGIN</a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="prayer-times-section" class="bg-light py-2 border-bottom" style="border-radius: 0.5rem">
            <div class="container d-flex justify-content-between flex-column align-items-center fs-6"
                style="background-color: #f8f9fa;">
                <div class="location-date me-3 mb-2 mb-md-0">
                    <strong id="prayer-location">Memuat...</strong>
                    <div id="prayer-date" class="small text-muted"></div>
                </div>
                <div id="prayer-times-bar" class="d-flex justify-content-around w-100">
                    <div class="prayer-time text-center px-2">
                        <div class="name">Subuh</div>
                        <div id="fajr-time" class="time fw-bold">--:--</div>
                    </div>
                    <div class="prayer-time text-center px-2">
                        <div class="name">Zuhur</div>
                        <div id="dhuhr-time" class="time fw-bold">--:--</div>
                    </div>
                    <div class="prayer-time text-center px-2">
                        <div class="name">Asar</div>
                        <div id="asr-time" class="time fw-bold">--:--</div>
                    </div>
                    <div class="prayer-time text-center px-2">
                        <div class="name">Magrib</div>
                        <div id="maghrib-time" class="time fw-bold">--:--</div>
                    </div>
                    <div class="prayer-time text-center px-2">
                        <div class="name">Isya</div>
                        <div id="isha-time" class="time fw-bold">--:--</div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <section class="content">
        @yield('content')
    </section>

    <footer class="bg-primary-gradient" style="background: #007c6c;">
        <div class="container py-4 py-lg-5">
            <hr style="color: white;">
            <div class="text-white d-flex justify-content-between align-items-center pt-3">
                <p class="mb-0">Copyright © {{ date('Y') }} {{ $setting->nama ?? 'Masjid Iman Kuat' }}</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('public/theme/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/theme/js/bold-and-bright.js') }}"></script>
    <script src="{{ asset('public/theme/js/Simple-Slider-swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('public/theme/js/Simple-Slider.js') }}"></script>
    @yield('bottom-script')

    <script>
        const runningText = document.getElementById('runningText');
        const preyerTime = document.getElementById('prayer-times-section');
        let lastScrollTop = 10;
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop) {
                runningText.style.display = 'none';
                preyerTime.style.display = 'none';
            } else {
                preyerTime.style.display = 'block';
                runningText.style.display = 'block';
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        }, false);

        document.addEventListener('DOMContentLoaded', function() {
            // Perubahan: Kota untuk waktu sholat dinamis
            const city = "{{ $setting->kota_untuk_sholat ?? 'Jakarta' }}";
            const country = "Indonesia";
            const method = 11; // Metode Kemenag RI

            const today = new Date();
            const year = today.getFullYear();
            const month = today.getMonth() + 1;
            const day = today.getDate();
            const apiUrl =
                `https://api.aladhan.com/v1/timingsByCity/${day}-${month}-${year}?city=${city}&country=${country}&method=${method}`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.code === 200) {
                        const timings = data.data.timings;
                        const date = data.data.date.readable;
                        document.getElementById('prayer-location').textContent = `${city}, Indonesia`;
                        document.getElementById('prayer-date').textContent = date;
                        document.getElementById('fajr-time').textContent = timings.Fajr;
                        document.getElementById('dhuhr-time').textContent = timings.Dhuhr;
                        document.getElementById('asr-time').textContent = timings.Asr;
                        document.getElementById('maghrib-time').textContent = timings.Maghrib;
                        document.getElementById('isha-time').textContent = timings.Isha;
                    } else {
                        console.error("Gagal mengambil data waktu sholat.");
                        document.getElementById('prayer-location').textContent = "Gagal memuat data";
                    }
                })
                .catch(error => {
                    console.error('Error fetching prayer times:', error);
                    document.getElementById('prayer-location').textContent = "Kesalahan jaringan";
                });
        });
    </script>

</body>

</html>
