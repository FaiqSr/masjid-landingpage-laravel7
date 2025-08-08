@extends('layout.main') {{-- Sesuaikan dengan nama file layout admin Anda --}}

@section('title', $title)

@section('breadcrumbs')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ $title }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Data Pendaftar PPDB</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Calon Siswa</h3>
                {{-- FORM FILTER BARU --}}
                <div class="card-tools">
                    <form action="{{ route('ppdb.index') }}" method="GET" class="form-inline">
                        <label for="tahun_ajaran" class="mr-2">Tahun Ajaran:</label>
                        <select name="tahun_ajaran" id="tahun_ajaran" class="form-control form-control-sm"
                            onchange="this.form.submit()">
                            @foreach ($semua_tahun_ajaran as $ta)
                                <option value="{{ $ta->id_tahun_ajaran }}"
                                    {{ $id_filter == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                                    {{ $ta->tahun_ajaran }} {{ $ta->status == 'Aktif' ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama Lengkap</th>
                            <th>Sekolah Asal</th>
                            <th>Jalur</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendaftar as $dt)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dt->nomor_pendaftaran }}</td>
                                <td>{{ $dt->nama_lengkap }}</td>
                                <td>{{ $dt->sekolah_asal }}</td>
                                <td>{{ $dt->nama_jalur }}</td>
                                <td class="text-center">
                                    @switch($dt->status_pendaftaran)
                                        @case('Diterima')
                                            <span class="badge badge-success">{{ $dt->status_pendaftaran }}</span>
                                        @break

                                        @case('Ditolak')
                                            <span class="badge badge-danger">{{ $dt->status_pendaftaran }}</span>
                                        @break

                                        @case('Cadangan')
                                            <span class="badge badge-info">{{ $dt->status_pendaftaran }}</span>
                                        @break

                                        @case('Terverifikasi')
                                            <span class="badge badge-primary">{{ $dt->status_pendaftaran }}</span>
                                        @break

                                        @default
                                            <span class="badge badge-warning">{{ $dt->status_pendaftaran }}</span>
                                    @endswitch
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('ppdb.show', $dt->id_siswa) }}" class="btn btn-info btn-sm"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('ppdb.edit', $dt->id_siswa) }}" class="btn btn-primary btn-sm"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('{{ $dt->id_siswa }}')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $dt->id_siswa }}"
                                        action="{{ route('ppdb.destroy', $dt->id_siswa) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection

    @section('script')
        <script>
            // Fungsi untuk konfirmasi hapus menggunakan SweetAlert2
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, kirim form delete
                        document.getElementById('delete-form-' + id).submit();
                    }
                })
            }
        </script>
    @endsection
