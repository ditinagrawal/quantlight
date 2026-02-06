@extends('layouts.quantlight')

@section('title', $update->title)
@section('description', Str::limit(strip_tags($update->excerpt ?? ''), 160))

@section('content')
  <!-- breadcrumb -->
  <section class="breadcrumb-section__area heading-bg">
    <div class="breadcrumb-section__wrapper" data-background="/quantlight/assets/img/bg.jpg">
      <div class="container">
        <div class="breadcrumb-section__content text_center breadcrumb-section__space">
          <h3 class="breadcrumb-section__title">Update Details</h3>
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
            <img src="{{ $update->image_url }}" alt="{{ $update->title }}" style="width: 100%; height: auto; border-radius: 8px;" />
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
        @if($update->link)
          <div class="mb-40">
            <a href="{{ $update->link }}" target="_blank" rel="noopener" class="rr-btn hover-anim">
              Read more <i class="fa-light fa-arrow-right"></i><span class="hover-bg"></span>
            </a>
          </div>
        @endif
        <a href="{{ route('updates.index') }}" class="rr-btn rr-btn_2 hover-anim">
          <i class="fa-light fa-arrow-left"></i> Back to Updates <span class="hover-bg"></span>
        </a>
      </div>
    </div>
  </section>
@endsection
