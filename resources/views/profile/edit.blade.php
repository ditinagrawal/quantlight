@extends('layouts.admin')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('breadcrumb')
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <!-- Profile Information -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Profile Information</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">Update your account's profile information and email address.</p>
                    
                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>Profile updated successfully!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" 
                                   required autofocus>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-sm text-warning">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Your email address is unverified.
                                        <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 text-primary">
                                                Click here to re-send the verification email.
                                            </button>
                                        </form>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="text-sm text-success mt-2">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            A new verification link has been sent to your email address.
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Password -->
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Update Password</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">Ensure your account is using a long, random password to stay secure.</p>

                    @if (session('status') === 'password-updated')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>Password updated successfully!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="current_password">Current Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                                   id="current_password" name="current_password" 
                                   autocomplete="current-password">
                            @error('current_password', 'updatePassword')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                                   id="password" name="password" 
                                   autocomplete="new-password">
                            @error('password', 'updatePassword')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" 
                                   autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle"></i> Delete Account
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Once your account is deleted, all of its resources and data will be permanently deleted. 
                        Before deleting your account, please download any data or information that you wish to retain.
                    </p>

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">
                        <i class="fas fa-trash"></i> Delete Account
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- User Info Card -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-circle"></i> Account Information</h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Name</dt>
                        <dd>{{ $user->name }}</dd>
                        
                        <dt>Email</dt>
                        <dd>{{ $user->email }}</dd>
                        
                        <dt>Email Verified</dt>
                        <dd>
                            @if($user->hasVerifiedEmail())
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Verified
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Not Verified
                                </span>
                            @endif
                        </dd>
                        
                        <dt>Member Since</dt>
                        <dd>{{ $user->created_at?->format('M d, Y') ?? 'N/A' }}</dd>
                    </dl>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Quick Links</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="{{ route('dashboard') }}" class="text-dark">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.blogs.index') }}" class="text-dark">
                                <i class="fas fa-newspaper mr-2"></i> Manage Blogs
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.webinars.index') }}" class="text-dark">
                                <i class="fas fa-video mr-2"></i> Manage Webinars
                            </a>
                        </li>
                        <li>
                            <a href="/" target="_blank" class="text-dark">
                                <i class="fas fa-external-link-alt mr-2"></i> View Site
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteAccountModalLabel">
                        <i class="fas fa-exclamation-triangle"></i> Delete Account
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <p class="mb-3">
                            <strong>Are you sure you want to delete your account?</strong>
                        </p>
                        <p class="text-muted">
                            Once your account is deleted, all of its resources and data will be permanently deleted. 
                            Please enter your password to confirm you would like to permanently delete your account.
                        </p>

                        <div class="form-group">
                            <label for="delete_password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                   id="delete_password" name="password" 
                                   placeholder="Enter your password" required>
                            @error('password', 'userDeletion')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
