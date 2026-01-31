<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use Spatie\SchemaOrg\Schema;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')
            ->where('is_published', true)
            ->latest()
            ->paginate(10);

        return view('blogs.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::with('category')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Generate Schema.org structured data for BlogPosting
        $schema = Schema::blogPosting()
            ->headline($blog->title)
            ->description(strip_tags($blog->excerpt ?? Str::limit($blog->content, 200)))
            ->datePublished($blog->created_at ? $blog->created_at->toIso8601String() : now()->toIso8601String())
            ->dateModified($blog->updated_at ? $blog->updated_at->toIso8601String() : ($blog->created_at ? $blog->created_at->toIso8601String() : now()->toIso8601String()))
            ->author(
                Schema::organization()
                    ->name('SmartPath Education Consulting')
                    ->url(url('/'))
            )
            ->publisher(
                Schema::organization()
                    ->name('SmartPath Education Consulting')
                    ->logo(
                        Schema::imageObject()
                            ->url(url('/smartpath/assets/img/logo/logo.png'))
                    )
            )
            ->mainEntityOfPage(
                Schema::webPage()->url(url("/news/{$blog->slug}"))
            );

        if ($blog->image_url) {
            $schema->image($blog->image_url);
        }

        if ($blog->category) {
            $schema->articleSection($blog->category->name);
        }

        $schemaJson = $schema->toScript();

        return view('blogs.show', compact('blog', 'schemaJson'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $blogs = Blog::with('category')
            ->where('category_id', $category->id)
            ->where('is_published', true)
            ->latest()
            ->get();

        // Get all categories for sidebar
        $categories = Category::withCount(['blogs' => function($query) {
            $query->where('is_published', true);
        }])
        ->orderBy('name')
        ->get();

        return view('blogs.category', compact('category', 'blogs', 'categories'));
    }
}
