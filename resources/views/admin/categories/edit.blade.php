@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Category Information</h3>
                    </div>
                    <div class="card-body">
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" placeholder="e.g., Technology, Business, Development" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">The name is how it appears on your site.</small>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Brief description of this category (optional)">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">The description is not prominent by default; however, some themes may show it.</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <!-- Category Info Card -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Category Info</h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Slug</dt>
                        <dd><code>{{ $category->slug }}</code></dd>
                        
                        <dt>Created</dt>
                        <dd>{{ $category->created_at?->format('M d, Y h:i A') ?? 'N/A' }}</dd>
                        
                        <dt>Last Updated</dt>
                        <dd>{{ $category->updated_at?->format('M d, Y h:i A') ?? 'N/A' }}</dd>
                        
                        <dt>Blogs Count</dt>
                        <dd>
                            <span class="badge badge-info">{{ $category->blogs()->count() }}</span>
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Danger Zone</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">Once deleted, this category cannot be recovered. Blogs using this category will have their category set to null.</p>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-trash"></i> Delete Category
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

