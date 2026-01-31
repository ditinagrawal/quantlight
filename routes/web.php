<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\WebinarController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\WebinarController as AdminWebinarController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Blog;
use App\Models\Webinar;
use App\Models\Citation;
use App\Models\Research;

// Helper function to serve HTML files with corrected asset paths
if (!function_exists('serveQuantLightHtml')) {
    function serveQuantLightHtml($htmlFile) {
        $filePath = public_path('quantlight/' . $htmlFile);
        
        if (!file_exists($filePath)) {
            \Log::error("QuantLight HTML file not found: {$filePath}");
            abort(404, "File not found: {$htmlFile}");
        }
        
        $content = file_get_contents($filePath);
        
        if ($content === false) {
            abort(500, "Could not read file: {$htmlFile}");
        }
        
        // Fix relative asset paths to use /quantlight/ prefix
        $content = str_replace('href="assets/', 'href="/quantlight/assets/', $content);
        $content = str_replace("href='assets/", "href='/quantlight/assets/", $content);
        $content = str_replace('src="assets/', 'src="/quantlight/assets/', $content);
        $content = str_replace("src='assets/", "src='/quantlight/assets/", $content);
        
        // Fix data attributes that contain asset paths (like data-background for banner images)
        $content = str_replace('data-background="assets/', 'data-background="/quantlight/assets/', $content);
        $content = str_replace("data-background='assets/", "data-background='/quantlight/assets/", $content);
        $content = str_replace('data-bg="assets/', 'data-bg="/quantlight/assets/', $content);
        $content = str_replace("data-bg='assets/", "data-bg='/quantlight/assets/", $content);
        
        // Fix any other data attributes that might contain asset paths
        $content = preg_replace('/(data-[^=]+)=["\']assets\//', '$1="/quantlight/assets/', $content);
        
        // Fix inline style backgrounds (handle both single and double quotes)
        $content = preg_replace('/url\(["\']?assets\//', 'url("/quantlight/assets/', $content);
        
        // Inject CSRF token meta tag in the head section
        $csrfToken = csrf_token();
        $csrfMetaTag = '<meta name="csrf-token" content="' . $csrfToken . '">';
        
        // Add CSRF token meta tag if not already present
        if (strpos($content, 'name="csrf-token"') === false) {
            // Insert after <head> tag or before </head> tag
            if (preg_match('/<head[^>]*>/i', $content)) {
                $content = preg_replace('/(<head[^>]*>)/i', '$1' . "\n    " . $csrfMetaTag, $content);
            } elseif (preg_match('/<\/head>/i', $content)) {
                $content = preg_replace('/(<\/head>)/i', '    ' . $csrfMetaTag . "\n$1", $content);
            }
        }
        
        // Fix internal HTML page links
        // Map specific pages to their routes
        $pageMap = [
            'index.html' => '/',
            'about-us.html' => '/about',
            'contact.html' => '/contact',
            'privacy-policy.html' => '/privacy',
            'privacy.html' => '/privacy',
        ];
        
        foreach ($pageMap as $oldLink => $newLink) {
            $content = str_replace('href="' . $oldLink, 'href="' . $newLink, $content);
            $content = str_replace("href='" . $oldLink, "href='" . $newLink, $content);
        }
        
        // Fix footer "Our Services" links - replace broken links with correct routes
        $footerServiceLinks = [
            'href="services-1.html"' => 'href="/about"', // Study in India
            "href='services-1.html'" => "href='/about'",
            'href="services-2.html"' => 'href="/mbbs-india"', // MBBS
            "href='services-2.html'" => "href='/mbbs-india'",
            'href="services-3.html"' => 'href="/mba-india"', // MBA
            "href='services-3.html'" => "href='/mba-india'",
            'href="study-in-india.html"' => 'href="/about"',
            "href='study-in-india.html'" => "href='/about'",
            'href="study-abroad.html"' => 'href="/study-abroad-guidance"',
            "href='study-abroad.html'" => "href='/study-abroad-guidance'",
            'href="engineering-india.html"' => 'href="/engineering-india"',
            "href='engineering-india.html'" => "href='/engineering-india'",
            'href="mbbs-india.html"' => 'href="/mbbs-india"',
            "href='mbbs-india.html'" => "href='/mbbs-india'",
            'href="mba-india.html"' => 'href="/mba-india"',
            "href='mba-india.html'" => "href='/mba-india'",
        ];
        
        // Replace footer service links
        foreach ($footerServiceLinks as $oldLink => $newLink) {
            $content = str_replace($oldLink, $newLink, $content);
        }
        
        // Fix Quick Links footer section
        $quickLinksMap = [
            'href="about-us.html"' => 'href="/about"',
            "href='about-us.html'" => "href='/about'",
            'href="webinars.html"' => 'href="/webinars"',
            "href='webinars.html'" => "href='/webinars'",
            'href="blog.html"' => 'href="/news"',
            "href='blog.html'" => "href='/news'",
            'href="news.html"' => 'href="/news"',
            "href='news.html'" => "href='/news'",
            'href="contact.html"' => 'href="/contact"',
            "href='contact.html'" => "href='/contact'",
            'href="privacy-policy.html"' => 'href="/privacy"',
            "href='privacy-policy.html'" => "href='/privacy'",
            'href="privacy.html"' => 'href="/privacy"',
            "href='privacy.html'" => "href='/privacy'",
        ];
        
        foreach ($quickLinksMap as $oldLink => $newLink) {
            $content = str_replace($oldLink, $newLink, $content);
        }
        
        // Fix other HTML links (remove .html extension for catch-all route)
        // Only match href attributes, not src (to avoid affecting images/CSS/JS)
        // But exclude the ones we've already fixed above
        $content = preg_replace('/href=["\']([^"\']+)\.html([^"\']*)["\']/', 'href="$1$2"', $content);

        // Inject dynamic latest news blogs into the homepage
        if ($htmlFile === 'index.html') {
            try {
                // Check if categories table exists
                if (Schema::hasTable('categories')) {
                    $newsBlogs = Blog::with('category')
                        ->where('is_published', true)
                        ->whereHas('category', function($query) {
                            $query->where('name', 'News');
                        })
                        ->latest()
                        ->take(3)
                        ->get();
                } else {
                    // Fallback: get blogs with category column (old way) or just latest blogs
                    $newsBlogs = Blog::where('is_published', true)
                        ->latest()
                        ->take(3)
                        ->get();
                }
            } catch (\Exception $e) {
                // Fallback if there's any error
                $newsBlogs = Blog::where('is_published', true)
                    ->latest()
                    ->take(3)
                    ->get();
            }

            $cardsHtml = '';

            foreach ($newsBlogs as $blog) {
                $imageUrl = $blog->image_url ?? '/quantlight/assets/img/blog/bg-1.jpg';
                $date = $blog->created_at?->format('d M Y') ?? '';
                $blogUrl = url('/news/' . $blog->slug);

                $cardsHtml .= '
            <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
              <div class="it-blog-item-box" data-background="assets/img/blog/bg-1.jpg">
                <div class="it-blog-item">
                  <div class="it-blog-thumb fix">
                    <a href="' . e($blogUrl) . '">
                      <img src="' . e($imageUrl) . '" alt="' . e($blog->title) . '" />
                    </a>
                  </div>
                  <div class="it-blog-meta pb-15">
                    <span>
                      <i class="fa-solid fa-calendar-days"></i>
                      ' . e($date) . '
                    </span>
                    <span>
                      <i class="fa-light fa-messages"></i>
                      ' . e(is_object($blog->category) ? ($blog->category->name ?? 'News') : ($blog->category ?? 'News')) . '
                    </span>
                  </div>
                  <h4 class="it-blog-title">
                    <a href="' . e($blogUrl) . '">
                      ' . e($blog->title) . '
                    </a>
                  </h4>
                  <a class="it-btn sm" href="' . e($blogUrl) . '">
                    <span>
                      Read More
                      <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </span>
                  </a>
                </div>
              </div>
            </div>';
            }

            // If no news blogs, leave the section empty (or you could add a fallback message)
            $newsSectionHtml = '<!-- NEWS_SECTION_START -->
          <div class="row">
' . $cardsHtml . '
          </div>
          <!-- NEWS_SECTION_END -->';

            $content = preg_replace(
                '/<!-- NEWS_SECTION_START -->(.*?)<!-- NEWS_SECTION_END -->/s',
                $newsSectionHtml,
                $content
            );

            // Inject dynamic webinars into the homepage
            try {
                $upcomingWebinars = Webinar::where('is_published', true)
                    ->where('event_date', '>=', now())
                    ->orderBy('event_date', 'asc')
                    ->take(2)
                    ->get();
                
                // If no upcoming webinars, show the next 2 published webinars regardless of date
                if ($upcomingWebinars->isEmpty()) {
                    $upcomingWebinars = Webinar::where('is_published', true)
                        ->orderBy('event_date', 'desc')
                        ->take(2)
                        ->get();
                }
            } catch (\Exception $e) {
                // Fallback if there's any error
                $upcomingWebinars = Webinar::where('is_published', true)
                    ->orderBy('event_date', 'desc')
                    ->take(2)
                    ->get();
            }

            $webinarsHtml = '';

            foreach ($upcomingWebinars as $webinar) {
                $imageUrl = $webinar->image_url ?? '/quantlight/assets/img/event/event-1-1.jpg';
                $webinarUrl = url('/webinars/' . $webinar->slug);
                $day = $webinar->event_date?->format('d') ?? '';
                $month = $webinar->event_date?->format('F') ?? ''; // Full month name (October, November, etc.)
                $excerpt = Str::limit(strip_tags($webinar->excerpt ?? $webinar->content), 100);

                $webinarsHtml .= '
            <div class="col-xl-6 col-lg-6 col-md-6 mb-30">
              <div class="it-event-2-item-box">
                <div class="it-event-2-item">
                  <div class="it-event-2-thumb fix" style="overflow: hidden; position: relative;">
                    <a href="' . e($webinarUrl) . '" style="display: block; height: 100%;">
                      <img src="' . e($imageUrl) . '" alt="' . e($webinar->title) . '" style="width: 100%; height: 300px; object-fit: cover; display: block;" />
                    </a>
                    <div class="it-event-2-date">
                      <span><i>' . e($day) . '</i> <br />' . e($month) . '</span>
                    </div>
                  </div>
                  <div class="it-event-2-content">
                    <h4 class="it-event-2-title">
                      <a href="' . e($webinarUrl) . '">' . e($webinar->title) . '</a>
                    </h4>
                    <div class="it-event-2-text">
                      <p class="mb-0 pb-10">' . e($excerpt) . '</p>
                    </div>
                    <div class="it-event-2-meta">
                      ' . ($webinar->event_time ? '<span><i class="fa-light fa-clock"></i> Time: ' . e($webinar->event_time) . '</span>' : '') . '
                      ' . ($webinar->location ? '<span><i class="fa-light fa-location-dot"></i> ' . e($webinar->location) . '</span>' : '') . '
                    </div>
                  </div>
                </div>
              </div>
            </div>';
            }

            // If no webinars, leave the section empty (or you could add a fallback message)
            $webinarsSectionHtml = '<!-- WEBINARS_SECTION_START -->
          <div class="row">
' . $webinarsHtml . '
          </div>
          <!-- WEBINARS_SECTION_END -->';

            $content = preg_replace(
                '/<!-- WEBINARS_SECTION_START -->(.*?)<!-- WEBINARS_SECTION_END -->/s',
                $webinarsSectionHtml,
                $content
            );
        }
        
        // Inject dynamic blogs into the news page
        if ($htmlFile === 'news.html') {
            try {
                // Check if categories table exists
                if (Schema::hasTable('categories')) {
                    $allBlogs = Blog::with('category')
                        ->where('is_published', true)
                        ->latest()
                        ->get();
                } else {
                    // Fallback: get blogs without category relationship
                    $allBlogs = Blog::where('is_published', true)
                        ->latest()
                        ->get();
                }
            } catch (\Exception $e) {
                // Fallback if there's any error
                $allBlogs = Blog::where('is_published', true)
                    ->latest()
                    ->get();
            }

            $blogsHtml = '';

            foreach ($allBlogs as $blog) {
                $imageUrl = $blog->image_url ?? '/quantlight/assets/img/blog/blog-sidebar-1.jpg';
                $date = $blog->created_at?->format('F d, Y') ?? '';
                $blogUrl = url('/news/' . $blog->slug);
                $excerpt = Str::limit(strip_tags($blog->excerpt ?? $blog->content), 150);

                $blogsHtml .= '
                <div class="postbox__thumb-box mb-80">
                  <div class="postbox__main-thumb mb-30">
                    <img src="' . e($imageUrl) . '" alt="' . e($blog->title) . '" />
                  </div>
                  <div class="postbox__content-box">
                    <div class="postbox__meta">
                      <span><i class="fa-light fa-calendar-days"></i>' . e($date) . '</span>
                      <span><i class="fal fa-user"></i>' . e(is_object($blog->category) ? ($blog->category->name ?? 'News') : ($blog->category ?? 'News')) . '</span>
                    </div>
                    <h4 class="postbox__details-title">
                      <a href="' . e($blogUrl) . '">' . e($blog->title) . '</a>
                    </h4>
                    <p>' . e($excerpt) . '</p>
                    <a class="it-btn mt-15" href="' . e($blogUrl) . '">
                      <span>
                        read more
                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                          <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                      </span>
                    </a>
                  </div>
                </div>';
            }

            // Replace content between markers
            $content = preg_replace(
                '/<!-- NEWS_BLOGS_START -->(.*?)<!-- NEWS_BLOGS_END -->/s',
                '<!-- NEWS_BLOGS_START -->' . $blogsHtml . '<!-- NEWS_BLOGS_END -->',
                $content
            );

            // Inject categories into the sidebar
            try {
                if (Schema::hasTable('categories')) {
                    $categories = \App\Models\Category::withCount(['blogs' => function($query) {
                        $query->where('is_published', true);
                    }])
                    ->orderBy('name')
                    ->get();
                } else {
                    $categories = collect();
                }
            } catch (\Exception $e) {
                $categories = collect();
            }

            $categoriesHtml = '';
            // Add "All News" link
            $allBlogsCount = Blog::where('is_published', true)->count();
            $categoriesHtml .= '
              <a href="' . url('/news') . '" class="it-sv-details-sidebar-category mb-10" style="display: block; text-decoration: none; color: inherit;">
                <span>All News <span style="color: #999; font-weight: normal;">(' . $allBlogsCount . ')</span></span>
              </a>';
            
            if ($categories->count() > 0) {
                foreach ($categories as $category) {
                    $categoryUrl = url('/news/category/' . $category->slug);
                    $isActive = false; // Will be set based on current page context
                    $activeClass = $isActive ? 'active' : '';
                    $categoriesHtml .= '
                      <a href="' . e($categoryUrl) . '" class="it-sv-details-sidebar-category mb-10 ' . $activeClass . '" style="display: block; text-decoration: none; color: inherit;">
                        <span>' . e($category->name) . ' <span style="color: #999; font-weight: normal;">(' . $category->blogs_count . ')</span></span>
                      </a>';
                }
            } else {
                $categoriesHtml .= '<div class="it-sv-details-sidebar-category mb-10">No categories available</div>';
            }

            // Replace categories content between markers
            $content = preg_replace(
                '/<!-- CATEGORIES_START -->(.*?)<!-- CATEGORIES_END -->/s',
                '<!-- CATEGORIES_START -->' . $categoriesHtml . '<!-- CATEGORIES_END -->',
                $content
            );
        }
        
        // Inject dynamic webinars into the webinars page
        if ($htmlFile === 'webinars.html') {
            $allWebinars = Webinar::where('is_published', true)
                ->orderBy('event_date', 'asc')
                ->get();

            $webinarsHtml = '';

            foreach ($allWebinars as $webinar) {
                $imageUrl = $webinar->image_url ?? '/quantlight/assets/img/event/event-1-1.jpg';
                $webinarUrl = url('/webinars/' . $webinar->slug);
                $day = $webinar->event_date?->format('d') ?? '';
                $month = $webinar->event_date?->format('M') ?? ''; // Use short month name (Jan, Feb, etc.)
                $excerpt = Str::limit(strip_tags($webinar->excerpt ?? $webinar->content), 100);

                $webinarsHtml .= '
            <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
              <div class="it-event-2-item-box" style="overflow: hidden;">
                <div class="it-event-2-item">
                  <div class="it-event-2-thumb fix" style="overflow: hidden; position: relative;">
                    <a href="' . e($webinarUrl) . '" style="display: block; height: 100%;">
                      <img src="' . e($imageUrl) . '" alt="' . e($webinar->title) . '" style="width: 100%; height: 300px; object-fit: cover; display: block;" />
                    </a>
                    <div class="it-event-2-date" style="overflow: hidden;">
                      <span><i>' . e($day) . '</i> <br />' . e($month) . '</span>
                    </div>
                  </div>
                  <div class="it-event-2-content" style="overflow: hidden; word-wrap: break-word;">
                    <h4 class="it-event-2-title" style="word-wrap: break-word; overflow-wrap: break-word;">
                      <a href="' . e($webinarUrl) . '">' . e($webinar->title) . '</a>
                    </h4>
                    <div class="it-event-2-text">
                      <p class="mb-0 pb-10" style="word-wrap: break-word; overflow-wrap: break-word;">' . e($excerpt) . '</p>
                    </div>
                    <div class="it-event-2-meta" style="word-wrap: break-word; overflow-wrap: break-word;">
                      ' . ($webinar->event_time ? '<span><i class="fa-light fa-clock"></i> Time: ' . e($webinar->event_time) . '</span>' : '') . '
                      ' . ($webinar->location ? '<span><i class="fa-light fa-location-dot"></i> ' . e($webinar->location) . '</span>' : '') . '
                    </div>
                  </div>
                </div>
              </div>
            </div>';
            }

            // Replace content between markers
            $content = preg_replace(
                '/<!-- WEBINARS_START -->(.*?)<!-- WEBINARS_END -->/s',
                '<!-- WEBINARS_START -->' . $webinarsHtml . '<!-- WEBINARS_END -->',
                $content
            );
        }
        
        return Response::make($content)->header('Content-Type', 'text/html');
    }
}

// Serve static HTML files from quantlight folder
Route::get('/', function () {
    try {
        return serveQuantLightHtml('index.html');
    } catch (\Exception $e) {
        \Log::error("Error serving index.html: " . $e->getMessage());
        abort(500, $e->getMessage());
    }
});

Route::get('/about', function () {
    try {
        return serveQuantLightHtml('about.html');
    } catch (\Exception $e) {
        \Log::error("Error serving about.html: " . $e->getMessage());
        abort(500, $e->getMessage());
    }
});

Route::get('/contact', function () {
    try {
        $filePath = public_path('quantlight/contact.html');
        
        if (!file_exists($filePath)) {
            abort(404, "Contact page not found");
        }
        
        $content = file_get_contents($filePath);
        
        // Fix relative asset paths to use /quantlight/ prefix
        $content = str_replace('href="assets/', 'href="/quantlight/assets/', $content);
        $content = str_replace("href='assets/", "href='/quantlight/assets/", $content);
        $content = str_replace('src="assets/', 'src="/quantlight/assets/', $content);
        $content = str_replace("src='assets/", "src='/quantlight/assets/", $content);
        $content = str_replace('data-background="assets/', 'data-background="/quantlight/assets/', $content);
        
        // Fix form action from mail.php to /contact and add CSRF token
        $csrfToken = csrf_token();
        $content = str_replace('action="mail.php"', 'action="/contact"', $content);
        $content = str_replace('<form id="contact-form" action="/contact" method="post">', 
            '<form id="contact-form" action="/contact" method="post"><input type="hidden" name="_token" value="' . $csrfToken . '">', $content);
        
        // Remove ajax-form.js to prevent double submission
        $content = str_replace('<script src="assets/js/ajax-form.js"></script>', '', $content);
        $content = str_replace('<script src="/quantlight/assets/js/ajax-form.js"></script>', '', $content);
        
        // Add AJAX form submission script
        $formScript = '
<style>
#contact-result-box {
    padding: 15px !important;
    border-radius: 8px !important;
    margin-top: 20px !important;
    text-align: center !important;
    font-size: 16px !important;
}
#contact-result-box.success {
    background: #d4edda !important;
    color: #155724 !important;
}
#contact-result-box.error {
    background: #f8d7da !important;
    color: #721c24 !important;
}
</style>
<script>
$(function() {
    var form = $("#contact-form");
    var resultBox = $("<div id=\"contact-result-box\"></div>").hide();
    form.after(resultBox);
    
    var isSubmitting = false;
    
    form.on("submit", function(e) {
        e.preventDefault();
        
        if (isSubmitting) return false;
        isSubmitting = true;
        
        var submitBtn = form.find("button[type=submit]");
        var originalText = submitBtn.html();
        
        submitBtn.prop("disabled", true).html("Sending...");
        resultBox.hide();
        
        $.ajax({
            type: "POST",
            url: "/contact",
            data: form.serialize(),
            dataType: "json",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json"
            },
            success: function(data) {
                if (data.success) {
                    resultBox.removeClass("error").addClass("success");
                    resultBox.html("<strong>Success!</strong> " + data.message).show();
                    form[0].reset();
                } else {
                    resultBox.removeClass("success").addClass("error");
                    resultBox.html("<strong>Error!</strong> " + (data.message || "Please try again.")).show();
                }
            },
            error: function() {
                resultBox.removeClass("success").addClass("error");
                resultBox.html("<strong>Error!</strong> Something went wrong. Please try again.").show();
            },
            complete: function() {
                submitBtn.prop("disabled", false).html(originalText);
                isSubmitting = false;
            }
        });
        
        return false;
    });
});
</script>';
        
        // Insert script before closing body tag
        $content = str_replace('</body>', $formScript . '</body>', $content);
        
        return \Illuminate\Support\Facades\Response::make($content)->header('Content-Type', 'text/html');
    } catch (\Exception $e) {
        \Log::error("Error serving contact.html: " . $e->getMessage());
        abort(500, $e->getMessage());
    }
});

// Existing Laravel routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// News routes (replacing blogs routes)
Route::get('/news', function () {
    try {
        return serveQuantLightHtml('news.html');
    } catch (\Exception $e) {
        \Log::error("Error serving news.html: " . $e->getMessage());
        abort(500, $e->getMessage());
    }
});

Route::get('/news/category/{slug}', [BlogController::class, 'category'])->name('news.category');
Route::get('/news/{slug}', [BlogController::class, 'show'])->name('news.show');

// Webinars routes
Route::get('/webinars', function () {
    try {
        return serveQuantLightHtml('webinars.html');
    } catch (\Exception $e) {
        \Log::error("Error serving webinars.html: " . $e->getMessage());
        abort(500, $e->getMessage());
    }
});

Route::get('/webinars/{slug}', [WebinarController::class, 'show'])->name('webinars.show');
Route::post('/webinars/{slug}/register', [\App\Http\Controllers\WebinarRegistrationController::class, 'store'])->name('webinar.registration.store');

// Contact form submission
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// Researches/Capabilities routes
Route::get('/researches-capabilities', function () {
    $researches = Research::where('is_published', true)->latest()->get();
    return view('researches.index', compact('researches'));
});

// Citations/Publications route with dynamic content
Route::get('/citations', function () {
    try {
        $filePath = public_path('quantlight/citations.html');
        
        if (!file_exists($filePath)) {
            abort(404, "Citations page not found");
        }
        
        $content = file_get_contents($filePath);
        
        // Fix relative asset paths to use /quantlight/ prefix
        $content = str_replace('href="assets/', 'href="/quantlight/assets/', $content);
        $content = str_replace("href='assets/", "href='/quantlight/assets/", $content);
        $content = str_replace('src="assets/', 'src="/quantlight/assets/', $content);
        $content = str_replace("src='assets/", "src='/quantlight/assets/", $content);
        $content = str_replace('data-background="assets/', 'data-background="/quantlight/assets/', $content);
        
        // Get published citations ordered by date (newest first)
        $citations = Citation::where('is_published', true)
            ->orderBy('published_date', 'desc')
            ->get();
        
        // Build dynamic citations HTML
        $citationsHtml = '';
        foreach ($citations as $citation) {
            $formattedDate = $citation->published_date?->format('d-m-Y') ?? '';
            $citationsHtml .= '
  <!-- Citation -->
  <div class="citation-strip">
    <h4>' . e($citation->title) . '</h4>
    <p>' . e($citation->description) . '</p>
    <span class="citation-year">' . e($formattedDate) . '</span>
    <a href="' . e($citation->link) . '" target="_blank" class="citation-link">Read More</a>
  </div>
';
        }
        
        // Replace the static citations with dynamic ones
        // Look for the citation-strip-wrap div and replace its contents
        $pattern = '/(<div class="fade-top citation-strip-wrap">)(.*?)(<\/div>\s*<!-- Scholar Button -->)/s';
        $replacement = '$1' . $citationsHtml . '
</div>
          <!-- Scholar Button -->';
        
        $content = preg_replace($pattern, $replacement, $content);
        
        return Response::make($content)->header('Content-Type', 'text/html');
    } catch (\Exception $e) {
        \Log::error("Error serving citations: " . $e->getMessage());
        abort(500, $e->getMessage());
    }
});

// Serve uploaded blog content images
Route::get('/images/blogs/content/{filename}', function ($filename) {
    $path = public_path('images/blogs/content/' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    $file = file_get_contents($path);
    $type = mime_content_type($path);
    
    return response($file, 200)->header('Content-Type', $type);
})->where('filename', '[A-Za-z0-9_\-\.]+');

// Keep old /blogs routes for backward compatibility (redirect to /news)
Route::get('/blogs', function () {
    return redirect('/news', 301);
});
Route::get('/blogs/{slug}', function ($slug) {
    return redirect('/news/' . $slug, 301);
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('blogs', AdminBlogController::class);
    Route::resource('webinars', AdminWebinarController::class);
    Route::resource('citations', \App\Http\Controllers\Admin\CitationController::class);
    Route::resource('researches', \App\Http\Controllers\Admin\ResearchController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::post('ckeditor/upload', [\App\Http\Controllers\Admin\CkeditorImageUploadController::class, 'upload'])->name('ckeditor.upload');
    Route::get('webinar-registrations', [\App\Http\Controllers\Admin\WebinarRegistrationController::class, 'index'])->name('webinar-registrations.index');
    Route::get('webinar-registrations/{webinar}', [\App\Http\Controllers\Admin\WebinarRegistrationController::class, 'show'])->name('webinar-registrations.show');
    Route::delete('webinar-registrations/{id}', [\App\Http\Controllers\Admin\WebinarRegistrationController::class, 'destroy'])->name('webinar-registrations.destroy');
    Route::get('contact-submissions', [\App\Http\Controllers\Admin\ContactSubmissionController::class, 'index'])->name('contact-submissions.index');
    Route::get('contact-submissions/{id}', [\App\Http\Controllers\Admin\ContactSubmissionController::class, 'show'])->name('contact-submissions.show');
    Route::delete('contact-submissions/{id}', [\App\Http\Controllers\Admin\ContactSubmissionController::class, 'destroy'])->name('contact-submissions.destroy');
});

// Catch-all route for other HTML pages in quantlight (must be last)
// This also handles dynamic research detail pages at root level (e.g., /surface-light-processing)
Route::get('/{page}', function ($page) {
    // Skip if the page contains a slash (it's an asset path) or has a file extension other than .html
    if (strpos($page, '/') !== false) {
        abort(404);
    }
    
    // If it has a dot and doesn't end with .html, it's likely an asset file
    if (strpos($page, '.') !== false && substr($page, -5) !== '.html') {
        abort(404);
    }
    
    // Remove .html extension if present for slug lookup
    $slug = $page;
    if (substr($slug, -5) === '.html') {
        $slug = substr($slug, 0, -5);
    }
    
    // First, check if this is a dynamic research page
    $research = Research::where('slug', $slug)->where('is_published', true)->first();
    if ($research) {
        return view('researches.show', compact('research'));
    }
    
    // Otherwise, try to serve the static HTML file
    $htmlFile = $page;
    if (substr($htmlFile, -5) !== '.html') {
        $htmlFile = $page . '.html';
    }
    
    try {
        return serveQuantLightHtml($htmlFile);
    } catch (\Exception $e) {
        \Log::error("Error serving {$htmlFile}: " . $e->getMessage());
        abort(404);
    }
})->where('page', '^(?!dashboard|blogs|news|webinars|citations|researches-capabilities|admin|login|register|forgot-password|reset-password|verify-email|confirm-password|profile|api|quantlight|assets|build|storage|favicon|robots|images)[^\/]*$');

require __DIR__.'/auth.php';
