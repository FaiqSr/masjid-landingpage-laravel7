@extends('layout.main')
@section('title', 'Manajemen Layanan')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Manajemen Layanan</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('layanan.create') }}" class="btn btn-primary"> <i class="fas fa-plus"></i> Tambah Layanan</a>
        </div>
        <div class="card-body">
            <table id="table1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="20px">No</th>
                        <th width="150px">Foto</th>
                        <th>Nama Layanan</th>
                        <th class="text-center" width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ url('public/img/layanan/' . $item->foto) }}" alt="{{ $item->nama }}"
                                    width="100">
                            </td>
                            <td>{{ $item->nama }}</td>
                            <td class="text-center">
                                <div>
                                    <a href="{{ route('layanan.edit', $item->id) }}" class="btn btn-xs btn-warning"
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
    {{-- Script SweetAlert untuk notifikasi --}}
    <script>
        // Notifikasi sukses
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

        // Konfirmasi Hapus
        function del(id) {
            Swal.fire({
                title: "Anda yakin?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('dashboard/layanan/delete') }}/" + id;
                }
            });
        }
    </script>
@endsection
