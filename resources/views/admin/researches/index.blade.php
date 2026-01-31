@extends('layouts.admin')

@section('title', 'All Researches')
@section('page-title', 'All Researches')

@section('breadcrumb')
    <li class="breadcrumb-item active">Researches</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Research Capabilities List</h3>
            <div class="card-tools">
                <a href="{{ route('admin.researches.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Research
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
                            <th>Status</th>
                            <th>Created</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($researches as $research)
                            <tr>
                                <td>{{ $research->id }}</td>
                                <td>
                                    @if($research->image_url)
                                        <img src="{{ $research->image_url }}" alt="{{ $research->title }}" class="img-thumbnail" style="width: 60px; height: 45px; object-fit: cover;">
                                    @else
                                        <span class="badge badge-secondary"><i class="fas fa-image"></i> No</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ Str::limit($research->title, 50) }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $research->slug }}</small>
                                </td>
                                <td>
                                    @if($research->is_published)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> Published
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Draft
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $research->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ url('/' . $research->slug) }}" class="btn btn-sm btn-info" target="_blank" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.researches.edit', $research->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.researches.destroy', $research->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this research?');">
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
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-flask fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No researches found.</p>
                                    <a href="{{ route('admin.researches.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Create your first research
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($researches->hasPages())
            <div class="card-footer clearfix">
                {{ $researches->links() }}
            </div>
        @endif
    </div>
@endsection
