<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use App\Models\WebinarRegistration;
use Illuminate\Http\Request;

class WebinarRegistrationController extends Controller
{
    /**
     * Display a listing of all registrations
     */
    public function index()
    {
        $registrations = WebinarRegistration::with('webinar')
            ->latest()
            ->paginate(20);
        
        return view('admin.webinar-registrations.index', compact('registrations'));
    }

    /**
     * Display registrations for a specific webinar
     */
    public function show($webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);
        $registrations = WebinarRegistration::where('webinar_id', $webinarId)
            ->latest()
            ->paginate(20);
        
        return view('admin.webinar-registrations.show', compact('webinar', 'registrations'));
    }

    /**
     * Remove the specified registration
     */
    public function destroy($id)
    {
        $registration = WebinarRegistration::findOrFail($id);
        $registration->delete();

        return redirect()->back()->with('success', 'Registration deleted successfully!');
    }
}
