<?php

namespace App\Http\Controllers;

use App\Models\Research;
use Illuminate\Http\Request;

class ResearchController extends Controller
{
    /**
     * Display the specified research.
     */
    public function show($slug)
    {
        $research = Research::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        
        return view('researches.show', compact('research'));
    }
}
