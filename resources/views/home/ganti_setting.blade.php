@extends('layout.main')

@section('title', 'Tentang Kami')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tentang Kami</h1>
        </div>
        <div class="col-sm-6">

        </div>
    </div>
@endsection

@section('content')
    @php
        $setting = DB::table('tbl_setting')->where('tbl_setting.id', '=', '1')->get();
    @endphp
    @foreach ($setting as $item)
        @php
            $tentang_kami = $item->tentang_kami;
        @endphp
    @endforeach

@section('content')
    <div class="row">
        <div class="col-md-6">
            <form action="{{ url('ganti_setting/resetsetting') }}" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <div class="ml-auto">
                                    <a href="{{ url('invoice/index') }}" class="btn btn-default">
                                        <i class="fas fa fa-reply"></i> Kembali </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tentang Kami</label>
                                    <textarea name="tentang_kami" id="tentang_kami" cols="2" rows="5" class="form-control" required>{{ $tentang_kami }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endsection

@endsection

@section('script')

<script>
    function edit_sukses() {
        Swal.fire({
            icon: 'success',
            title: ' &nbsp; Edit Data Berhasil'
        });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.21.0/ckeditor.js"
    integrity="sha512-ff67djVavIxfsnP13CZtuHqf7VyX62ZAObYle+JlObWZvS4/VQkNVaFBOO6eyx2cum8WtiZ0pqyxLCQKC7bjcg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    CKEDITOR.replace('tentang_kami', {
        height: 300
    });
</script>

@if (session('edit_sukses'))
    <script>
        edit_sukses();
    </script>
@endif
@endsection
