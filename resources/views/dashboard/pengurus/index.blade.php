@extends('layout.main')
@section('title', 'Manajemen Pengurus')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Manajemen Pengurus</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('pengurus.create') }}" class="btn btn-primary"> <i class="fas fa-plus"></i> Tambah Pengurus</a>
        </div>
        <div class="card-body">
            <table id="table1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="20px">No</th>
                        <th width="100px">Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th class="text-center" width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ url('public/img/pengurus/' . $item->foto) }}" alt="{{ $item->nama }}"
                                    width="80">
                            </td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td class="text-center">
                                <div>
                                    <a href="{{ route('pengurus.edit', $item->id) }}" class="btn btn-xs btn-warning"
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
                title: "Anda yakin?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('dashboard/pengurus/delete') }}/" + id;
                }
            });
        }
    </script>
@endsection
