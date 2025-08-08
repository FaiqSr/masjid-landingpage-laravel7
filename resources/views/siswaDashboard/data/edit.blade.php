@extends('layout.siswaDashboard') {{-- Pastikan nama layout siswa Anda benar --}}

@section('title', $title)

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ $title }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.siswa.edit') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Ubah Data Saya</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')

    {{-- Notifikasi Sukses atau Gagal --}}
    @if (session('sukses'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('sukses') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
    @endif
    @if (session('gagal'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle"></i> {{ session('gagal') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
    @endif

    <form action="{{ route('dashboard.siswa.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- KOLOM KIRI: FORM DATA TEKS --}}
            <div class="col-md-7">
                {{-- Card Data Diri Siswa --}}
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Data Diri</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Nomor Pendaftaran</label>
                                <input type="text" class="form-control" value="{{ $siswa->nomor_pendaftaran }}" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status Pendaftaran</label>
                                <input type="text" class="form-control" value="{{ $siswa->status_pendaftaran }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                id="nama_lengkap" name="nama_lengkap"
                                value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6"><label>NIK</label><input type="text" class="form-control"
                                    value="{{ $siswa->nik }}" disabled></div>
                            <div class="form-group col-md-6"><label>NISN</label><input type="text" class="form-control"
                                    value="{{ $siswa->nisn }}" disabled></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    id="tempat_lahir" name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    id="tanggal_lahir" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="anak_ke">Anak Ke</label>
                                <input type="number" class="form-control" id="anak_ke" name="anak_ke"
                                    value="{{ old('anak_ke', $siswa->anak_ke) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jumlah_saudara">Jumlah Saudara</label>
                                <input type="number" class="form-control" id="jumlah_saudara" name="jumlah_saudara"
                                    value="{{ old('jumlah_saudara', $siswa->jumlah_saudara) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat_lengkap">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror"
                                rows="3">{{ old('alamat_lengkap', $siswa->alamat_lengkap) }}</textarea>
                        </div>
                    </div>
                </div>
                {{-- CARD BARU: Data Sekolah Asal --}}
                <div class="card card-purple card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Data Sekolah Asal</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="sekolah_asal">Nama Sekolah Asal</label>
                                <input type="text" class="form-control @error('sekolah_asal') is-invalid @enderror"
                                    id="sekolah_asal" name="sekolah_asal"
                                    value="{{ old('sekolah_asal', $siswa->sekolah_asal) }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tahun_lulus">Tahun Lulus</label>
                                <input type="number" class="form-control @error('tahun_lulus') is-invalid @enderror"
                                    id="tahun_lulus" name="tahun_lulus"
                                    value="{{ old('tahun_lulus', $siswa->tahun_lulus) }}">
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Card Data Orang Tua --}}
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Data Orang Tua / Wali</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-md-12">
                                <label for="no_kk">Nomor Kartu Keluarga (KK)</label>
                                <input type="text" class="form-control @error('no_kk') is-invalid @enderror"
                                    id="no_kk" name="no_kk" value="{{ old('no_kk', $siswa->no_kk) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nama_ayah">Nama Ayah</label>
                                <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror"
                                    id="nama_ayah" name="nama_ayah"
                                    value="{{ old('nama_ayah', $data_ortu['Ayah']->nama_lengkap ?? '') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                                <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah"
                                    value="{{ old('pekerjaan_ayah', $data_ortu['Ayah']->pekerjaan ?? '') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nama_ibu">Nama Ibu</label>
                                <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror"
                                    id="nama_ibu" name="nama_ibu"
                                    value="{{ old('nama_ibu', $data_ortu['Ibu']->nama_lengkap ?? '') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu"
                                    value="{{ old('pekerjaan_ibu', $data_ortu['Ibu']->pekerjaan ?? '') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon_ortu">No. Telepon Aktif (Orang Tua)</label>
                            <input type="tel" class="form-control @error('no_telepon_ortu') is-invalid @enderror"
                                id="no_telepon_ortu" name="no_telepon_ortu"
                                value="{{ old('no_telepon_ortu', $data_ortu['Ayah']->no_telepon_ortu ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: UBAH BERKAS & TOMBOL SIMPAN --}}
            <div class="col-md-5">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Ubah Berkas Unggahan</h3>
                    </div>
                    <div class="card-body">

                        {{-- 1. UBAH PAS FOTO --}}
                        <div class="form-group">
                            <label>Pas Foto</label>
                            @if ($berkas['Pas Foto'])
                                <br><a href="{{ url('public/' . $berkas['Pas Foto']->path_file) }}" target="_blank"
                                    class="text-sm">Lihat Foto</a>
                            @else
                                <p class="text-muted text-sm">Belum diunggah</p>
                            @endif
                            <div class="custom-file mt-2">
                                <input type="file" class="custom-file-input @error('pas_foto') is-invalid @enderror"
                                    name="pas_foto" id="pas_foto">
                                <label class="custom-file-label" for="pas_foto">Ganti Pas Foto...</label>
                            </div>
                            <small class="form-text text-muted">Maks 1MB (JPG, PNG).</small>
                        </div>
                        <hr>

                        {{-- 2. UBAH KARTU KELUARGA --}}
                        <div class="form-group">
                            <label>Kartu Keluarga (KK)</label><br>
                            @if ($berkas['Kartu Keluarga'])
                                <a href="{{ url('public/' . $berkas['Kartu Keluarga']->path_file) }}" target="_blank"><i
                                        class="fas fa-file-alt"></i> Lihat KK Saat Ini</a>
                            @else
                                <span class="text-muted text-sm">Belum diunggah</span>
                            @endif
                            <div class="custom-file mt-2">
                                <input type="file" class="custom-file-input @error('file_kk') is-invalid @enderror"
                                    name="file_kk" id="file_kk">
                                <label class="custom-file-label" for="file_kk">Ganti KK...</label>
                            </div>
                            <small class="form-text text-muted">Maks 2MB (PDF, JPG, PNG).</small>
                        </div>
                        <hr>

                        {{-- 3. UBAH IJAZAH/SKL --}}
                        <div class="form-group">
                            <label>Ijazah / SKL</label><br>
                            @if ($berkas['Ijazah'])
                                <a href="{{ url('public/' . $berkas['Ijazah']->path_file) }}" target="_blank"><i
                                        class="fas fa-file-alt"></i> Lihat Ijazah Saat Ini</a>
                            @else
                                <span class="text-muted text-sm">Belum diunggah</span>
                            @endif
                            <div class="custom-file mt-2">
                                <input type="file"
                                    class="custom-file-input @error('file_ijazah') is-invalid @enderror"
                                    name="file_ijazah" id="file_ijazah">
                                <label class="custom-file-label" for="file_ijazah">Ganti Ijazah...</label>
                            </div>
                            <small class="form-text text-muted">Maks 2MB (PDF, JPG, PNG).</small>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save mr-2"></i>Simpan Semua Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.custom-file-input').forEach(function(input) {
                input.addEventListener('change', function(e) {
                    var fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file...';
                    var nextSibling = e.target.nextElementSibling;
                    nextSibling.innerText = fileName;
                });
            });
        });
    </script>
@endsection
