{{-- /views/dashboard/petugas/index.blade.php --}}

@extends('layout.main')

@section('title', 'Data Pengurus')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Data Pengurus</h1>
        </div>
        <div class="col-sm-6">
            {{-- You can add breadcrumb links here if needed --}}
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Jadwal Petugas Imam & Muadzin Harian</h3>
        </div>
        <div class="card-body">
            <table id="table1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="20px">No</th>
                        <th>Waktu Sholat</th>
                        <th>Imam</th>
                        <th>Muadzin</th>
                        <th class="text-center" width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data variabel $data dikirim dari controller --}}
                    {{-- Contoh di controller: $data = DB::table('petugas_harian')->orderBy('id')->get(); --}}
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->waktu }}</td>
                            <td>{{ $item->imam ?? 'Belum diatur' }}</td>
                            <td>{{ $item->muadzin ?? 'Belum diatur' }}</td>
                            <td class="text-center">
                                <div>
                                    <a href="{{ url('dashboard/petugas-harian/edit/' . $item->id) }}"
                                        class="btn btn-xs btn-warning" title="Edit Petugas">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
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
        function add_sukses() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: ' &nbsp; Tambah Data Berhasil'
            });
        }

        function edit_sukses() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: ' &nbsp; Update Data Berhasil'
            });
        }

        function delete_sukses() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: ' &nbsp; Hapus Data Berhasil'
            });
        }

        function del(id) {
            Swal.fire({
                title: "Anda yakin ingin menghapus data ini?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('dashboard/petugas/delete') }}/" + id;
                }
            });
        }
    </script>

    {{-- SweetAlert triggers based on session data --}}
    @if (session('add_sukses'))
        <script>
            add_sukses();
        </script>
    @endif

    @if (session('edit_sukses'))
        <script>
            edit_sukses();
        </script>
    @endif

    @if (session('delete_sukses'))
        <script>
            delete_sukses();
        </script>
    @endif
@endsection
