@extends('layouts.admin')

@section('title', 'Webinar Registrations')
@section('page-title', 'Webinar Registrations')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.webinars.index') }}">Webinars</a></li>
    <li class="breadcrumb-item active">{{ Str::limit($webinar->title, 30) }}</li>
    <li class="breadcrumb-item active">Registrations</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Registrations for: {{ $webinar->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.webinars.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Webinars
                        </a>
                        <a href="{{ route('admin.webinar-registrations.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-list"></i> All Registrations
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                    <th>Registered</th>
                                    <th style="width: 100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $registration)
                                    <tr>
                                        <td>{{ $registration->id }}</td>
                                        <td><strong>{{ $registration->name }}</strong></td>
                                        <td>{{ $registration->email }}</td>
                                        <td>{{ $registration->phone }}</td>
                                        <td>{{ $registration->location }}</td>
                                        <td>{{ $registration->created_at?->format('M d, Y h:i A') ?? 'N/A' }}</td>
                                        <td>
                                            <form action="{{ route('admin.webinar-registrations.destroy', $registration->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this registration?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No registrations found for this webinar.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($registrations->hasPages())
                    <div class="card-footer clearfix">
                        {{ $registrations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

