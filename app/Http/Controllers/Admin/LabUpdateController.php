<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LabUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labUpdates = LabUpdate::orderBy('published_date', 'desc')->paginate(10);
        return view('admin.lab-updates.index', compact('labUpdates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lab-updates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:500',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'categories' => 'nullable|string|max:255',
            'published_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'));
        }

        $slug = $this->uniqueSlug($request->input('title'));
        $readMoreUrl = url('/updates/' . $slug);

        LabUpdate::create([
            'title' => $request->input('title'),
            'slug' => $slug,
            'excerpt' => $request->input('excerpt'),
            'content' => $request->input('content'),
            'link' => $readMoreUrl,
            'categories' => $request->input('categories'),
            'published_date' => $request->input('published_date'),
            'is_published' => $request->boolean('is_published'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.lab-updates.index')->with('success', 'Lab update created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $labUpdate = LabUpdate::findOrFail($id);
        return view('admin.lab-updates.edit', compact('labUpdate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $labUpdate = LabUpdate::findOrFail($id);

        $request->validate([
            'title' => 'required|max:500',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'categories' => 'nullable|string|max:255',
            'published_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = $labUpdate->image;

        if ($request->hasFile('image')) {
            if ($labUpdate->image && !str_contains($labUpdate->image, 'quantlight/') && File::exists(public_path($labUpdate->image))) {
                File::delete(public_path($labUpdate->image));
            }
            $imagePath = $this->uploadImage($request->file('image'));
        }

        if ($request->boolean('remove_image')) {
            if ($labUpdate->image && !str_contains($labUpdate->image, 'quantlight/') && File::exists(public_path($labUpdate->image))) {
                File::delete(public_path($labUpdate->image));
            }
            $imagePath = null;
        }

        $slug = $this->uniqueSlug($request->input('title'), $labUpdate->id);
        $readMoreUrl = url('/updates/' . $slug);

        $labUpdate->update([
            'title' => $request->input('title'),
            'slug' => $slug,
            'excerpt' => $request->input('excerpt'),
            'content' => $request->input('content'),
            'link' => $readMoreUrl,
            'categories' => $request->input('categories'),
            'published_date' => $request->input('published_date'),
            'is_published' => $request->boolean('is_published'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.lab-updates.index')->with('success', 'Lab update updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $labUpdate = LabUpdate::findOrFail($id);
        if ($labUpdate->image && !str_contains($labUpdate->image, 'quantlight/') && File::exists(public_path($labUpdate->image))) {
            File::delete(public_path($labUpdate->image));
        }
        $labUpdate->delete();

        return redirect()->route('admin.lab-updates.index')->with('success', 'Lab update deleted successfully!');
    }

    private function uniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $query = LabUpdate::where('slug', $slug);
        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }
        if ($query->exists()) {
            $slug .= '-' . (LabUpdate::max('id') + 1);
        }
        return $slug;
    }

    private function uploadImage($file): string
    {
        $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
        $imageDir = public_path('images/lab-updates');
        if (!File::exists($imageDir)) {
            File::makeDirectory($imageDir, 0755, true);
        }
        $file->move($imageDir, $imageName);
        return 'images/lab-updates/' . $imageName;
    }
}
