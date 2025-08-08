@extends('main_blog')

@section('title', 'Pendaftaran PPDB Siswa Baru')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9">

            <div class="text-center mb-5">
                <h2 class="fw-bold">Formulir Pendaftaran Siswa Baru</h2>
                <p class="text-muted">Pastikan Anda mengisi semua data dengan benar dan lengkap sesuai dengan dokumen yang sah.</p>
            </div>

            {{-- Menampilkan Pesan Error Khusus (misal: ukuran file terlalu besar) --}}
            @if (session('error_khusus'))
                <div class="alert alert-danger shadow-sm">
                    <h5 class="alert-heading">🚫 Gagal Mengunggah!</h5>
                    <p>{{ session('error_khusus') }}</p>
                </div>
            @endif

            {{-- Menampilkan Pesan Error Validasi Umum --}}
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <h5 class="alert-heading">🚫 Terjadi Kesalahan!</h5>
                    <p>Mohon periksa kembali isian formulir Anda. Ada beberapa data yang tidak valid.</p>
                    <hr>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Card: Data Akun --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0"><i class="fas fa-lock me-2 text-primary"></i>Data Akun Pendaftaran</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label fw-bold">Alamat Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="cth: siswa@email.com" required>
                                <div class="form-text">Gunakan email aktif untuk menerima notifikasi. Email ini akan digunakan untuk login.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card: Data Diri Siswa --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0"><i class="fas fa-user-graduate me-2 text-primary"></i>Data Diri Calon Siswa</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label fw-bold">Nama Lengkap Siswa</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Sesuai Akta Kelahiran" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nisn" class="form-label fw-bold">NISN</label>
                                <input type="text" class="form-control" id="nisn" name="nisn" value="{{ old('nisn') }}" placeholder="10 Digit Angka" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label fw-bold">NIK Siswa</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}" placeholder="16 Digit Angka (di KK)" required>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-md-6 mb-3">
                                <label for="tempat_lahir" class="form-label fw-bold">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="anak_ke" class="form-label fw-bold">Anak Ke</label>
                                <input type="number" class="form-control" id="anak_ke" name="anak_ke" value="{{ old('anak_ke') }}" placeholder="Contoh: 1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_saudara" class="form-label fw-bold">Jumlah Saudara</label>
                                <input type="number" class="form-control" id="jumlah_saudara" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}" placeholder="Contoh: 3" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jenis_kelamin" class="form-label fw-bold">Jenis Kelamin</label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                             <div class="col-md-6 mb-3">
                                <label for="agama" class="form-label fw-bold">Agama</label>
                                <input type="text" class="form-control" id="agama" name="agama" value="{{ old('agama', 'Islam') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_lengkap" class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3" placeholder="Sesuai Kartu Keluarga" required>{{ old('alamat_lengkap') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Card: Data Sekolah Asal --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0"><i class="fas fa-school me-2 text-primary"></i>Data Sekolah Asal</h5>
                    </div>
                    <div class="card-body p-4">
                         <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="sekolah_asal" class="form-label fw-bold">Nama Sekolah Asal</label>
                                <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal" value="{{ old('sekolah_asal') }}" placeholder="Contoh: SMPN 1 Citeureup" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tahun_lulus" class="form-label fw-bold">Tahun Lulus</label>
                                <input type="number" class="form-control" id="tahun_lulus" name="tahun_lulus" value="{{ old('tahun_lulus') }}" placeholder="cth: 2025" required>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0"><i class="fas fa-road me-2 text-primary"></i>Pilihan Jalur Pendaftaran</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="id_jalur_pendaftaran" class="form-label fw-bold">Pilih Jalur Pendaftaran</label>
                            <select class="form-select" id="id_jalur_pendaftaran" name="id_jalur_pendaftaran" required>
                                <option value="" data-deskripsi="" disabled selected>-- Silakan Pilih Jalur --</option>
                                @foreach ($jalur_pendaftaran as $jalur)
                                    <option value="{{ $jalur->id_jalur }}" data-deskripsi="{{ $jalur->deskripsi }}" {{ old('id_jalur_pendaftaran') == $jalur->id_jalur ? 'selected' : '' }}>
                                        {{ $jalur->nama_jalur }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="jalur-deskripsi" class="form-text mt-2 text-primary fw-bold"></div>
                        </div>
                    </div>
                </div>

                {{-- Card: Data Orang Tua --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0"><i class="fas fa-users me-2 text-primary"></i>Data Orang Tua / Wali</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nokk" class="form-label">NO KK</label>
                                <input type="number" class="form-control" name="nokk" value="{{ old('nokk') }}" required>
                            </div>
                        </div>
                        <h6 class="text-muted border-bottom pb-2 mb-3">Data Ayah</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                <input type="text" class="form-control" name="nama_ayah" value="{{ old('nama_ayah') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                                <input type="text" class="form-control" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}">
                            </div>
                        </div>

                        <h6 class="text-muted border-bottom pb-2 mt-3 mb-3">Data Ibu</h6>
                         <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_ibu" class="form-label">Nama Ibu</label>
                                <input type="text" class="form-control" name="nama_ibu" value="{{ old('nama_ibu') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                                <input type="text" class="form-control" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}">
                            </div>
                        </div>

                        <h6 class="text-muted border-bottom pb-2 mt-3 mb-3">Kontak Darurat</h6>
                        <div class="mb-3">
                            <label for="no_telepon_ortu" class="form-label fw-bold">No. Telepon Orang Tua/Wali (Aktif WhatsApp)</label>
                            <input type="tel" class="form-control" id="no_telepon_ortu" name="no_telepon_ortu" value="{{ old('no_telepon_ortu') }}" required>
                        </div>
                    </div>
                </div>

                {{-- Card: Upload Berkas --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0"><i class="fas fa-file-upload me-2 text-primary"></i>Upload Berkas Pendaftaran</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="file_kk" class="form-label fw-bold">Kartu Keluarga (KK)</label>
                            <input class="form-control" type="file" id="file_kk" name="file_kk" required>
                            <div class="form-text">Format: PDF, JPG, PNG. Maksimal 2MB.</div>
                        </div>
                        <div class="mb-3">
                            <label for="file_ijazah" class="form-label fw-bold">Ijazah / Surat Keterangan Lulus (SKL)</label>
                            <input class="form-control" type="file" id="file_ijazah" name="file_ijazah" required>
                             <div class="form-text">Format: PDF, JPG, PNG. Maksimal 2MB.</div>
                        </div>
                         <div class="mb-3">
                            <label for="pas_foto" class="form-label fw-bold">Pas Foto 3x4</label>
                            <input class="form-control" type="file" id="pas_foto" name="pas_foto" required>
                            <div class="form-text">Latar belakang merah/biru. Format: JPG, PNG. Maksimal 1MB.</div>
                        </div>
                    </div>
                </div>

                {{-- Card: Persetujuan & Submit --}}
                <div class="card shadow-sm">
                    <div class="card-body p-4 text-center">
                        <div class="form-check d-inline-block mb-3">
                            <input class="form-check-input" type="checkbox" value="1" id="persetujuan" name="persetujuan" required>
                            <label class="form-check-label" for="persetujuan">
                                Saya menyatakan bahwa semua data yang saya isikan adalah benar dan dapat dipertanggungjawabkan.
                            </label>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-outline-primary btn-lg px-5 shadow" style="border-radius: 0;">
                            <i class="fas fa-paper-plane me-2"></i>Daftar Sekarang
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@section('bottom-script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectJalur = document.getElementById('id_jalur_pendaftaran');
        const deskripsiDiv = document.getElementById('jalur-deskripsi');

        function updateDeskripsi() {
            const selectedOption = selectJalur.options[selectJalur.selectedIndex];
            const deskripsi = selectedOption.getAttribute('data-deskripsi');
            deskripsiDiv.textContent = deskripsi || '';
        }

        updateDeskripsi();
        selectJalur.addEventListener('change', updateDeskripsi);
    });
</script>
@endsection