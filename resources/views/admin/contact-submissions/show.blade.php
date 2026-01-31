@extends('layouts.admin')

@section('title', 'Contact Submission Details')
@section('page-title', 'Contact Submission Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.contact-submissions.index') }}">Contact Submissions</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contact Submission #{{ $submission->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.contact-submissions.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Submissions
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 150px;">Name:</th>
                                    <td><strong>{{ $submission->name }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>
                                        <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>
                                        <a href="tel:{{ $submission->phone }}">{{ $submission->phone }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Subject:</th>
                                    <td><strong>{{ $submission->subject }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Submitted:</th>
                                    <td>{{ $submission->created_at?->format('F d, Y h:i A') ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Message:</strong></label>
                                <div class="p-3 bg-light border rounded" style="min-height: 200px;">
                                    {{ $submission->message ?: 'No message provided.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('admin.contact-submissions.destroy', $submission->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this submission?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Submission
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

