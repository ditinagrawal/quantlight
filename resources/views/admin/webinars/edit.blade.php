@extends('layouts.admin')

@section('title', 'Edit Webinar')
@section('page-title', 'Edit Webinar')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.webinars.index') }}">Webinars</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.webinars.update', $webinar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Webinar Content</h3>
                    </div>
                    <div class="card-body">
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $webinar->title) }}" placeholder="Enter webinar title"
                                required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="form-group">
                            <label for="slug">Slug <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug', $webinar->slug) }}" placeholder="URL-friendly version of the title" required>
                            @error('slug')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">This will be auto-generated from the title, but you can edit it manually. Use lowercase letters, numbers, and hyphens only.</small>
                        </div>

                        <!-- Excerpt -->
                        <div class="form-group">
                            <label for="excerpt">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt"
                                name="excerpt" rows="3"
                                placeholder="Brief description of the webinar (optional)">{{ old('excerpt', $webinar->excerpt) }}</textarea>
                            @error('excerpt')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">A short summary that appears on the webinar list and in meta descriptions.</small>
                        </div>

                        <!-- Keywords -->
                        <div class="form-group">
                            <label for="keywords">Keywords</label>
                            <input type="text" class="form-control @error('keywords') is-invalid @enderror" id="keywords"
                                name="keywords" value="{{ old('keywords', $webinar->keywords) }}" placeholder="e.g., webinar, education, career guidance">
                            @error('keywords')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Comma-separated keywords for SEO (e.g., webinar, education, career guidance).</small>
                        </div>

                        <!-- Content -->
                        <div class="form-group">
                            <label for="content">Content <span class="text-danger">*</span></label>
                            @php
                                // Convert markdown to HTML for CKEditor if content is markdown
                                $content = old('content', $webinar->content);
                                $isHtml = preg_match('/<[a-z][\s\S]*>/i', $content);
                                $editorContent = $isHtml ? $content : Str::markdown($content);
                            @endphp
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content"
                                name="content">{!! $editorContent !!}</textarea>
                            @error('content')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-edit"></i> Use the toolbar above to format your content with headings, bold, italic, lists, and more.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Event Details</h3>
                    </div>
                    <div class="card-body">
                        <!-- Event Date -->
                        <div class="form-group">
                            <label for="event_date">Event Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('event_date') is-invalid @enderror"
                                id="event_date" name="event_date"
                                value="{{ old('event_date', $webinar->event_date?->format('Y-m-d')) }}" required>
                            @error('event_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Event Time -->
                        <div class="form-group">
                            <label for="event_time">Event Time</label>
                            <input type="text" class="form-control @error('event_time') is-invalid @enderror"
                                id="event_time" name="event_time" value="{{ old('event_time', $webinar->event_time) }}"
                                placeholder="e.g., 11:00am - 01:00pm">
                            @error('event_time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Format: 11:00am - 01:00pm or 4:00 PM – 6:00 PM</small>
                        </div>

                        <!-- Location -->
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                                name="location" value="{{ old('location', $webinar->location) }}"
                                placeholder="e.g., Online (Zoom) or Physical Address">
                            @error('location')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Registration Link (auto-generated) -->
                        <div class="form-group">
                            <label for="registration_link">Registration Link</label>
                            <input type="text" class="form-control" id="registration_link"
                                value="{{ $webinar->registration_link ?? url('/webinars/' . $webinar->slug) }}" readonly>
                            <small class="form-text text-muted">
                                This is automatically set to the webinar details URL and cannot be changed.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Featured Image</h3>
                    </div>
                    <div class="card-body">
                        <!-- Current Image -->
                        @if($webinar->image)
                            <div class="form-group" id="currentImageContainer">
                                <label>Current Image:</label>
                                <div class="position-relative d-inline-block">
                                    <img src="{{ $webinar->image_url }}" alt="Current Image" class="img-fluid rounded"
                                        style="max-height: 200px;">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute"
                                        style="top: 5px; right: 5px;" onclick="markImageForRemoval()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="remove_image" id="remove_image" value="0">
                            </div>
                            <div class="alert alert-warning" id="removeImageAlert" style="display: none;">
                                <i class="fas fa-exclamation-triangle"></i> Image will be removed when you save.
                                <button type="button" class="btn btn-sm btn-secondary ml-2"
                                    onclick="cancelImageRemoval()">Cancel</button>
                            </div>
                        @endif

                        <!-- Image Upload -->
                        <div class="form-group">
                            <label for="image">{{ $webinar->image ? 'Replace Image' : 'Upload Image' }}</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image"
                                    name="image" accept="image/*" onchange="previewImage(this)">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                            @error('image')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Accepted formats: JPEG, PNG, JPG, GIF, WebP. Max size:
                                2MB</small>
                        </div>

                        <!-- New Image Preview -->
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <label>New Image Preview:</label>
                            <div class="position-relative d-inline-block">
                                <img id="preview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                <button type="button" class="btn btn-danger btn-sm position-absolute"
                                    style="top: 5px; right: 5px;" onclick="removePreview()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Webinar Settings</h3>
                    </div>
                    <div class="card-body">
                        <!-- Published -->
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" {{ old('is_published', $webinar->is_published) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_published">Published</label>
                            </div>
                            <small class="form-text text-muted">Uncheck to save as draft.</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Webinar
                        </button>
                        <a href="{{ route('admin.webinars.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <!-- Webinar Info Card -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Webinar Info</h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Slug</dt>
                        <dd><code>{{ $webinar->slug }}</code></dd>

                        <dt>Event Date</dt>
                        <dd>{{ $webinar->event_date?->format('M d, Y') ?? 'N/A' }}</dd>

                        <dt>Created</dt>
                        <dd>{{ $webinar->created_at?->format('M d, Y h:i A') ?? 'N/A' }}</dd>

                        <dt>Last Updated</dt>
                        <dd>{{ $webinar->updated_at?->format('M d, Y h:i A') ?? 'N/A' }}</dd>

                        <dt>Status</dt>
                        <dd>
                            @if($webinar->is_published)
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </dd>

                        <dt>Featured Image</dt>
                        <dd>
                            @if($webinar->image)
                                <span class="badge badge-success"><i class="fas fa-check"></i> Yes</span>
                            @else
                                <span class="badge badge-secondary">No</span>
                            @endif
                        </dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/webinars/' . $webinar->slug) }}" class="btn btn-info btn-block" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Webinar
                    </a>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Danger Zone</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">Once deleted, this webinar cannot be recovered.</p>
                    <form action="{{ route('admin.webinars.destroy', $webinar->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this webinar? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-trash"></i> Delete Webinar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    let editorInstance;
    
    // Custom upload adapter for CKEditor
    class CustomUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }));
        }

        abort() {
            if (this.xhr) {
                this.xhr.abort();
            }
        }

        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("admin.ckeditor.upload") }}', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.responseType = 'json';
        }

        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${file.name}.`;

            xhr.addEventListener('error', () => reject(genericErrorText));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                // Check HTTP status
                if (xhr.status !== 200) {
                    return reject(`Upload failed with status ${xhr.status}`);
                }

                const response = xhr.response;

                // Check if response is valid
                if (!response) {
                    return reject('Invalid response from server');
                }

                // Check if upload was successful
                if (!response.uploaded || response.error) {
                    const errorMsg = response.error && response.error.message 
                        ? response.error.message 
                        : (response.error || 'Upload failed');
                    return reject(errorMsg);
                }

                // Ensure URL is absolute
                let imageUrl = response.url;
                if (!imageUrl) {
                    return reject('No URL returned from server');
                }

                // Make URL absolute if needed
                if (!imageUrl.startsWith('http://') && !imageUrl.startsWith('https://')) {
                    imageUrl = window.location.origin + (imageUrl.startsWith('/') ? imageUrl : '/' + imageUrl);
                }

                resolve({
                    default: imageUrl
                });
            });

            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }

        _sendRequest(file) {
            const data = new FormData();
            data.append('upload', file);
            this.xhr.send(data);
        }
    }

    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'bulletedList', 'numberedList', '|',
                    'blockQuote', 'codeBlock', '|',
                    'link', 'insertImage', 'insertTable', '|',
                    'undo', 'redo'
                ]
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                ]
            },
            pasteOptions: {
                plainText: false
            }
        })
        .then(editor => {
            editorInstance = editor;
            
            // Set up custom upload adapter
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new CustomUploadAdapter(loader);
            };
        })
        .catch(error => {
            console.error(error);
        });

    // Update textarea before form submission and validate
    document.querySelector('form').addEventListener('submit', function(e) {
        if (editorInstance) {
            // Update the textarea with editor content
            editorInstance.updateSourceElement();
            
            // Validate that content is not empty
            const content = editorInstance.getData().trim();
            if (!content) {
                e.preventDefault();
                alert('Please enter webinar content.');
                editorInstance.focus();
                return false;
            }
        }
    });

    // Update file input label
    const fileInput = document.querySelector('.custom-file-input');
    if (fileInput) {
        fileInput.addEventListener('change', function (e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file';
            e.target.nextElementSibling.textContent = fileName;
        });
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removePreview() {
        document.getElementById('image').value = '';
        document.getElementById('imagePreview').style.display = 'none';
        document.querySelector('.custom-file-label').textContent = 'Choose file';
    }

    function markImageForRemoval() {
        document.getElementById('remove_image').value = '1';
        document.getElementById('currentImageContainer').style.display = 'none';
        document.getElementById('removeImageAlert').style.display = 'block';
    }

    function cancelImageRemoval() {
        document.getElementById('remove_image').value = '0';
        document.getElementById('currentImageContainer').style.display = 'block';
        document.getElementById('removeImageAlert').style.display = 'none';
    }

    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const title = this.value;
        const slugInput = document.getElementById('slug');
        
        // Only auto-fill if slug is empty or matches the previous auto-generated slug
        if (!slugInput.dataset.manuallyEdited) {
            const slug = title.toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/[\s_-]+/g, '-') // Replace spaces and underscores with hyphens
                .replace(/^-+|-+$/g, ''); // Remove leading/trailing hyphens
            slugInput.value = slug;
        }
    });

    // Track manual edits to slug
    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.manuallyEdited = 'true';
    });
</script>
@endsection