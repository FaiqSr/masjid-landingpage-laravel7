@extends('layout.main')
@section('title', 'News Detail')

@section('breadcrums')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Detail Berita</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('news/index') }}">Berita</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">{{ $new->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('news/index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4 d-flex justify-content-center">
                        <img src="{{ asset('public/img/uploads/' . $new->image_url) }}" class="img-fluid rounded"
                            alt="Thumbnail Berita" style="max-width: 400px;">
                    </div>

                    <label>Konten Berita</label>
                    <div class="p-3"
                        style="border: 1px solid #e9ecef; border-radius: .25rem; background-color: #f8f9fa;">
                        {!! $new->content !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
