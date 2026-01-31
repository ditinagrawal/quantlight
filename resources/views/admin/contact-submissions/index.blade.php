@extends('layouts.admin')

@section('title', 'All Contact Submissions')
@section('page-title', 'All Contact Submissions')

@section('breadcrumb')
    <li class="breadcrumb-item active">Contact Submissions</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Contact Submissions</h3>
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
                            <th>Subject</th>
                            <th>Submitted</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $submission)
                            <tr>
                                <td>{{ $submission->id }}</td>
                                <td><strong>{{ $submission->name }}</strong></td>
                                <td>{{ $submission->email }}</td>
                                <td>{{ $submission->phone }}</td>
                                <td>{{ Str::limit($submission->subject, 40) }}</td>
                                <td>{{ $submission->created_at?->format('M d, Y h:i A') ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.contact-submissions.show', $submission->id) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <form action="{{ route('admin.contact-submissions.destroy', $submission->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this submission?');">
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
                                    <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No contact submissions found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($submissions->hasPages())
            <div class="card-footer clearfix">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
@endsection

