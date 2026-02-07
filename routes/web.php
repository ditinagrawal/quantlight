<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use App\Models\Citation;

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

        // Add Updates link to header nav when served as static fragment (footer already has Updates in footer.html)
        if ($htmlFile === 'header.html') {
            $content = str_replace('<li><a href="/contact">Contact</a></li>', '<li><a href="/updates">Updates</a></li><li><a href="/contact">Contact</a></li>', $content);
        }

        return Response::make($content)->header('Content-Type', 'text/html');
    }
}

// Returns processed HTML content string (for injection before returning response)
if (!function_exists('getQuantLightHtmlContent')) {
    function getQuantLightHtmlContent($htmlFile) {
        $filePath = public_path('quantlight/' . $htmlFile);
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: {$htmlFile}");
        }
        $content = file_get_contents($filePath);
        if ($content === false) {
            throw new \Exception("Could not read file: {$htmlFile}");
        }
        $content = str_replace('href="assets/', 'href="/quantlight/assets/', $content);
        $content = str_replace("href='assets/", "href='/quantlight/assets/", $content);
        $content = str_replace('src="assets/', 'src="/quantlight/assets/', $content);
        $content = str_replace("src='assets/", "src='/quantlight/assets/", $content);
        $content = str_replace('data-background="assets/', 'data-background="/quantlight/assets/', $content);
        $content = str_replace("data-background='assets/", "data-background='/quantlight/assets/", $content);
        $content = str_replace('data-bg="assets/', 'data-bg="/quantlight/assets/', $content);
        $content = preg_replace('/(data-[^=]+)=["\']assets\//', '$1="/quantlight/assets/', $content);
        $content = preg_replace('/url\(["\']?assets\//', 'url("/quantlight/assets/', $content);
        $csrfToken = csrf_token();
        $csrfMetaTag = '<meta name="csrf-token" content="' . $csrfToken . '">';
        if (strpos($content, 'name="csrf-token"') === false) {
            if (preg_match('/<head[^>]*>/i', $content)) {
                $content = preg_replace('/(<head[^>]*>)/i', '$1' . "\n    " . $csrfMetaTag, $content);
            } elseif (preg_match('/<\/head>/i', $content)) {
                $content = preg_replace('/(<\/head>)/i', '    ' . $csrfMetaTag . "\n$1", $content);
            }
        }
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
        $footerServiceLinks = [
            'href="services-1.html"' => 'href="/about"',
            "href='services-1.html'" => "href='/about'",
            'href="services-2.html"' => 'href="/mbbs-india"',
            "href='services-2.html'" => "href='/mbbs-india'",
            'href="services-3.html"' => 'href="/mba-india"',
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
        foreach ($footerServiceLinks as $oldLink => $newLink) {
            $content = str_replace($oldLink, $newLink, $content);
        }
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
        $content = preg_replace('/href=["\']([^"\']+)\.html([^"\']*)["\']/', 'href="$1$2"', $content);
        return $content;
    }
}

// Serve static HTML files from quantlight folder
Route::get('/', function () {
    try {
        $content = getQuantLightHtmlContent('index.html');
        // Ensure updates-overrides.css is loaded (equal image sizes + flex column for lab updates)
        if (strpos($content, 'updates-overrides.css') === false) {
            $content = str_replace('</head>', '    <link rel="stylesheet" href="/quantlight/assets/css/updates-overrides.css" />' . "\n  </head>", $content);
        }
        $labUpdates = \App\Models\LabUpdate::published()
            ->orderBy('published_date', 'desc')
            ->get();

        if ($labUpdates->isNotEmpty()) {
            $slidesHtml = '';
            foreach ($labUpdates as $item) {
                $imgSrc = $item->image
                    ? (str_contains($item->image, 'quantlight/') ? '/' . $item->image : asset('public/' . $item->image))
                    : '';
                $linkUrl = $item->slug ? url('/updates/' . $item->slug) : ($item->link ? e($item->link) : '/updates');
                $dateStr = $item->published_date?->format('m/d/Y') ?? '';
                $categoriesHtml = '';
                foreach ($item->categories_array as $cat) {
                    $categoriesHtml .= '<span>' . e($cat) . '</span>';
                }
                $slidesHtml .= '
                  <div class="swiper-slide">
                    <div class="blog-section-4__item">
                      <div class="blog-section-4__thumb">
                        <a href="' . $linkUrl . '">
                          <img src="' . ($imgSrc ?: '/quantlight/assets/img/blog1.png') . '" alt="' . e($item->title) . '" class="update-card-img" />
                        </a>
                      </div>
                      <div class="blog-section-4__content">
                        <div class="blog-section-4__cat">' . $categoriesHtml . '</div>
                        <h3 class="blog-section-4__title">
                          <a href="' . $linkUrl . '">' . e($item->title) . '</a>
                        </h3>
                        <div class="blog-section-4__date"><span>' . e($dateStr) . '</span></div>
                        <div class="blog-section-4__btn">
                          <a href="' . $linkUrl . '">READ MORE <i class="fa-light fa-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
';
            }

            // Target only the "Latest discoveries" blog section (blog-section-4), not other swiper-wrappers on the page
            $pattern = '/(<div class="swiper blog-section-4__active">\s*<div class="swiper-wrapper">)(.*?)(<\/div>\s*<\/div>\s*<\/div>\s*<\/section>)/s';
            $content = preg_replace($pattern, '$1' . $slidesHtml . '$3', $content, 1);
        }

        return Response::make($content)->header('Content-Type', 'text/html');
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

// Contact form submission
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// Researches/Capabilities routes (static page)
Route::get('/researches-capabilities', function () {
    return serveQuantLightHtml('researches-capabilities.html');
});

// Header/footer fragments for Blade pages (e.g. /updates) so theme JS can load them
Route::get('/quantlight/fragments/header', function () {
    $path = public_path('quantlight/header.html');
    if (!file_exists($path)) {
        abort(404);
    }
    $content = file_get_contents($path);
    $content = str_replace('href="assets/', 'href="/quantlight/assets/', $content);
    $content = str_replace("href='assets/", "href='/quantlight/assets/", $content);
    $content = str_replace('src="assets/', 'src="/quantlight/assets/', $content);
    $content = str_replace("src='assets/", "src='/quantlight/assets/", $content);
    $content = str_replace('href="index.html"', 'href="/"', $content);
    $content = str_replace('href="about.html"', 'href="/about"', $content);
    $content = str_replace('href="contact.html"', 'href="/contact"', $content);
    $content = str_replace('href="researches-capabilities.html"', 'href="/researches-capabilities"', $content);
    $content = str_replace('href="citations.html"', 'href="/citations"', $content);
    $content = str_replace('href="gallery.html"', 'href="/gallery"', $content);
    $content = str_replace('href="blog.html"', 'href="/updates"', $content);
    $content = str_replace('href="news.html"', 'href="/updates"', $content);
    // Add Updates nav item and fix Contact link
    $content = str_replace('<li><a href="contact.html">Contact</a></li>', '<li><a href="/updates">Updates</a></li><li><a href="/contact">Contact</a></li>', $content);
    $content = str_replace('href="contact.html"', 'href="/contact"', $content);
    $content = preg_replace('/href="([^"]*\.html)"/', 'href="/$1"', $content);
    $content = str_replace('href="/contact.html"', 'href="/contact"', $content);
    $content = str_replace('href="/index.html"', 'href="/"', $content);
    $content = str_replace('href="/about.html"', 'href="/about"', $content);
    $content = str_replace('href="/researches-capabilities.html"', 'href="/researches-capabilities"', $content);
    $content = str_replace('href="/citations.html"', 'href="/citations"', $content);
    $content = str_replace('href="/gallery.html"', 'href="/gallery"', $content);
    return Response::make($content)->header('Content-Type', 'text/html');
});
Route::get('/quantlight/fragments/footer', function () {
    $path = public_path('quantlight/footer.html');
    if (!file_exists($path)) {
        abort(404);
    }
    $content = file_get_contents($path);
    $content = str_replace('href="assets/', 'href="/quantlight/assets/', $content);
    $content = str_replace("href='assets/", "href='/quantlight/assets/", $content);
    $content = str_replace('src="assets/', 'src="/quantlight/assets/', $content);
    $content = str_replace("src='assets/", "src='/quantlight/assets/", $content);
    $content = str_replace('href="index.html"', 'href="/"', $content);
    $content = str_replace('href="about.html"', 'href="/about"', $content);
    $content = str_replace('href="contact.html"', 'href="/contact"', $content);
    $content = str_replace('href="researches-capabilities.html"', 'href="/researches-capabilities"', $content);
    $content = str_replace('href="citations.html"', 'href="/citations"', $content);
    $content = str_replace('href="gallery.html"', 'href="/gallery"', $content);
    $content = str_replace('href="index.html#capabilities"', 'href="/#capabilities"', $content);
    $content = str_replace('<li><a href="contact.html">Contact</a></li>', '<li><a href="/contact">Contact</a></li>', $content);
    $content = str_replace('href="index.html"', 'href="/"', $content);
    $content = str_replace('href="about.html"', 'href="/about"', $content);
    $content = str_replace('href="contact.html"', 'href="/contact"', $content);
    $content = str_replace('href="researches-capabilities.html"', 'href="/researches-capabilities"', $content);
    $content = str_replace('href="citations.html"', 'href="/citations"', $content);
    $content = str_replace('href="gallery.html"', 'href="/gallery"', $content);
    return Response::make($content)->header('Content-Type', 'text/html');
});

// Updates (lab updates) - list and single
Route::get('/updates', [\App\Http\Controllers\LabUpdateController::class, 'index'])->name('updates.index');
Route::get('/updates/{slug}', [\App\Http\Controllers\LabUpdateController::class, 'show'])->name('updates.show');

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

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('citations', \App\Http\Controllers\Admin\CitationController::class);
    Route::resource('lab-updates', \App\Http\Controllers\Admin\LabUpdateController::class);
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);
    Route::resource('webinars', \App\Http\Controllers\Admin\WebinarController::class);
    Route::post('ckeditor/upload', [\App\Http\Controllers\Admin\CkeditorImageUploadController::class, 'upload'])->name('ckeditor.upload');
    Route::get('contact-submissions', [\App\Http\Controllers\Admin\ContactSubmissionController::class, 'index'])->name('contact-submissions.index');
    Route::get('contact-submissions/{id}', [\App\Http\Controllers\Admin\ContactSubmissionController::class, 'show'])->name('contact-submissions.show');
    Route::delete('contact-submissions/{id}', [\App\Http\Controllers\Admin\ContactSubmissionController::class, 'destroy'])->name('contact-submissions.destroy');
});

// Catch-all route for other HTML pages in quantlight (must be last)
Route::get('/{page}', function ($page) {
    // Skip if the page contains a slash (it's an asset path) or has a file extension other than .html
    if (strpos($page, '/') !== false) {
        abort(404);
    }
    
    // If it has a dot and doesn't end with .html, it's likely an asset file
    if (strpos($page, '.') !== false && substr($page, -5) !== '.html') {
        abort(404);
    }
    
    // Serve the static HTML file
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
})->where('page', '^(?!dashboard|citations|researches-capabilities|updates|admin|login|register|forgot-password|reset-password|verify-email|confirm-password|profile|api|quantlight|assets|build|storage|favicon|robots|images)[^\/]*$');

require __DIR__.'/auth.php';
