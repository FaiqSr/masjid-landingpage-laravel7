@extends('main_blog')

@section('title', 'Daftar Paket Umroh')

@section('top-style')
    {{-- CSS Khusus untuk halaman daftar paket --}}
    <style>
        .page-header {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://source.unsplash.com/1600x500/?mecca,kaaba') no-repeat center center;
            background-size: cover;
            height: 35vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-direction: column;
        }

        .filter-card {
            border: 1px solid #e9ecef;
            border-radius: 0.375rem;
            padding: 1.5rem;
            position: sticky;
            top: 100px;
            background-color: #fff;
        }

        .paket-card {
            border-radius: 0.375rem;
            overflow: hidden;
            border: 1px solid #e9ecef;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .paket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .paket-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .paket-card .harga-overlay {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            background-color: rgba(22, 163, 74, 0.9);
            color: white;
            font-size: 0.9rem;
            font-weight: bold;
            padding: 4px 10px;
            border-radius: 0.25rem;
        }

        .paket-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 46px;
        }

        .paket-card .list-info {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .pagination .page-item.active .page-link {
            background-color: #198754;
            border-color: #198754;
        }

        .pagination .page-link {
            color: #198754;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')
    <div class="page-header text-center mb-5">
        <h1 class="display-4 fw-bold">{{ $page_title ?? 'Pilihan Paket Umroh' }}</h1>
        <p class="lead">Temukan perjalanan ibadah terbaik yang sesuai dengan kebutuhan Anda.</p>
    </div>

    <div class="container mb-5">
        <div class="row gx-4">
            <div class="col-lg-3">
                <div class="filter-card">
                    <h5 class="fw-bold mb-3">Filter Paket</h5>
                    <form action="{{ route('paket/index') }}" method="GET">
                        {{-- Filter Form Fields --}}
                        <div class="mb-3">
                            <label for="keyword" class="form-label small fw-semibold">Nama Paket</label>
                            <input type="text" name="keyword" id="keyword" class="form-control"
                                placeholder="Cari paket..." value="{{ request('keyword') }}">
                        </div>
                        <div class="mb-3">
                            <label for="bulan" class="form-label small fw-semibold">Bulan Keberangkatan</label>
                            <select name="bulan" id="bulan" class="form-select">
                                <option value="">Semua Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipe" class="form-label small fw-semibold">Tipe Paket</label>
                            <select name="tipe" id="tipe" class="form-select">
                                <option value="">Semua Tipe</option>
                                @foreach ($paket_types as $type)
                                    <option value="{{ $type->id }}"
                                        {{ (request('tipe') ?? ($active_type->id ?? null)) == $type->id ? 'selected' : '' }}>
                                        {{ $type->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="maskapai" class="form-label small fw-semibold">Maskapai</label>
                            <select name="maskapai" id="maskapai" class="form-select">
                                <option value="">Semua Maskapai</option>
                                @foreach ($maskapais as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('maskapai') == $item->id ? 'selected' : '' }}>{{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bintang" class="form-label small fw-semibold">Bintang Hotel</label>
                            <select name="bintang" id="bintang" class="form-select">
                                <option value="">Semua Bintang</option>
                                <option value="5" {{ request('bintang') == 5 ? 'selected' : '' }}>Bintang 5 ★★★★★
                                </option>
                                <option value="4" {{ request('bintang') == 4 ? 'selected' : '' }}>Bintang 4 ★★★★
                                </option>
                                <option value="3" {{ request('bintang') == 3 ? 'selected' : '' }}>Bintang 3 ★★★
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Rentang Harga</label>
                            <div class="input-group mb-2"><span class="input-group-text">Rp</span><input type="number"
                                    name="harga_min" class="form-control" placeholder="Minimum"
                                    value="{{ request('harga_min') }}"></div>
                            <div class="input-group"><span class="input-group-text">Rp</span><input type="number"
                                    name="harga_max" class="form-control" placeholder="Maksimum"
                                    value="{{ request('harga_max') }}"></div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success"><i class="fas fa-filter me-1"></i> Terapkan
                                Filter</button>
                            <a href="{{ route('paket/index') }}" class="btn btn-outline-secondary"><i
                                    class="fas fa-sync-alt me-1"></i> Reset Filter</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                    @forelse($pakets as $paket)
                        <div class="col">
                            <div class="paket-card">
                                <div class="position-relative">
                                    <img src="{{ asset('public/uploads/paket/' . $paket->foto) }}" class="card-img-top"
                                        alt="Foto {{ $paket->nama }}">
                                    <div class="harga-overlay">Rp{{ number_format($paket->harga, 0, ',', '.') }}</div>
                                </div>
                                <div class="card-body d-flex flex-column px-2">
                                    <h5 class="card-title flex-grow-1 pt-3">{{ $paket->nama }}</h5>
                                    <div class="list-info">
                                        {{-- =================================== --}}
                                        {{--         PERBAIKAN TAMPILAN HOTEL        --}}
                                        {{-- =================================== --}}
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>
                                                <i class="fas fa-plane-departure fa-fw me-2"
                                                    title="Maskapai"></i>{{ $paket->nama_maskapai }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>
                                                <i class="fas fa-star fa-fw me-2 text-warning"
                                                    title="Bintang Hotel"></i>Makkah: {{ $paket->level_hotel_makkah }} |
                                                Madinah: {{ $paket->level_hotel_madinah }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span><i class="far fa-calendar-alt fa-fw me-2"
                                                    title="Tanggal Berangkat"></i>{{ \Carbon\Carbon::parse($paket->tanggal_berangkat)->isoFormat('D MMM Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span><i class="far fa-clock fa-fw me-2"
                                                    title="Durasi"></i>{{ $paket->durasi }} Hari</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-0 p-3">
                                    <a href="{{ url('paket/detail/' . $paket->id) }}" class="btn btn-success w-100">Lihat
                                        Detail</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5 px-4 bg-light rounded-3 d-flex flex-column align-items-center justify-content-center"
                                style="min-height: 400px;">
                                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                <h4 class="fw-bold">Paket Tidak Ditemukan</h4>
                                <p class="text-muted mb-3">Tidak ada paket yang sesuai dengan kriteria filter Anda. Silakan
                                    coba atur ulang filter.</p>
                                <a href="{{ route('paket/index') }}" class="btn btn-success">Reset Filter</a>
                            </div>
                        </div>
                    @endforelse
                </div>
                {{-- Paginasi --}}
                @if ($pakets->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $pakets->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
