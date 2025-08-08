@extends('layout.siswaDashboard') {{-- Pastikan nama layout Anda benar --}}

@section('title', 'Dashboard Siswa')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.siswa.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard Siswa</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    {{-- Pesan Selamat Datang --}}
    <div class="alert alert-success">
        <h4 class="alert-heading">Selamat Datang, {{ $siswa->nama_lengkap }}!</h4>
        <p>Anda telah terdaftar pada PPDB Tahun Ajaran <strong>{{ $siswa->tahun_ajaran }}</strong>. Halaman ini berisi informasi terkini mengenai status pendaftaran Anda.</p>
    </div>

    {{-- Info Box Ringkasan --}}
    <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-primary"><i class="fas fa-id-card"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Nomor Pendaftaran</span>
                    <span class="info-box-number h5">{{ $siswa->nomor_pendaftaran }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-info"><i class="fas fa-road"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Jalur Pendaftaran</span>
                    <span class="info-box-number h5">{{ $siswa->nama_jalur }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-12">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-success"><i class="fas fa-check-double"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Status Pendaftaran</span>
                    <span class="info-box-number h5">
                        @switch($siswa->status_pendaftaran)
                            @case('Diterima')
                                <span class="badge badge-success">{{ $siswa->status_pendaftaran }}</span>
                                @break
                            @case('Ditolak')
                                <span class="badge badge-danger">{{ $siswa->status_pendaftaran }}</span>
                                @break
                            @case('Cadangan')
                                <span class="badge badge-info">{{ $siswa->status_pendaftaran }}</span>
                                @break
                            @case('Terverifikasi')
                                <span class="badge badge-primary">{{ $siswa->status_pendaftaran }}</span>
                                @break
                            @default
                                <span class="badge badge-warning">{{ $siswa->status_pendaftaran }}</span>
                        @endswitch
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Informasi dan Aksi --}}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-bullhorn"></i>
                Informasi Penting
            </h3>
        </div>
        <div class="card-body">
            @switch($siswa->status_pendaftaran)
                @case('Menunggu Verifikasi')
                    <h4>Pendaftaran Anda Sedang Dalam Proses.</h4>
                    <p>Data dan berkas yang Anda kirimkan sedang dalam tahap verifikasi oleh panitia. Harap bersabar menunggu pemberitahuan selanjutnya.</p>
                    <p>Selama status masih "Menunggu Verifikasi", Anda masih dapat mengubah data pendaftaran melalui tombol di bawah ini.</p>
                    @break

                @case('Terverifikasi')
                    <h4>✅ Data Anda Telah Terverifikasi!</h4>
                    <p class="lead">Selamat, data online Anda telah diperiksa dan dinyatakan valid oleh panitia.</p>
                    <p><strong>Langkah selanjutnya:</strong> Silakan datang ke kantor PPDB sekolah untuk melakukan verifikasi berkas fisik sesuai dengan jadwal yang akan diinformasikan lebih lanjut. Harap membawa dokumen asli berikut:</p>
                    <ul>
                        <li>Kartu Keluarga (KK) Asli</li>
                        <li>Ijazah / Surat Keterangan Lulus (SKL) Asli</li>
                        <li>Akta Kelahiran Asli</li>
                        <li>Bukti Pendaftaran (bisa dicetak melalui tombol di bawah)</li>
                    </ul>
                    <p class="text-danger"><strong>Penting:</strong> Data Anda sudah tidak dapat diubah lagi melalui dashboard ini.</p>
                    @break

                @case('Diterima')
                    <h4>🎉 Selamat, Anda Dinyatakan LULUS!</h4>
                    <p class="lead">Anda telah diterima sebagai calon siswa baru di <strong>{{ DB::table('tbl_setting')->first()->nama ?? 'Sekolah Kami' }}</strong>.</p>
                    <p>Informasi mengenai jadwal daftar ulang dan persiapan masuk sekolah akan segera diumumkan. Mohon untuk memantau website secara berkala.</p>
                    @break

                @case('Ditolak')
                    <h4>Mohon Maaf, Pendaftaran Anda Belum Dapat Diterima.</h4>
                    <p>Setelah melalui proses seleksi, pendaftaran Anda belum dapat kami terima saat ini. Kami menghargai partisipasi Anda. Tetap semangat dan semoga sukses di kesempatan lain.</p>
                    @break

                @case('Cadangan')
                     <h4>Status Anda adalah CADANGAN.</h4>
                    <p>Anda berada di daftar tunggu. Jika ada calon siswa yang diterima mengundurkan diri, panitia akan segera menghubungi Anda. Harap pastikan nomor telepon Anda selalu aktif.</p>
                    @break
                    
                @default
                    <h4>Selamat Datang di Portal PPDB.</h4>
                    <p>Silakan lengkapi data pendaftaran Anda.</p>

            @endswitch
        </div>
        <div class="card-footer text-center bg-light">
            <a href="{{ route('dashboard.siswa.show') }}" class="btn btn-info">
                <i class="fas fa-user"></i> Lihat Data Lengkap
            </a>

            {{-- Tombol "Ubah Data" hanya muncul jika status 'Menunggu Verifikasi' --}}
            @if ($siswa->status_pendaftaran == 'Menunggu Verifikasi')
            <a href="{{ route('dashboard.siswa.edit') }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Ubah Data Saya
            </a>
            @endif

            <a href="{{ route('ppdb.result.download', $siswa->id_siswa) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Cetak Bukti Pendaftaran
            </a>
        </div>
    </div>
@endsection