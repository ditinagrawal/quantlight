@extends('layouts.admin')

@section('title', 'All Citations')
@section('page-title', 'All Citations')

@section('breadcrumb')
    <li class="breadcrumb-item active">Citations</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Citations List</h3>
            <div class="card-tools">
                <a href="{{ route('admin.citations.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Citation
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citations as $citation)
                            <tr>
                                <td>{{ $citation->id }}</td>
                                <td>
                                    <strong>{{ Str::limit($citation->title, 60) }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit($citation->description, 80) }}</small>
                                </td>
                                <td>{{ $citation->published_date?->format('M d, Y') ?? 'N/A' }}</td>
                                <td>
                                    @if($citation->is_published)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> Published
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Draft
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ $citation->link }}" class="btn btn-sm btn-info" target="_blank" title="View External Link">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <a href="{{ route('admin.citations.edit', $citation->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.citations.destroy', $citation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this citation?');">
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
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No citations found.</p>
                                    <a href="{{ route('admin.citations.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Create your first citation
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($citations->hasPages())
            <div class="card-footer clearfix">
                {{ $citations->links() }}
            </div>
        @endif
    </div>
@endsection
