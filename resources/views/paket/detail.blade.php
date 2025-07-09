@extends('main_blog') {{-- Sesuaikan dengan nama layout utama frontend Anda --}}

@section('title', 'Detail Paket - ' . $paket->nama)

@section('top-style')
    {{-- CSS Khusus untuk halaman detail paket --}}
    <style>
        .detail-card {
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            padding: 2rem;
            position: sticky;
            top: 100px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .price {
            color: #198754;
            /* Warna hijau success */
            font-weight: 700;
        }

        .info-list .list-group-item {
            border: none;
            padding-left: 0;
            padding-right: 0;
            display: flex;
            align-items: flex-start;
        }

        .info-list .icon {
            font-size: 1.1rem;
            margin-right: 1rem;
            width: 20px;
            color: #6c757d;
            margin-top: 5px;
        }

        .nav-tabs .nav-link {
            color: #333;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: #198754;
            border-color: #dee2e6 #dee2e6 #fff;
            border-bottom: 3px solid #198754;
        }

        .tab-content {
            padding: 1.5rem;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 0.25rem 0.25rem;
        }

        .main-image {
            width: 100%;
            height: 450px;
            object-fit: cover;
            border-radius: .5rem;
        }

        .ck-content {
            line-height: 1.6;
        }

        .ck-content h1,
        .ck-content h2,
        .ck-content h3 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .ck-content ul,
        .ck-content ol {
            padding-left: 2rem;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')
    <div class="container my-5">
        <div class="row g-5">

            <div class="col-lg-7">
                <img src="{{ asset('public/uploads/paket/' . $paket->foto) }}" alt="Foto Paket {{ $paket->nama }}"
                    class="main-image shadow-sm mb-4">

                <ul class="nav nav-tabs" id="detailTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="deskripsi-tab" data-bs-toggle="tab"
                            data-bs-target="#deskripsi-tab-pane" type="button" role="tab"
                            aria-controls="deskripsi-tab-pane" aria-selected="true">Deskripsi & Itinerary</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="fasilitas-tab" data-bs-toggle="tab"
                            data-bs-target="#fasilitas-tab-pane" type="button" role="tab"
                            aria-controls="fasilitas-tab-pane" aria-selected="false">Fasilitas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="akomodasi-tab" data-bs-toggle="tab"
                            data-bs-target="#akomodasi-tab-pane" type="button" role="tab"
                            aria-controls="akomodasi-tab-pane" aria-selected="false">Akomodasi</button>
                    </li>
                </ul>

                <div class="tab-content" id="detailTabContent">
                    <div class="tab-pane fade show active ck-content" id="deskripsi-tab-pane" role="tabpanel"
                        aria-labelledby="deskripsi-tab" tabindex="0">
                        {!! $paket->content !!}
                    </div>
                    <div class="tab-pane fade" id="fasilitas-tab-pane" role="tabpanel" aria-labelledby="fasilitas-tab"
                        tabindex="0">
                        <h5 class="fw-semibold">Fasilitas Termasuk Dalam Paket</h5>
                        @if (!$fasilitas->isEmpty())
                            <ul class="list-unstyled mt-3">
                                @foreach ($fasilitas as $item)
                                    <li class="mb-2"><i
                                            class="fas fa-check-circle text-success me-2"></i>{{ $item->nama }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Tidak ada data fasilitas spesifik untuk paket ini.</p>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="akomodasi-tab-pane" role="tabpanel" aria-labelledby="akomodasi-tab"
                        tabindex="0">
                        <h5 class="fw-semibold">Hotel & Maskapai Penerbangan</h5>
                        <dl class="row mt-3">
                            <dt class="col-sm-4">Hotel Makkah</dt>
                            <dd class="col-sm-8">{{ $paket->nama_hotel_makkah }}
                                <span class="ms-1 text-warning">
                                    @for ($i = 0; $i < $paket->level_hotel_makkah; $i++)
                                        ★
                                    @endfor
                                </span>
                            </dd>

                            <dt class="col-sm-4">Hotel Madinah</dt>
                            <dd class="col-sm-8">{{ $paket->nama_hotel_madinah }}
                                <span class="ms-1 text-warning">
                                    @for ($i = 0; $i < $paket->level_hotel_madinah; $i++)
                                        ★
                                    @endfor
                                </span>
                            </dd>

                            <dt class="col-sm-4">Maskapai</dt>
                            <dd class="col-sm-8">{{ $paket->nama_maskapai }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="detail-card">
                    <span
                        class="badge bg-info-subtle text-info-emphasis rounded-pill mb-2">{{ $paket->nama_tipe_paket }}</span>
                    <h1 class="h3">{{ $paket->nama }}</h1>
                    <p class="text-muted">Mulai dari</p>
                    <h2 class="h3 price my-3">
                        Rp {{ number_format($paket->harga, 0, ',', '.') }} <small class="text-muted h6 fw-normal">/
                            pax</small>
                    </h2>
                    <hr>
                    <ul class="list-group list-group-flush info-list">
                        <li class="list-group-item"><i class="fa-regular fa-calendar-check icon"></i>
                            <div><span
                                    class="d-block text-muted small">Keberangkatan</span><strong>{{ \Carbon\Carbon::parse($paket->tanggal_berangkat)->isoFormat('D MMMM YYYY') }}</strong>
                            </div>
                        </li>
                        <li class="list-group-item"><i class="fa-regular fa-clock icon"></i>
                            <div><span class="d-block text-muted small">Durasi</span><strong>{{ $paket->durasi }}
                                    Hari</strong></div>
                        </li>
                        <li class="list-group-item"><i class="fa-solid fa-plane-departure icon"></i>
                            <div><span
                                    class="d-block text-muted small">Maskapai</span><strong>{{ $paket->nama_maskapai }}</strong>
                            </div>
                        </li>
                        <li class="list-group-item"><i class="fa-solid fa-users icon"></i>
                            <div><span class="d-block text-muted small">Sisa
                                    Kuota</span><strong>{{ $paket->kuota_tersedia }} Kursi</strong></div>
                        </li>
                    </ul>
                    <div class="d-grid gap-2 mt-4">
                        <a href="https://api.whatsapp.com/send?phone=NOMOR_WHATSAPP&text=Assalamualaikum,%20saya%20tertarik%20dengan%20paket%20umroh%20*{{ urlencode($paket->nama) }}*.%20Mohon%20informasi%20lebih%20lanjut."
                            class="btn btn-success btn-lg" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
