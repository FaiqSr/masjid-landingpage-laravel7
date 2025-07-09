@extends('layout.main')

@section('title', 'news')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Data</h1>
        </div>
        <div class="col-sm-6">
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="w-100">
            <form action="{{ url('dashboard/news/edit') }}" method="post">
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
                            <div class="col">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" id="title"
                                        value="{{ $row->title }}" required>
                                    <input type="hidden" name="id" value="{{ $row->id }}">
                                </div>
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea type="text" class="form-control" name="content" id="content" required>{!! $row->content !!}</textarea>
                                </div>
                                <div class="form-group d-none">
                                    <label>Image Url</label>
                                    <input type="text" class="form-control" name="image_url" id="image_url"
                                        value="{{ $row->image_url }}" required>
                                </div>
                                <div class="form-group d-none">
                                    <label>Admin Photo Url</label>
                                    <input type="text" class="form-control" name="admin_photo_url"
                                        value="{{ $row->admin_photo_url }}" id="admin_photo_url" required>
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

@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.21.0/ckeditor.js"
        integrity="sha512-ff67djVavIxfsnP13CZtuHqf7VyX62ZAObYle+JlObWZvS4/VQkNVaFBOO6eyx2cum8WtiZ0pqyxLCQKC7bjcg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        CKEDITOR.replace('content', {
            height: 300
        });
    </script>
@endsection
