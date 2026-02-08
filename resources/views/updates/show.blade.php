@extends('layouts.quantlight')

@section('title', $update->title)
@section('description', Str::limit(strip_tags($update->excerpt ?? ''), 160))

@push('styles')
<!-- CKEditor Content Styling (same as SmartPath) – ensures bullets, spacing, margins work on production -->
<style>
.project-details__area .update-body {
    line-height: 1.8;
}

.project-details__area .update-body p {
    margin-bottom: 1.5em;
    font-size: 17px;
    line-height: 1.8;
}

.project-details__area .update-body h1,
.project-details__area .update-body h2,
.project-details__area .update-body h3,
.project-details__area .update-body h4,
.project-details__area .update-body h5,
.project-details__area .update-body h6 {
    margin-top: 1.5em;
    margin-bottom: 1em;
    font-weight: 600;
    line-height: 1.3;
    color: var(--rr-heading-primary, #192929);
}

.project-details__area .update-body h1:first-child,
.project-details__area .update-body h2:first-child,
.project-details__area .update-body h3:first-child,
.project-details__area .update-body h4:first-child,
.project-details__area .update-body h5:first-child,
.project-details__area .update-body h6:first-child {
    margin-top: 0;
}

.project-details__area .update-body h1 { font-size: 32px; }
.project-details__area .update-body h2 { font-size: 28px; }
.project-details__area .update-body h3 { font-size: 24px; }
.project-details__area .update-body h4 { font-size: 20px; }
.project-details__area .update-body h5 { font-size: 18px; }
.project-details__area .update-body h6 { font-size: 16px; }

.project-details__area .update-body ul,
.project-details__area .update-body ol {
    margin-bottom: 1.5em;
    padding-left: 2em;
}

.project-details__area .update-body ul li,
.project-details__area .update-body ol li {
    margin-bottom: 0.5em;
    line-height: 1.8;
    display: list-item !important;
}

.project-details__area .update-body ul {
    list-style-type: disc !important;
    list-style-position: outside !important;
}

.project-details__area .update-body ol {
    list-style-type: decimal !important;
    list-style-position: outside !important;
}

.project-details__area .update-body ul ul {
    list-style-type: circle;
}

.project-details__area .update-body ol ol {
    list-style-type: lower-alpha;
}

.project-details__area .update-body blockquote {
    margin: 1.5em 0;
    padding: 1em 1.5em;
    border-left: 4px solid var(--rr-theme-primary, #0a4d3c);
    background-color: rgba(25, 41, 41, 0.05);
    font-style: italic;
}

.project-details__area .update-body code {
    background-color: rgba(25, 41, 41, 0.08);
    padding: 2px 6px;
    border-radius: 3px;
    font-family: 'Courier New', monospace;
    font-size: 0.9em;
}

.project-details__area .update-body pre {
    background-color: rgba(25, 41, 41, 0.06);
    padding: 1em;
    border-radius: 5px;
    overflow-x: auto;
    margin-bottom: 1.5em;
}

.project-details__area .update-body pre code {
    background-color: transparent;
    padding: 0;
}

.project-details__area .update-body table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1.5em;
}

.project-details__area .update-body table th,
.project-details__area .update-body table td {
    padding: 0.75em;
    border: 1px solid rgba(25, 41, 41, 0.15);
    text-align: left;
}

.project-details__area .update-body table th {
    background-color: rgba(25, 41, 41, 0.05);
    font-weight: 600;
}

.project-details__area .update-body img {
    max-width: 100%;
    height: auto;
    margin: 1.5em 0;
    border-radius: 5px;
}

.project-details__area .update-body a {
    color: var(--rr-theme-primary, #0a4d3c);
    text-decoration: underline;
}

.project-details__area .update-body a:hover {
    opacity: 0.9;
}

.project-details__area .update-body strong {
    font-weight: 600;
}

.project-details__area .update-body em {
    font-style: italic;
}

.project-details__area .update-body hr {
    margin: 2em 0;
    border: none;
    border-top: 1px solid rgba(25, 41, 41, 0.15);
}
</style>
@endpush

@section('content')
  <!-- breadcrumb -->
  <section class="breadcrumb-section__area heading-bg">
    <div class="breadcrumb-section__wrapper" data-background="/quantlight/assets/img/bg.jpg">
      <div class="container">
        <div class="breadcrumb-section__content text_center breadcrumb-section__space">
          <h3 class="breadcrumb-section__title">Details</h3>
        </div>
      </div>
      <div class="breadcrumb-section__border"></div>
    </div>
  </section>

  <!-- single update -->
  <section class="project-details__area section-space fade-wrapper">
    <div class="container">
      <div class="project-details__wrapper">
        @if($update->image_url)
          <div class="mb-40">
            <img src="{{ $update->image_url }}" alt="{{ $update->title }}" class="update-detail-img" />
          </div>
        @endif
        <div class="project-details__meta mb-30">
          <span><i class="fa-solid fa-calendar-days"></i> {{ $update->published_date?->format('d F Y') ?? '' }}</span>
          @if(!empty($update->categories_array))
            <span><i class="fa-regular fa-folder"></i> {{ implode(', ', $update->categories_array) }}</span>
          @endif
        </div>
        <h3 class="project-details__title rr-title-anim mb-30">{{ $update->title }}</h3>
        @if($update->excerpt)
          <div class="project-details__dec mb-35 opacity_7">
            {!! nl2br(e($update->excerpt)) !!}
          </div>
        @endif

        @if($update->content)
          <div class="project-details__dec update-body mb-35">
            {!! $update->content !!}
          </div>
        @endif
        <a href="{{ route('updates.index') }}" class="rr-btn rr-btn_2 hover-anim">
          <i class="fa-light fa-arrow-left"></i> Back to Updates <span class="hover-bg"></span>
        </a>
      </div>
    </div>
  </section>
@endsection
