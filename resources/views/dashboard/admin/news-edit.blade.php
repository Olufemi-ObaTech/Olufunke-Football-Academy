@extends('layouts.main')
@section('title', 'Edit Post — Admin')
@section('content')
<section class="py-4" style="background:#f0f4ff; min-height:80vh;">
<div class="container" style="max-width:760px;">

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mt-2">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Header --}}
<div class="p-4 rounded-4 text-white mb-4 shadow" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-pencil-fill me-2"></i>Edit Post</h2>
            <p class="opacity-75 mb-0">{{ Str::limit($post->title, 60) }}</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="btn btn-light btn-sm fw-bold" style="color:#10316B;">
            <i class="bi bi-arrow-left me-1"></i>Back to News
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <form action="{{ route('admin.news.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title', $post->title) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <option value="latest" {{ old('type', $post->type) === 'latest' ? 'selected' : '' }}>Latest News</option>
                        <option value="report" {{ old('type', $post->type) === 'report' ? 'selected' : '' }}>Match Report</option>
                        <option value="media"  {{ old('type', $post->type) === 'media'  ? 'selected' : '' }}>Media Highlight</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control" rows="8" required>{{ old('content', $post->content) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cover Image <small class="text-muted">(leave blank to keep current)</small></label>
                    <div class="mb-2">
                        <img src="{{ asset($post->image_path) }}"
                             alt="{{ $post->title }}"
                             class="rounded-2 shadow-sm"
                             style="height:80px;object-fit:cover;max-width:140px;"
                             onerror="this.src='{{ asset('images/OFA New Logo.jpg') }}'">
                    </div>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Video / YouTube Link</label>
                    <input type="url" name="meta_link" class="form-control"
                           placeholder="https://youtube.com/watch?v=..."
                           value="{{ old('meta_link', $post->meta_link) }}">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-bold px-5">
                        <i class="bi bi-save-fill me-2"></i>Save Changes
                    </button>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
</section>
@endsection
