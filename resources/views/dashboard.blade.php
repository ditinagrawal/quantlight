@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    @php
        $totalCitations = \App\Models\Citation::count();
        $publishedCitations = \App\Models\Citation::where('is_published', true)->count();
        $draftCitations = \App\Models\Citation::where('is_published', false)->count();
        $recentCitations = \App\Models\Citation::latest('published_date')->take(5)->get();
        $totalContacts = \App\Models\ContactSubmission::count();
        $recentContacts = \App\Models\ContactSubmission::latest()->take(5)->get();
    @endphp

    <!-- Statistics Cards Row -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalCitations }}</h3>
                    <p>Total Citations</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="{{ route('admin.citations.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $publishedCitations }}</h3>
                    <p>Published Citations</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('admin.citations.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalContacts }}</h3>
                    <p>Contact Submissions</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <a href="{{ route('admin.contact-submissions.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Recent Citations -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">
                        <i class="fas fa-book mr-2"></i>
                        Recent Citations
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.citations.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> New
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCitations as $citation)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.citations.edit', $citation->id) }}" class="text-dark">
                                                <strong>{{ Str::limit($citation->title, 35) }}</strong>
                                            </a>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $citation->published_date?->format('M d, Y') ?? 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($citation->is_published)
                                                <span class="badge badge-success">Published</span>
                                            @else
                                                <span class="badge badge-warning">Draft</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="fas fa-book fa-2x mb-2"></i><br>
                                            No citations yet. <a href="{{ route('admin.citations.create') }}">Create one!</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <a href="{{ route('admin.citations.index') }}" class="btn btn-sm btn-info float-right">
                        View All <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Contact Submissions Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">
                        <i class="fas fa-envelope mr-2"></i>
                        Recent Contact Submissions
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.contact-submissions.index') }}" class="btn btn-info btn-sm">
                            View All <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentContacts as $contact)
                                    <tr>
                                        <td>
                                            <strong>{{ $contact->name }}</strong>
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                        </td>
                                        <td>{{ Str::limit($contact->subject, 30) }}</td>
                                        <td>{{ Str::limit($contact->message, 50) }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $contact->created_at?->format('M d, Y H:i') ?? 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.contact-submissions.show', $contact->id) }}" class="btn btn-xs btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-envelope fa-2x mb-2"></i><br>
                                            No contact submissions yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="row">

        <!-- Quick Actions & Welcome -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-2"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <a href="{{ route('admin.citations.create') }}" class="btn btn-primary btn-block btn-lg">
                                <i class="fas fa-book mb-2" style="font-size: 28px; display: block;"></i>
                                <small>New Citation</small>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="/citations" target="_blank" class="btn btn-success btn-block btn-lg">
                                <i class="fas fa-eye mb-2" style="font-size: 28px; display: block;"></i>
                                <small>Citations Page</small>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="/researches-capabilities" target="_blank" class="btn btn-info btn-block btn-lg">
                                <i class="fas fa-microscope mb-2" style="font-size: 28px; display: block;"></i>
                                <small>Researches Page</small>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="{{ route('admin.contact-submissions.index') }}" class="btn btn-warning btn-block btn-lg">
                                <i class="fas fa-envelope mb-2" style="font-size: 28px; display: block;"></i>
                                <small>Contacts</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Card -->
            <div class="card bg-gradient-primary">
                <div class="card-body">
                    <h5 class="card-title text-white mb-3">
                        <i class="fas fa-user-circle mr-2"></i>
                        Welcome back, {{ Auth::user()->name }}!
                    </h5>
                    <p class="card-text text-white-50 mb-3">
                        You're managing the QuantLight admin panel.
                    </p>
                    <ul class="text-white-50 mb-0" style="list-style: none; padding-left: 0;">
                        <li><i class="fas fa-check-circle mr-2"></i> Manage citations & publications</li>
                        <li><i class="fas fa-check-circle mr-2"></i> View contact submissions</li>
                        <li><i class="fas fa-check-circle mr-2"></i> Update publication links</li>
                    </ul>
                </div>
            </div>

            <!-- Statistics Summary -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Quick Stats
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <h4 class="mb-0 text-primary">{{ $totalCitations }}</h4>
                            <small class="text-muted">Citations</small>
                        </div>
                        <div class="col-6 mb-3">
                            <h4 class="mb-0 text-warning">{{ $totalContacts }}</h4>
                            <small class="text-muted">Contacts</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .small-box {
        border-radius: 0.25rem;
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        display: block;
        margin-bottom: 20px;
        position: relative;
    }
    
    .small-box > .inner {
        padding: 10px;
    }
    
    .small-box > .small-box-footer {
        background-color: rgba(0,0,0,.1);
        color: rgba(255,255,255,.8);
        display: block;
        padding: 3px 0;
        position: relative;
        text-align: center;
        text-decoration: none;
        z-index: 10;
    }
    
    .small-box:hover {
        text-decoration: none;
        color: #f9f9f9;
    }
    
    .small-box:hover .icon {
        font-size: 95px;
    }
    
    .small-box .icon {
        transition: all .3s linear;
        position: absolute;
        top: -10px;
        right: 10px;
        z-index: 0;
        font-size: 90px;
        color: rgba(0,0,0,.15);
    }
    
    .small-box h3 {
        font-size: 2.2rem;
        font-weight: bold;
        margin: 0 0 10px 0;
        white-space: nowrap;
        padding: 0;
    }
    
    .small-box p {
        font-size: 1rem;
    }
    
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        margin-bottom: 20px;
    }
    
    .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0,0,0,.125);
        padding: 0.75rem 1.25rem;
    }
    
    .card-title {
        margin-bottom: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
</style>
@endsection
