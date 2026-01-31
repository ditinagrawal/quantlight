@extends('layouts.public')

@section('title', 'Our Blogs - ByteWork')

@section('styles')
    /* Blog Grid Section */
    .blog-section {
        padding: 80px 0;
        background-color: #f8f9fa;
    }

    .blog-card {
        background: #fff;
        border-radius: 0;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        position: relative;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
    }

    .blog-card-img-wrapper {
        overflow: hidden;
        height: 280px;
    }

    .blog-card-img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .blog-card:hover .blog-card-img {
        transform: scale(1.05);
    }

    .blog-card-body {
        padding: 30px;
    }

    .blog-card-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 20px;
        line-height: 1.4;
        color: #1a1a1a;
        min-height: 70px;
    }

    .blog-card-title a {
        color: #1a1a1a;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .blog-card-title a:hover {
        color: #c9a96e;
    }

    .blog-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 0;
        padding-top: 20px;
        border-top: 1px solid #e5e5e5;
    }

    .blog-category {
        display: inline-block;
        color: #666;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .blog-date {
        color: #999;
        font-size: 0.9rem;
        margin-left: auto;
    }

    .blog-percentage {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #fff;
        color: #1a1a1a;
        padding: 8px 15px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 10;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #c9a96e;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #666;
    }

    .pagination {
        justify-content: center;
        margin-top: 40px;
    }

    .pagination .page-link {
        color: #1a1a1a;
        border: 1px solid #e5e5e5;
        padding: 10px 18px;
        margin: 0 5px;
        border-radius: 5px;
    }

    .pagination .page-link:hover {
        background: #c9a96e;
        border-color: #c9a96e;
        color: #fff;
    }

    .pagination .page-item.active .page-link {
        background: #c9a96e;
        border-color: #c9a96e;
        color: #fff;
    }
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Our Blogs</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-nav">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Our Blogs</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Blog Grid Section -->
    <section class="blog-section">
        <div class="container">
            @if($blogs->count() > 0)
                <div class="row">
                    @foreach ($blogs as $blog)
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-card">
                                <div class="blog-card-img-wrapper">
                                    <img src="{{ $blog->image_url ?? 'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=800' }}" alt="{{ $blog->title }}" class="blog-card-img">
                                </div>
                                <div class="blog-card-body">
                                    <h3 class="blog-card-title">
                                        <a href="{{ url('/news/' . $blog->slug) }}">{{ $blog->title }}</a>
                                    </h3>
                                    <div class="blog-meta">
                                        <span class="blog-category">{{ $blog->category?->name ?? 'Uncategorized' }}</span>
                                        <span class="divider"></span>
                                        <span class="blog-date">{{ $blog->created_at?->format('F d, Y') ?? 'Recently' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $blogs->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="far fa-newspaper"></i>
                    <h3>No articles yet</h3>
                    <p>Check back soon for new content!</p>
                </div>
            @endif
        </div>
    </section>
@endsection
