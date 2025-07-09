<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Website Umroh</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('/public/adminlte') }}/plugins/fontawesome-free/css/all.min.css">


    <!-- DataTables -->
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/public/adminlte') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="{{ asset('/public/adminlte') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('/public/adminlte') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('/public/adminlte') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('/public/adminlte') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/public/adminlte') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet"
        href="{{ asset('/public/adminlte') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="{{ asset('/public/adminlte') }}/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('/public/adminlte') }}/dist/css/adminlte.min.css">



    <!-- pace-progress -->
    <link rel="stylesheet"
        href="{{ asset('/public/adminlte') }}/plugins/pace-progress/themes/black/pace-theme-flat-top.css">

    <link rel="icon" href="{{ asset('/public/adminlte') }}/dist/img/logo.png" type="image/png" sizes="16x16">
    <style>
        .main-sidebar {
            background-color: #2a375c !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini pace-primary">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('dashboard') }}" class="nav-link">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">

                <li class="nav-item dropdown show">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="true" class="nav-link dropdown-toggle">
                        <i class="fas fa-user-circle mr-2 text-lg"></i>
                        <span
                            class="hidden-xs">{{ ucfirst(DB::table('admins')->find(session()->get('id_user'))->name) }}</span>
                    </a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow"
                        style="left: 0px; right: inherit;">
                        <li>
                            <a href="{{ url('profil') }}" class="dropdown-item">
                                <i class="nav-icon fas fa-user-secret"></i> Profil
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a href="{{ url('ganti_password') }}" class="dropdown-item">
                                <i class="nav-icon fas fa-pencil-alt"></i> Password
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a href="{{ url('logout') }}" class="dropdown-item">
                                <i class="nav-icon fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>

        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="{{ url('dashboard') }}" class="brand-link text-center">
                <span class="brand-text text-white">Website Umroh</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ url('public/img/profil/men.png') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#"
                            class="d-block">{{ ucfirst(DB::table('admins')->find(session()->get('id_user'))->name) }}
                            <br>
                            <span
                                class="small">{{ DB::table('admins')->find(session()->get('id_user'))->email }}</span>
                        </a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="{{ url('dashboard') }}"
                                class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">MASTER DATA</li>

                        @php
                            $isMasterOpen = request()->is('dashboard/hotel*');
                        @endphp
                        <li class="nav-item {{ $isMasterOpen ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ $isMasterOpen ? 'active' : '' }}">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Master
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href=""
                                        class="nav-link {{ request()->is('dashboard/hotel*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Example</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-header">MANAJEMEN KONTEN</li>

                        @php
                            $isKontenOpen =
                                request()->is('dashboard/pengumuman*') ||
                                request()->is('dashboard/petugas-harian*') ||
                                request()->is('dashboard/pengurus*') ||
                                request()->is('dashboard/layanan*') ||
                                request()->is('dashboard/sliders*') ||
                                request()->is('dashboard/galery*') ||
                                request()->is('dashboard/news*') ||
                                request()->is('ganti_setting') ||
                                request()->is('dashboard/settings*');
                        @endphp
                        <li class="nav-item {{ $isKontenOpen ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ $isKontenOpen ? 'active' : '' }}">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    Konten Website
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('dashboard/petugas-harian/') }}"
                                        class="nav-link {{ request()->is('dashboard/petugas-harian*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Petugas Harian</p>
                                    </a>
                                </li>
                                {{-- New Menu Item for Pengurus --}}
                                <li class="nav-item">
                                    <a href="{{ url('dashboard/pengurus') }}"
                                        class="nav-link {{ request()->is('dashboard/pengurus*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pengurus</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pengumuman.index') }}"
                                        class="nav-link {{ request()->is('dashboard/pengumuman*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pengumuman</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('layanan.index') }}"
                                        class="nav-link {{ request()->is('dashboard/layanan*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Layanan</p>
                                    </a>
                                </li>
                                {{-- End of New Menu Item --}}
                                <li class="nav-item">
                                    <a href="{{ url('dashboard/sliders/index') }}"
                                        class="nav-link {{ request()->is('dashboard/sliders*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Slider Beranda</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('dashboard/galery') }}"
                                        class="nav-link {{ request()->is('dashboard/galery*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Galeri</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('dashboard/news/index') }}"
                                        class="nav-link {{ request()->is('dashboard/news*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Artikel (News)</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('setting.edit') }}"
                                        class="nav-link {{ request()->is('dashboard/settings*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pengaturan Website</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-header">MANAJEMEN KEUANGAN</li>
                        <li class="nav-item">
                            <a href="{{ route('keuangan.index') }}"
                                class="nav-link {{ request()->is('dashboard/keuangan*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>
                                    Keuangan Masjid
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">AKUN</li>
                        <li class="nav-item">
                            <a href="{{ url('logout') }}" class="nav-link text-danger">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    @yield('breadcrums')
                </div>
            </section>

            <section class="content">
                @yield('content')
            </section>
        </div>


        <footer class="main-footer">

            <div class="float-right d-none d-sm-inline">
            </div>

            <strong>Copyright &copy; 2024 <a href="#">Website Umroh</a>.</strong> All rights
            reserved.
        </footer>
    </div>



    <script src="{{ asset('/public/adminlte') }}/plugins/jquery/jquery.min.js"></script>

    <script src="{{ asset('/public/adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('/public/adminlte') }}/dist/js/adminlte.min.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('/public/adminlte') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="{{ asset('/public/adminlte') }}/plugins/toastr/toastr.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/select2/js/select2.full.min.js"></script>
    <!-- pace-progress -->
    <script src="{{ asset('/public/adminlte') }}/plugins/pace-progress/pace.min.js"></script>
    <script src="{{ asset('/public/style') }}/plugins/chart.js/Chart.min.js"></script>
    <script src="{{ asset('/public/adminlte') }}/plugins/chart.js/Chart.min.js"></script>



    <script>
        $(function() {
            $('#table1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            //Initialize Select2 Elements
            $('.select2').select2()
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>

    @yield('script')

</body>

</html>
