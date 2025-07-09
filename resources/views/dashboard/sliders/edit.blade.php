@extends('layout.main')

@section('title', 'sliders')

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
        <div class="col-md-4">
            <form action="{{ url('dashboard/sliders/edit') }}" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <div class="ml-auto">
                                    <a href="{{ url('dashboard/sliders/index') }}" class="btn btn-default">
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
                                    <label>Image Url</label>
                                    {{-- <input type="text" class="form-control" name="image_url" id="image_url"
                                        value="{{ $row->image_url }}" required> --}}
                                    <input type="hidden" name="id" value="{{ $row->id }}">
                                    <img class="rounded d-block"
                                        src="{{ url('public/img/uploads/' . $row->image_url ?? '/') }}" width="200"
                                        height="200">
                                    <br>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image1" id="image1"
                                            accept=".jpg,.png" required>
                                        <label class="custom-file-label" for="exampleInputFile">Browse...</label>
                                    </div>
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

@endsection
