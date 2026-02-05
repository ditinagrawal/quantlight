@extends('layouts.admin')

@section('title', 'Add Lab Update')
@section('page-title', 'Add Lab Update')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.lab-updates.index') }}">Lab Updates</a></li>
    <li class="breadcrumb-item active">Add New</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Discovery / Lab Update</h3>
                </div>
                <form action="{{ route('admin.lab-updates.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="excerpt">Excerpt / Short description</label>
                            <textarea name="excerpt" id="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="categories">Categories / Tags</label>
                            <input type="text" name="categories" id="categories" class="form-control @error('categories') is-invalid @enderror" value="{{ old('categories') }}" placeholder="e.g. Photonics, Vector Beams">
                            @error('categories')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="text-muted">Comma-separated.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="published_date">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="published_date" id="published_date" class="form-control @error('published_date') is-invalid @enderror" value="{{ old('published_date') }}" required>
                                    @error('published_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort_order">Sort order</label>
                                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="link">Read more link</label>
                            <input type="url" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="https://...">
                            @error('link')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                            @error('image')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" value="1" checked>
                                <label class="custom-control-label" for="is_published">Published (show on homepage)</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create</button>
                        <a href="{{ route('admin.lab-updates.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Tips</h3>
                </div>
                <div class="card-body">
                    <p>These appear in the <strong>Latest discoveries & updates from our lab</strong> section on the homepage.</p>
                    <ul class="mb-0">
                        <li class="mb-2"><strong>Title:</strong> Short discovery or update title.</li>
                        <li class="mb-2"><strong>Categories:</strong> e.g. Photonics, Vector Beams (comma-separated).</li>
                        <li class="mb-2"><strong>Link:</strong> Optional URL for "Read more" (news detail or external).</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
