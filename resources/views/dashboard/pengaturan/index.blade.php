@extends('layout.main')

@section('title', $title)

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ $title }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}">Home</a></li>
                <li class="breadcrumb-item active">Pengaturan PPDB</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')

    @if(session('sukses'))
        <div class="alert alert-success">{{ session('sukses') }}</div>
    @endif
    @if(session('gagal'))
        <div class="alert alert-danger">{{ session('gagal') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Tahun Ajaran Baru</h3>
                </div>
                <form action="{{ route('pengaturan.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tahun_ajaran">Tahun Ajaran</label>
                            <input type="text" class="form-control" name="tahun_ajaran" id="tahun_ajaran" placeholder="Contoh: 2025/2026" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status Awal</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                                <option value="Aktif">Aktif</option>
                            </select>
                            <small class="form-text text-muted">Jika diatur "Aktif", maka tahun ajaran lain yang aktif akan otomatis dinonaktifkan.</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Tahun Ajaran</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Tahun Ajaran</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 35%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tahun_ajaran as $ta)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $ta->tahun_ajaran }}</td>
                                <td class="text-center">
                                    @if($ta->status == 'Aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($ta->status == 'Tidak Aktif')
                                    <form action="{{ route('pengaturan.setActive', $ta->id_tahun_ajaran) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-xs btn-success">
                                            <i class="fas fa-check"></i> Jadikan Aktif
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <button class="btn btn-xs btn-danger" onclick="confirmDelete('{{ $ta->id_tahun_ajaran }}')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                    <form id="delete-form-{{ $ta->id_tahun_ajaran }}" action="{{ route('pengaturan.destroy', $ta->id_tahun_ajaran) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data tahun ajaran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang sudah memiliki siswa tidak dapat dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection