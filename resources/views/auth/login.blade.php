<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PPDB Online | Log in</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('/public/adminlte') }}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/public/adminlte') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/public/adminlte') }}/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('/public/adminlte') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="{{ asset('/public/adminlte') }}/plugins/toastr/toastr.min.css">
    <link rel="icon" href="{{ asset('/public/img/logo.png') }}" type="image/png"> {{-- Pastikan path logo benar --}}

    <style type="text/css">
        body {
            background-color: #2e4585 !important;
            background-image: url('{{ asset("/public/img/bg-login.jpg") }}'); /* Opsional: Tambahkan background image */
            background-size: cover;
            background-position: center;
        }
        .login-box {
            width: 400px;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h2"><b>PPDB</b> Online</a>
            </div>
            <div class="card-body login-card-body">
                
                {{-- Navigasi Tab --}}
                <ul class="nav nav-tabs nav-fill mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="siswa-tab" data-toggle="tab" href="#siswa" role="tab" aria-controls="siswa" aria-selected="true">Login Siswa</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="admin-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="admin" aria-selected="false">Login Admin</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    {{-- Tab Pane untuk Login Siswa --}}
                    <div class="tab-pane fade show active" id="siswa" role="tabpanel" aria-labelledby="siswa-tab">
                        <p class="login-box-msg">Login sebagai Calon Peserta Didik</p>
                        <form action="{{ route('login.siswa.submit') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input name="email" type="email" class="form-control" placeholder="Email Pendaftaran" autocomplete="off" value="{{ old('email') }}" required>
                                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>
                            </div>
                            <div class="input-group mb-3">
                                <input name="password" type="password" class="form-control" placeholder="Password" required>
                                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> Login Siswa</button>
                                </div>
                            </div>
                        </form>
                        <p class="mt-3 mb-1 text-center">
                            Belum punya akun? <a href="{{ route('ppdb.register') }}">Daftar di sini</a>
                        </p>
                    </div>

                    {{-- Tab Pane untuk Login Admin --}}
                    <div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="admin-tab">
                        <p class="login-box-msg">Login sebagai Administrator</p>
                        <form action="{{ route('login.admin.submit') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input name="email" type="email" class="form-control" placeholder="Email Admin" autocomplete="off" required value="admin@localhost.com">
                                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user-shield"></span></div></div>
                            </div>
                            <div class="input-group mb-3">
                                <input name="password" type="password" class="form-control" placeholder="Password" required value="123456">
                                <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-dark btn-block"><i class="fas fa-sign-in-alt"></i> Login Admin</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('/public/adminlte') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/dist/js/adminlte.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/toastr/toastr.min.js"></script>

    <script>
        // Fungsi notifikasi tidak perlu diubah
        function gagal() {
            var Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
            Toast.fire({ icon: 'error', title: ' &nbsp; Email atau Password tidak sesuai. Silakan coba lagi.' });
        }
        function akses() {
            var Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
            Toast.fire({ icon: 'error', title: ' &nbsp; Akses ditolak, silahkan login terlebih dahulu.' });
        }
        function logout() {
            var Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
            Toast.fire({ icon: 'success', title: ' &nbsp; Anda Telah Berhasil Logout.' });
        }
    </script>

    @if (session('gagal'))
        <script> gagal(); </script>
    @endif
    @if (session('akses'))
        <script> akses(); </script>
    @endif
    @if (session('logout'))
        <script> logout(); </script>
    @endif

</body>
</html>