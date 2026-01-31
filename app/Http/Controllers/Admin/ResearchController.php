<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $researches = Research::latest()->paginate(10);
        return view('admin.researches.index', compact('researches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.researches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:researches,slug',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $imageDir = public_path('images/researches');
            
            // Create directory if it doesn't exist
            if (!File::exists($imageDir)) {
                File::makeDirectory($imageDir, 0755, true);
            }
            
            $image->move($imageDir, $imageName);
            $imagePath = 'images/researches/' . $imageName;
        }

        Research::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('slug')),
            'excerpt' => $request->input('excerpt'),
            'content' => $request->input('content'),
            'is_published' => $request->has('is_published'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.researches.index')->with('success', 'Research created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $research = Research::findOrFail($id);
        return view('admin.researches.show', compact('research'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $research = Research::findOrFail($id);
        return view('admin.researches.edit', compact('research'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $research = Research::findOrFail($id);
        
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:researches,slug,' . $research->id,
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $imagePath = $research->image;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($research->image && File::exists(public_path($research->image))) {
                File::delete(public_path($research->image));
            }
            
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $imageDir = public_path('images/researches');
            
            // Create directory if it doesn't exist
            if (!File::exists($imageDir)) {
                File::makeDirectory($imageDir, 0755, true);
            }
            
            $image->move($imageDir, $imageName);
            $imagePath = 'images/researches/' . $imageName;
        }
        
        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            if ($research->image && File::exists(public_path($research->image))) {
                File::delete(public_path($research->image));
            }
            $imagePath = null;
        }
        
        $research->update([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('slug')),
            'excerpt' => $request->input('excerpt'),
            'content' => $request->input('content'),
            'is_published' => $request->has('is_published'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.researches.index')->with('success', 'Research updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $research = Research::findOrFail($id);
        
        // Delete image if exists
        if ($research->image && File::exists(public_path($research->image))) {
            File::delete(public_path($research->image));
        }
        
        $research->delete();

        return redirect()->route('admin.researches.index')->with('success', 'Research deleted successfully!');
    }
}
