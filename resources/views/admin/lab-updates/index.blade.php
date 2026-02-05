@extends('layouts.admin')

@section('title', 'Lab Updates')
@section('page-title', 'Lab Updates (Discoveries)')

@section('breadcrumb')
    <li class="breadcrumb-item active">Lab Updates</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Latest discoveries & updates from our lab</h3>
            <div class="card-tools">
                <a href="{{ route('admin.lab-updates.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New
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
                            <th>Categories</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($labUpdates as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    @if($item->image_url)
                                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="img-thumbnail" style="width: 60px; height: 45px; object-fit: cover;">
                                    @else
                                        <span class="badge badge-secondary"><i class="fas fa-image"></i></span>
                                    @endif
                                </td>
                                <td><strong>{{ Str::limit($item->title, 50) }}</strong></td>
                                <td>
                                    @if($item->categories)
                                        @foreach($item->categories_array as $cat)
                                            <span class="badge badge-info mr-1">{{ $cat }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $item->published_date?->format('M d, Y') ?? 'N/A' }}</td>
                                <td>
                                    @if($item->is_published)
                                        <span class="badge badge-success"><i class="fas fa-check"></i> Published</span>
                                    @else
                                        <span class="badge badge-warning"><i class="fas fa-clock"></i> Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @if($item->link)
                                            <a href="{{ $item->link }}" class="btn btn-sm btn-info" target="_blank" title="View link"><i class="fas fa-external-link-alt"></i></a>
                                        @endif
                                        <a href="{{ route('admin.lab-updates.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.lab-updates.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this lab update?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-flask fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No lab updates yet.</p>
                                    <a href="{{ route('admin.lab-updates.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add first discovery</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($labUpdates->hasPages())
            <div class="card-footer clearfix">
                {{ $labUpdates->links() }}
            </div>
        @endif
    </div>
@endsection
