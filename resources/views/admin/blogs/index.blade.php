@extends('layouts.admin')

@section('title', 'All Blogs')
@section('page-title', 'All Blogs')

@section('breadcrumb')
    <li class="breadcrumb-item active">Blogs</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Blog List</h3>
            <div class="card-tools">
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Blog
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th style="width: 80px">Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                            <tr>
                                <td>{{ $blog->id }}</td>
                                <td>
                                    @if($blog->image_url)
                                        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="img-thumbnail" style="width: 60px; height: 45px; object-fit: cover;">
                                    @else
                                        <span class="badge badge-secondary"><i class="fas fa-image"></i> No</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ Str::limit($blog->title, 50) }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $blog->slug }}</small>
                                </td>
                                <td>
                                    @if($blog->category_name)
                                        <span class="badge badge-info">{{ $blog->category_name }}</span>
                                    @else
                                        <span class="badge badge-secondary">No Category</span>
                                    @endif
                                </td>
                                <td>
                                    @if($blog->is_published)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> Published
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Draft
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $blog->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ url('/news/' . $blog->slug) }}" class="btn btn-sm btn-info" target="_blank" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No blogs found.</p>
                                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Create your first blog
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($blogs->hasPages())
            <div class="card-footer clearfix">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>
@endsection

