@extends('layout.main')

@section('title', 'Pengaturan Website')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Pengaturan Website</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengaturan</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="setting-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-umum-tab" data-toggle="pill" href="#tab-umum" role="tab"
                        aria-controls="tab-umum" aria-selected="true">Pengaturan Umum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-konten-tab" data-toggle="pill" href="#tab-konten" role="tab"
                        aria-controls="tab-konten" aria-selected="false">Konten Halaman</a>
                </li>
            </ul>
        </div>
        <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="tab-content" id="setting-tabs-content">

                    {{-- TAB PENGATURAN UMUM --}}
                    <div class="tab-pane fade show active" id="tab-umum" role="tabpanel" aria-labelledby="tab-umum-tab">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="nama">Nama Masjid</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" placeholder="Nama Masjid"
                                    value="{{ old('nama', $settings->nama) }}">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="kota_untuk_sholat">Kota untuk Waktu Sholat</label>
                                <input type="text" class="form-control @error('kota_untuk_sholat') is-invalid @enderror"
                                    id="kota_untuk_sholat" name="kota_untuk_sholat" placeholder="Contoh: Jakarta"
                                    value="{{ old('kota_untuk_sholat', $settings->kota_untuk_sholat) }}">
                                @error('kota_untuk_sholat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat Masjid</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2">{{ old('alamat', $settings->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="running_text">Running Text (Marquee)</label>
                            <textarea class="form-control @error('running_text') is-invalid @enderror" id="running_text" name="running_text"
                                rows="3" placeholder="Teks berjalan di bagian atas website">{{ old('running_text', $settings->running_text) }}</textarea>
                            @error('running_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>
                        <p class="font-weight-bold">Media Sosial</p>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="wa">Nomor WhatsApp</label>
                                <input type="text" class="form-control" name="wa"
                                    value="{{ old('wa', $settings->wa) }}" placeholder="62812xxxx">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="ig">Instagram</label>
                                <input type="text" class="form-control" name="ig"
                                    value="{{ old('ig', $settings->ig) }}" placeholder="Username Instagram">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="fb">Facebook</label>
                                <input type="text" class="form-control" name="fb"
                                    value="{{ old('fb', $settings->fb) }}" placeholder="Username Facebook">
                            </div>
                        </div>
                        <hr>
                        <p class="font-weight-bold">Aset Gambar</p>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Logo (Untuk Navbar)</label>
                                <input type="file" name="logo" class="form-control-file">
                                @if ($settings->logo)
                                    <img src="{{ asset('public/img/settings/' . $settings->logo) }}"
                                        class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Icon (Untuk Tab Browser)</label>
                                <input type="file" name="icon" class="form-control-file">
                                @if ($settings->icon)
                                    <img src="{{ asset('public/img/settings/' . $settings->icon) }}"
                                        class="img-thumbnail mt-2" width="50">
                                @endif
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Foto Profil (Halaman Profil)</label>
                                <input type="file" name="foto" class="form-control-file">
                                @if ($settings->foto)
                                    <img src="{{ asset('public/img/settings/' . $settings->foto) }}"
                                        class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- TAB KONTEN HALAMAN --}}
                    <div class="tab-pane fade" id="tab-konten" role="tabpanel" aria-labelledby="tab-konten-tab">
                        <div class="form-group">
                            <label for="editor_visi_misi">Visi & Misi</label>
                            <textarea name="visi_misi" id="editor_visi_misi" class="form-control">{{ old('visi_misi', $settings->visi_misi) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="editor_tentang_kami">Tentang Kami</label>
                            <textarea name="tentang_kami" id="editor_tentang_kami" class="form-control">{{ old('tentang_kami', $settings->tentang_kami) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i>Simpan Semua
                    Pengaturan</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.21.0/ckeditor.js"
        integrity="sha512-ff67djVavIxfsnP13CZtuHqf7VyX62ZAObYle+JlObWZvS4/VQkNVaFBOO6eyx2cum8WtiZ0pqyxLCQKC7bjcg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function() {
            // Inisialisasi CKEditor
            CKEDITOR.replace('editor_tentang_kami');
            CKEDITOR.replace('editor_visi_misi');

            // Notifikasi sukses setelah update
            @if (session('sukses'))
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: ' &nbsp; {{ session('sukses') }}'
                });
            @endif
        });
    </script>
@endsection
