@extends('layouts.admin')

@section('title', 'Edit Citation')
@section('page-title', 'Edit Citation')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.citations.index') }}">Citations</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Citation</h3>
                </div>
                <form action="{{ route('admin.citations.update', $citation->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $citation->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $citation->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="text-muted">A brief summary of the research or publication.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="published_date">Publication Date <span class="text-danger">*</span></label>
                                    <input type="date" name="published_date" id="published_date" class="form-control @error('published_date') is-invalid @enderror" value="{{ old('published_date', $citation->published_date?->format('Y-m-d')) }}" required>
                                    @error('published_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="link">External Link <span class="text-danger">*</span></label>
                                    <input type="url" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $citation->link) }}" placeholder="https://scholar.google.com/..." required>
                                    @error('link')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Link to the external publication (e.g., Google Scholar, journal website).</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" {{ $citation->is_published ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_published">Publish this citation</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Citation
                        </button>
                        <a href="{{ route('admin.citations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <a href="{{ $citation->link }}" class="btn btn-info float-right" target="_blank">
                            <i class="fas fa-external-link-alt"></i> View External Link
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Citation Info</h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Created</dt>
                        <dd>{{ $citation->created_at?->format('M d, Y H:i') ?? 'N/A' }}</dd>
                        
                        <dt>Last Updated</dt>
                        <dd>{{ $citation->updated_at?->format('M d, Y H:i') ?? 'N/A' }}</dd>
                        
                        <dt>Status</dt>
                        <dd>
                            @if($citation->is_published)
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="card bg-light">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-lightbulb"></i> Tips</h3>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li class="mb-2"><strong>Title:</strong> Use the full title of the research paper or publication.</li>
                        <li class="mb-2"><strong>Description:</strong> Provide a brief abstract or summary of the research.</li>
                        <li class="mb-2"><strong>Date:</strong> Enter the publication date of the research.</li>
                        <li class="mb-2"><strong>Link:</strong> Add a link to Google Scholar or the journal where the citation is published.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
