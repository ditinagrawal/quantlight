@extends('layouts.admin')

@section('title', 'All Webinars')
@section('page-title', 'All Webinars')

@section('breadcrumb')
    <li class="breadcrumb-item active">Webinars</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Webinar List</h3>
            <div class="card-tools">
                <a href="{{ route('admin.webinars.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Webinar
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
                            <th>Event Date</th>
                            <th>Registrations</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th style="width: 200px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($webinars as $webinar)
                            <tr>
                                <td>{{ $webinar->id }}</td>
                                <td>
                                    @if($webinar->image_url)
                                        <img src="{{ $webinar->image_url }}" alt="{{ $webinar->title }}" class="img-thumbnail" style="width: 60px; height: 45px; object-fit: cover;">
                                    @else
                                        <span class="badge badge-secondary"><i class="fas fa-image"></i> No</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ Str::limit($webinar->title, 50) }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $webinar->slug }}</small>
                                </td>
                                <td>
                                    {{ $webinar->event_date?->format('M d, Y') ?? 'N/A' }}
                                    @if($webinar->event_time)
                                        <br><small class="text-muted">{{ $webinar->event_time }}</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.webinar-registrations.show', $webinar->id) }}" class="badge badge-info">
                                        <i class="fas fa-users"></i> {{ $webinar->registrations_count ?? 0 }}
                                    </a>
                                </td>
                                <td>
                                    @if($webinar->is_published)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> Published
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Draft
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $webinar->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ url('/webinars/' . $webinar->slug) }}" class="btn btn-sm btn-info" target="_blank" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.webinar-registrations.show', $webinar->id) }}" class="btn btn-sm btn-success" title="View Registrations">
                                            <i class="fas fa-users"></i>
                                        </a>
                                        <a href="{{ route('admin.webinars.edit', $webinar->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.webinars.destroy', $webinar->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this webinar?');">
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
                                    <i class="fas fa-video fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No webinars found.</p>
                                    <a href="{{ route('admin.webinars.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Create your first webinar
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($webinars->hasPages())
            <div class="card-footer clearfix">
                {{ $webinars->links() }}
            </div>
        @endif
    </div>
@endsection

