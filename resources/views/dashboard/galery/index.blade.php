@extends('layout.main')

@section('title', 'testimonials')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>testimonials</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ url('dashboard/galery/add') }}" class="btn btn-primary"> <i class="fas fa-plus"></i> Tambah Data</a>
        </div>
        <div class="card-body">
            <table id="table1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="20px">No</th>
                        <th>Foto</th>
                        <th>Detail</th>
                        <th class="text-center" width="150px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="d-flex justify-content-start">
                                @if ($item->url == '')
                                    <img class="img-fluid mb-3" src="{{ url('public/img/empty.png') }}" alt="Photo"
                                        width="40" height="40">
                                @else
                                    <a href="#" data-toggle="modal" data-target="#myModal{{ $item->id }}"
                                        title="Perbesar">
                                        <img class="rounded mx-auto d-block"
                                            src="{{ url('public/image/galery/' . $item->url ?? '/') }}" alt="Foto"
                                            style="object-fit: cover" height="200" width="200"></a>
                                @endif
                            </td>
                            <td class="align-middle">{{ $item->detail }}</td>
                            <td class="text-center align-middle">
                                <a href="{{ url('dashboard/galery/edit/' . $item->id) }}" class="btn btn-xs btn-warning"
                                    title="Edit"><i class="fas fa-edit"></i> </a>
                                <button onclick="del({{ $item->id }})" class="btn btn-xs btn-danger" title="Hapus"><i
                                        class="fas fa-trash"></i> </button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal{{ $item->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Image Sliders
                                        </h5>
                                        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img class="zoom" src="{{ url('public/image/galery/' . $item->url ?? '/') }}"
                                            height="100%" width="100%">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-primary btn-block ml-1"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                timer: 2000
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
                timer: 2000
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
                timer: 2000
            });

            Toast.fire({
                icon: 'success',
                title: ' &nbsp; Hapus Data Berhasil'
            });
        }

        function del(id) {
            Swal.fire({
                title: "Ingin Menghapus Data ini?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('dashboard/galery/delete') }}/" + id;
                }
            });
        }
    </script>

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
