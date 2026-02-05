@extends('layouts.admin')

@section('title', 'Edit Lab Update')
@section('page-title', 'Edit Lab Update')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.lab-updates.index') }}">Lab Updates</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Lab Update</h3>
                </div>
                <form action="{{ route('admin.lab-updates.update', $labUpdate->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $labUpdate->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="excerpt">Excerpt / Short description</label>
                            <textarea name="excerpt" id="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3">{{ old('excerpt', $labUpdate->excerpt) }}</textarea>
                            @error('excerpt')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="categories">Categories / Tags</label>
                            <input type="text" name="categories" id="categories" class="form-control @error('categories') is-invalid @enderror" value="{{ old('categories', $labUpdate->categories) }}" placeholder="e.g. Photonics, Vector Beams">
                            @error('categories')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="text-muted">Comma-separated.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="published_date">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="published_date" id="published_date" class="form-control @error('published_date') is-invalid @enderror" value="{{ old('published_date', $labUpdate->published_date?->format('Y-m-d')) }}" required>
                                    @error('published_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort_order">Sort order</label>
                                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $labUpdate->sort_order) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="link">Read more link</label>
                            <input type="url" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $labUpdate->link) }}" placeholder="https://...">
                            @error('link')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            @if($labUpdate->image_url)
                                <div class="mb-2">
                                    <img src="{{ $labUpdate->image_url }}" alt="" class="img-thumbnail" style="max-height: 120px;">
                                    <div class="custom-control custom-checkbox mt-1">
                                        <input type="checkbox" class="custom-control-input" id="remove_image" name="remove_image" value="1">
                                        <label class="custom-control-label" for="remove_image">Remove image</label>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                            @error('image')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" value="1" {{ $labUpdate->is_published ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_published">Published (show on homepage)</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                        <a href="{{ route('admin.lab-updates.index') }}" class="btn btn-secondary">Cancel</a>
                        @if($labUpdate->link)
                            <a href="{{ $labUpdate->link }}" class="btn btn-info float-right" target="_blank"><i class="fas fa-external-link-alt"></i> View link</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Info</h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Created</dt>
                        <dd>{{ $labUpdate->created_at?->format('M d, Y H:i') ?? 'N/A' }}</dd>
                        <dt>Updated</dt>
                        <dd>{{ $labUpdate->updated_at?->format('M d, Y H:i') ?? 'N/A' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
