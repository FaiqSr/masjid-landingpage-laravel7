@extends('layout.main')

@section('title', 'news')

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
        <div class="col-md">
            <form action="{{ url('dashboard/news/add') }}" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <div class="ml-auto">
                                    <a href="{{ url('dashboard/news/index') }}" class="btn btn-default">
                                        <i class="fas fa fa-reply"></i> Kembali </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" id="title" required>
                                </div>
                                <div class="form-group">
                                    <label>Admin Photo Url</label>
                                    {{-- <input type="text" class="form-control" name="admin_photo_url" id="admin_photo_url"
                                        required> --}}
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="admin_photo_url"
                                            id="admin_photo_url" accept=".jpg,.png" required>
                                        <label class="custom-file-label" for="exampleInputFile">Browse...</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Image Url</label>
                                    {{-- <input type="text" class="form-control" name="image_url" id="image_url" required> --}}
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image_url" id="image_url"
                                            accept=".jpg,.png" required>
                                        <label class="custom-file-label" for="exampleInputFile">Browse...</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea type="text" class="form-control" name="content" id="content" required></textarea>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.21.0/ckeditor.js"
        integrity="sha512-ff67djVavIxfsnP13CZtuHqf7VyX62ZAObYle+JlObWZvS4/VQkNVaFBOO6eyx2cum8WtiZ0pqyxLCQKC7bjcg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        CKEDITOR.replace('content', {
            height: 300
        });
    </script>

@endsection
