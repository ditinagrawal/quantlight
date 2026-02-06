<?php

namespace App\Http\Controllers;

use App\Models\LabUpdate;
use Illuminate\Http\Request;

class LabUpdateController extends Controller
{
    /**
     * Display a listing of lab updates (3-col grid).
     */
    public function index()
    {
        $updates = LabUpdate::published()
            ->orderBy('published_date', 'desc')
            ->get();

        return view('updates.index', compact('updates'));
    }

    /**
     * Display the specified lab update by slug.
     */
    public function show(string $slug)
    {
        $update = LabUpdate::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('updates.show', compact('update'));
    }
}
