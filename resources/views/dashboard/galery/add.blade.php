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
            <form action="{{ url('dashboard/galery/add') }}" method="post" enctype="multipart/form-data">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Detail</label>
                                    <input type="text" class="form-control" name="detail" id="detail" required>
                                </div>
                                <div class="form-group">
                                    <h6><b>Foto</b></h6>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="image"
                                            accept=".jpg,.png" required>
                                        <label class="custom-file-label" for="image">Browse...</label>
                                    </div>
                                    {{-- Image Preview Container --}}
                                    <div class="mt-2">
                                        <img id="image-preview" src="#" alt="Image Preview" class="img-fluid rounded"
                                            style="display: none; max-height: 200px;" />
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
        // Function to show image preview
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('.custom-file input').change(function() {
            var $el = $(this),
                files = $el[0].files,
                label = files[0].name;
            if (files.length > 1) {
                label = label + " and " + String(files.length - 1) + " more files"
            }
            $el.next('.custom-file-label').html(label);

            // Call the preview function
            readURL(this);
        });
    </script>

@endsection
