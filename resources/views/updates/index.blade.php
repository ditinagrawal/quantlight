@extends('layouts.quantlight')

@section('title', 'Updates')
@section('description', 'Latest discoveries and updates from QuantLight lab')

@section('content')
  <!-- breadcrumb -->
  <section class="breadcrumb-section__area heading-bg">
    <div class="breadcrumb-section__wrapper" data-background="/quantlight/assets/img/bg.jpg">
      <div class="container">
        <div class="breadcrumb-section__content text_center breadcrumb-section__space">
          <h3 class="breadcrumb-section__title">Updates</h3>
        </div>
      </div>
      <div class="breadcrumb-section__border"></div>
    </div>
  </section>

  <!-- updates grid - 3 columns -->
  <section class="blog-section-4__area section-space fix section-space fade-wrapper">
    <div class="container">
      <div class="blog-section-4__top">
        <div class="section-heading__wrap_3 section-heading__wrap_4">
          <span class="section__subtitle rr-title-anim mb-15">
            <img src="/quantlight/assets/img/icon/section-title-4-shape.svg" alt="icon" />
            Lab Updates
            <img src="/quantlight/assets/img/icon/section-title-4-shape.svg" alt="icon" />
          </span>
          <h3 class="section__title rr-title-anim">
            Latest discoveries & updates <br /> from our lab
          </h3>
        </div>
      </div>

      <div class="row">
        @forelse($updates as $update)
          <div class="col-lg-6 col-md-6 mb-30">
            <div class="blog-section-4__item">
              <div class="blog-section-4__thumb">
                <a href="{{ route('updates.show', $update->slug) }}">
                  <img
                    src="{{ $update->image_url ?? '/quantlight/assets/img/blog1.png' }}"
                    alt="{{ $update->title }}"
                    class="update-card-img"
                  />
                </a>
              </div>
              <div class="blog-section-4__content">
                <div class="blog-section-4__cat">
                  @foreach($update->categories_array as $cat)
                    <span>{{ $cat }}</span>
                  @endforeach
                  @if(empty($update->categories_array))
                    <span>Update</span>
                  @endif
                </div>
                <h3 class="blog-section-4__title">
                  <a href="{{ route('updates.show', $update->slug) }}">{{ $update->title }}</a>
                </h3>
                <div class="blog-section-4__date">
                  <span>{{ $update->published_date?->format('m/d/Y') ?? '' }}</span>
                </div>
                <div class="blog-section-4__btn">
                  <a href="{{ route('updates.show', $update->slug) }}">
                    READ MORE <i class="fa-light fa-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12 text-center py-5">
            <p class="opacity_7">No updates yet. Check back soon.</p>
          </div>
        @endforelse
      </div>
    </div>
  </section>
@endsection
