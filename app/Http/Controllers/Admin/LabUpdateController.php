<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LabUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labUpdates = LabUpdate::orderBy('sort_order')->orderBy('published_date', 'desc')->paginate(10);
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
            'link' => 'nullable|url|max:1000',
            'categories' => 'nullable|string|max:255',
            'published_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'));
        }

        LabUpdate::create([
            'title' => $request->input('title'),
            'excerpt' => $request->input('excerpt'),
            'link' => $request->input('link'),
            'categories' => $request->input('categories'),
            'published_date' => $request->input('published_date'),
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) $request->input('sort_order', 0),
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
            'link' => 'nullable|url|max:1000',
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

        $labUpdate->update([
            'title' => $request->input('title'),
            'excerpt' => $request->input('excerpt'),
            'link' => $request->input('link'),
            'categories' => $request->input('categories'),
            'published_date' => $request->input('published_date'),
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) $request->input('sort_order', 0),
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
