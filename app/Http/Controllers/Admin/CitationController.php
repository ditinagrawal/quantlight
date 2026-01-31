<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Citation;
use Illuminate\Http\Request;

class CitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citations = Citation::latest('published_date')->paginate(10);
        return view('admin.citations.index', compact('citations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.citations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:500',
            'description' => 'required',
            'published_date' => 'required|date',
            'link' => 'required|url|max:1000',
        ]);

        Citation::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'published_date' => $request->input('published_date'),
            'link' => $request->input('link'),
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('admin.citations.index')->with('success', 'Citation created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $citation = Citation::findOrFail($id);
        return view('admin.citations.show', compact('citation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $citation = Citation::findOrFail($id);
        return view('admin.citations.edit', compact('citation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $citation = Citation::findOrFail($id);
        
        $request->validate([
            'title' => 'required|max:500',
            'description' => 'required',
            'published_date' => 'required|date',
            'link' => 'required|url|max:1000',
        ]);

        $citation->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'published_date' => $request->input('published_date'),
            'link' => $request->input('link'),
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('admin.citations.index')->with('success', 'Citation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $citation = Citation::findOrFail($id);
        $citation->delete();

        return redirect()->route('admin.citations.index')->with('success', 'Citation deleted successfully!');
    }
}
