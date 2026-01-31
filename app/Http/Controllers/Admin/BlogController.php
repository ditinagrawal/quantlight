<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::with('category')->latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:blogs,slug',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'keywords' => 'nullable|string|max:500',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $imageDir = public_path('images/blogs');
            
            // Create directory if it doesn't exist
            if (!File::exists($imageDir)) {
                File::makeDirectory($imageDir, 0755, true);
            }
            
            $image->move($imageDir, $imageName);
            $imagePath = 'images/blogs/' . $imageName;
        }

        Blog::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('slug')),
            'excerpt' => $request->input('excerpt'),
            'keywords' => $request->input('keywords'),
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id'),
            'is_published' => $request->has('is_published'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = Blog::findOrFail($id);
        
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:blogs,slug,' . $blog->id,
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'keywords' => 'nullable|string|max:500',
        ]);

        $imagePath = $blog->image;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($blog->image && File::exists(public_path($blog->image))) {
                File::delete(public_path($blog->image));
            }
            
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $imageDir = public_path('images/blogs');
            
            // Create directory if it doesn't exist
            if (!File::exists($imageDir)) {
                File::makeDirectory($imageDir, 0755, true);
            }
            
            $image->move($imageDir, $imageName);
            $imagePath = 'images/blogs/' . $imageName;
        }
        
        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            if ($blog->image && File::exists(public_path($blog->image))) {
                File::delete(public_path($blog->image));
            }
            $imagePath = null;
        }
        
        $blog->update([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('slug')),
            'excerpt' => $request->input('excerpt'),
            'keywords' => $request->input('keywords'),
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id'),
            'is_published' => $request->has('is_published'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        
        // Delete image if exists
        if ($blog->image && File::exists(public_path($blog->image))) {
            File::delete(public_path($blog->image));
        }
        
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully!');
    }
}
