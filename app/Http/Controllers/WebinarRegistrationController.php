<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use App\Models\WebinarRegistration;
use Illuminate\Http\Request;

class WebinarRegistrationController extends Controller
{
    /**
     * Store a new webinar registration
     */
    public function store(Request $request, $webinarSlug)
    {
        $webinar = Webinar::where('slug', $webinarSlug)
            ->where('is_published', true)
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'location' => 'required|string|max:255',
        ]);

        WebinarRegistration::create([
            'webinar_id' => $webinar->id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'location' => $request->input('location'),
            'extra_field_1' => 'default_value_1',
            'extra_field_2' => 'default_value_2',
        ]);

        return redirect()->back()->with('success', 'Thank you! Your registration has been submitted successfully.');
    }
}
