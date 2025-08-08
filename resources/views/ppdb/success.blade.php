@extends('main_blog')

@section('title', 'Pendaftaran Berhasil')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm border-success">
                <div class="card-body p-5">
                    <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                    <h2 class="card-title fw-bold">Pendaftaran Berhasil!</h2>

                    @if(session('nomor_pendaftaran'))
                        <p class="lead">
                            Terima kasih, <strong>{{ session('nama_siswa') }}</strong>, telah mendaftar.
                        </p>
                        <p>Silakan simpan dan catat **Nomor Pendaftaran** Anda untuk proses selanjutnya.</p>

                        <div class="alert alert-success mt-4 fs-4 fw-bold">
                            {{ session('nomor_pendaftaran') }}
                        </div>

                        <p class="mt-4 text-muted">
                            Pengumuman hasil seleksi dan informasi lebih lanjut akan kami sampaikan melalui website ini atau kontak yang telah Anda daftarkan.
                        </p>
                    @endif

                    <a href="{{ url('/') }}" class="btn btn-primary mt-4">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection