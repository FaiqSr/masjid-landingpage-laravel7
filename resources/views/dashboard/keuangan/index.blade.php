@extends('layout.main')
@section('title', 'Laporan Keuangan Masjid')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Laporan Keuangan Masjid</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('keuangan.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Buat Laporan Baru</a>
        </div>
        <div class="card-body">
            <table id="table1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Akun/Keterangan</th>
                        <th>Saldo Awal</th>
                        <th>Total Debet</th>
                        <th>Total Kredit</th>
                        <th>Saldo Akhir</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->periode)->translatedFormat('d F Y') }}</td>
                            <td>
                                <strong>{{ $item->akun }}</strong><br>
                                <small>{{ $item->keterangan }}</small>
                            </td>
                            <td>Rp {{ number_format($item->saldo_awal, 0, ',', '.') }}</td>
                            <td class="text-success">Rp {{ number_format($item->total_debet, 0, ',', '.') }}</td>
                            <td class="text-danger">Rp {{ number_format($item->total_kredit, 0, ',', '.') }}</td>
                            <td><strong>Rp {{ number_format($item->saldo_akhir, 0, ',', '.') }}</strong></td>
                            <td class="text-center">
                                <a href="{{ route('keuangan.show', $item->id) }}" class="btn btn-sm btn-info"
                                    title="Kelola Detail">
                                    <i class="fas fa-list"></i> Kelola Detail
                                </a>
                                <button onclick="del({{ $item->id }})" class="btn btn-sm btn-danger"
                                    title="Hapus Laporan">
                                    <i class="fas fa-trash"></i>
                                </button>
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
        function del(id) {
            Swal.fire({
                title: "Anda yakin?",
                text: "Menghapus laporan akan menghapus SEMUA transaksinya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('dashboard/keuangan/delete') }}/" + id;
                }
            });
        }
    </script>
@endsection
