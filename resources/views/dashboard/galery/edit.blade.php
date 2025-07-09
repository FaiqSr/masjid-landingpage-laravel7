@extends('layout.main')

@section('title', 'testimonials')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Data</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <form action="{{ url('dashboard/galery/edit') }}" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <div class="ml-auto">
                                    <a href="{{ url('dashboard/galery') }}" class="btn btn-default">
                                        <i class="fas fa fa-reply"></i> Kembali </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @csrf
                        <input type="hidden" value="{{ $item->id }}" name="id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Detail</label>
                                    <input type="text" class="form-control" name="detail" id="detail"
                                        value="{{ $item->detail }}" required>
                                </div>
                                <div class="form-group">
                                    <h6><b>Foto Saat Ini</b></h6>
                                    <img id="preview-image" src="{{ asset('public/image/galery/' . $item->url) }}"
                                        alt="Gambar Saat Ini" class="img-fluid mb-2 rounded"
                                        style="max-width: 100%; height: auto;">
                                </div>

                                <div class="form-group">
                                    <h6><b>Ganti Foto</b></h6>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="image"
                                            accept=".jpg,.jpeg,.png">
                                        <label class="custom-file-label" for="image">Browse...</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endsection

@section('script')

    <script>
        $('.custom-file input').change(function() {
            var $el = $(this),
                files = $el[0].files,
                label = files[0].name;
            if (files.length > 1) {
                label = label + " and " + String(files.length - 1) + " more files"
            }
            $el.next('.custom-file-label').html(label);
        });
    </script>


    <script>
        $('#image').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);

            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>

@endsection
