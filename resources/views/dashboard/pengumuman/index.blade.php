@extends('layout.main')
@section('title', 'Manajemen Pengumuman')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Manajemen Pengumuman</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('pengumuman.create') }}" class="btn btn-primary"> <i class="fas fa-plus"></i> Buat Pengumuman</a>
        </div>
        <div class="card-body">
            <table id="table1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="20px">No</th>
                        <th width="120px">Foto</th>
                        <th>Judul Pengumuman</th>
                        <th width="150px">Tanggal Dibuat</th>
                        <th class="text-center" width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ url('public/img/pengumuman/' . $item->foto) }}" alt="{{ $item->name }}"
                                    width="100">
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                            <td class="text-center">
                                <div>
                                    <a href="{{ route('pengumuman.edit', $item->id) }}" class="btn btn-xs btn-warning"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="del({{ $item->id }})" class="btn btn-xs btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
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
        @if (session('add_sukses') || session('edit_sukses') || session('delete_sukses'))
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: ' &nbsp; {{ session('add_sukses') ?? (session('edit_sukses') ?? session('delete_sukses')) }}'
            });
        @endif

        function del(id) {
            Swal.fire({
                title: "Anda yakin ingin menghapus?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('dashboard/pengumuman/delete') }}/" + id;
                }
            });
        }
    </script>
@endsection
