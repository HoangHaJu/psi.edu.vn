@extends('admin.layouts.master')

<link rel="stylesheet" href="{{ asset('admin/assets/css/dashboard.css') }}">
<style>

</style>

@section('content')
    <div class="container my-3">
        <div class="row g-3">
            <!-- Row wrapper -->
            {{-- <div class="row g-4"> --}}
            <!-- Single post card -->
            @foreach ($posts as $post)
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <!-- Post image -->
                        <img src="{{ asset($post->image) }}" class="card-img-top" alt="Post thumbnail"
                            style="height: 200px; object-fit: cover;">

                        <div class="card-body">
                            <!-- Post title -->
                            <h5 class="card-title text-truncate mb-2">
                                {{ $post->title }}
                            </h5>

                            <!-- Post excerpt -->
                            <p class="card-text text-muted mb-3"
                                style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $post->excerpt }}
                            </p>

                            <!-- Post metadata -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="small text-muted">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                                </div>
                                <a href="{{ route('admin.post.detail', $post->id) }}" class="btn btn-app btn-sm">Đọc
                                    thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- </div> --}}
        </div>
    </div>
@endsection
