@extends('layouts.main')
@section('title', 'News Management — Admin')
@section('content')
<section class="py-4" style="background:#f0f4ff; min-height:80vh;">
<div class="container">

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-2">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
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
            <h2 class="fw-bold mb-1"><i class="bi bi-newspaper me-2"></i>News &amp; Posts</h2>
            <p class="opacity-75 mb-0">Manage Latest News, Match Reports, and Media Highlights</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm fw-bold" style="color:#10316B;">
            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>
</div>

{{-- Add Post Form --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header py-3 fw-bold d-flex justify-content-between align-items-center" style="background:#10316B;color:#fff;">
        <span><i class="bi bi-plus-circle-fill me-2"></i>Publish New Post</span>
        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#addPostForm" style="color:#10316B;">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div class="collapse show" id="addPostForm">
        <div class="card-body p-4">
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Post headline" required value="{{ old('title') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="latest" {{ old('type') === 'latest' ? 'selected' : '' }}>Latest News</option>
                            <option value="report" {{ old('type') === 'report' ? 'selected' : '' }}>Match Report</option>
                            <option value="media"  {{ old('type') === 'media'  ? 'selected' : '' }}>Media Highlight</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control" rows="5" required
                                  placeholder="Write the full post content here...">{{ old('content') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Cover Image <small class="text-muted">(optional, max 3MB)</small></label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Video / YouTube Link <small class="text-muted">(for Media type)</small></label>
                        <input type="url" name="meta_link" class="form-control" placeholder="https://youtube.com/watch?v=..." value="{{ old('meta_link') }}">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success fw-bold px-5">
                            <i class="bi bi-send-fill me-2"></i>Publish Post
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Posts List --}}
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header py-3 fw-bold d-flex justify-content-between align-items-center" style="background:#10316B;color:#fff;">
        <span><i class="bi bi-list-ul me-2"></i>All Posts</span>
        <span class="badge bg-warning text-dark">{{ $posts->count() }} posts</span>
    </div>
    <div class="card-body p-0">
        @if($posts->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-newspaper fs-1 d-block mb-2"></i>No posts yet. Publish one above.
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width:70px;">Image</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th class="d-none d-md-table-cell">Content Preview</th>
                        <th class="d-none d-lg-table-cell">Published</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td class="ps-3">
                            <img src="{{ asset($post->image_path) }}"
                                 alt="{{ $post->title }}"
                                 class="rounded-2"
                                 style="width:56px;height:42px;object-fit:cover;"
                                 onerror="this.src='{{ asset('images/OFA New Logo.jpg') }}'">
                        </td>
                        <td class="fw-semibold" style="color:#10316B;max-width:200px;">
                            {{ Str::limit($post->title, 50) }}
                        </td>
                        <td>
                            @php
                                $typeColors = ['latest' => 'primary', 'report' => 'success', 'media' => 'danger'];
                                $typeLabels = ['latest' => 'Latest News', 'report' => 'Match Report', 'media' => 'Media'];
                            @endphp
                            <span class="badge bg-{{ $typeColors[$post->type] ?? 'secondary' }}">
                                {{ $typeLabels[$post->type] ?? $post->type }}
                            </span>
                        </td>
                        <td class="d-none d-md-table-cell text-muted small" style="max-width:250px;">
                            {{ Str::limit($post->content, 80) }}
                        </td>
                        <td class="d-none d-lg-table-cell small text-muted">
                            {{ $post->created_at->format('d M Y') }}
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('admin.news.edit', $post) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('admin.news.destroy', $post) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this post?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

</div>
</section>
@endsection
