@extends('main_blog')

{{-- Judul halaman akan diambil dari nama masjid di pengaturan --}}
@section('title', 'Profil ' . ($setting->nama ?? 'Masjid'))

{{-- Menambahkan style khusus untuk halaman profil jika diperlukan --}}
@section('top-style')
    <style>
        .profil-section .card {
            border-radius: 0.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profil-content h2,
        .profil-content h3 {
            color: #007c6c;
            /* Warna hijau sesuai tema */
            font-weight: 600;
        }

        .profil-content ul {
            padding-left: 20px;
        }

        .profil-content li {
            margin-bottom: 0.5rem;
        }
    </style>
@endsection
@section('content')
    <div class="container py-4 py-xl-5 profil-section">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card">
                    <div class="card-body p-4 p-md-5">

                        @if ($setting->foto)
                            <div class="text-center mb-5">
                                <img src="{{ asset('public/img/settings/' . $setting->foto) }}"
                                    class="img-fluid rounded shadow"
                                    style="width: 400px; height: 400px; object-fit: cover;" alt="Foto Profil Masjid">
                            </div>
                        @endif
                        @if (!empty($setting->tentang_kami))
                            <div class="mb-5 profil-content">
                                {!! $setting->tentang_kami !!}
                            </div>
                            <hr class="my-5">
                        @endif

                        @if (!empty($setting->visi_misi))
                            <div class="mb-5 profil-content">
                                {!! $setting->visi_misi !!}
                            </div>
                            <hr class="my-5">
                        @endif

                        <div class="text-center mt-4">
                            <h4 class="fw-bold">Lokasi Masjid</h4>
                            <p class="lead mt-2">{{ $setting->alamat ?? 'Alamat belum diatur.' }}</p>
                            @if ($setting->wa)
                                <a href="https://wa.me/{{ $setting->wa }}" target="_blank" class="btn btn-success mt-3">
                                    <i class="fa-brands fa-whatsapp"></i> &nbsp;Hubungi Kami via WhatsApp
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
