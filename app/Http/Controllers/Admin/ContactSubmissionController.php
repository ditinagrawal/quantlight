<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = ContactSubmission::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.contact-submissions.index', compact('submissions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $submission = ContactSubmission::findOrFail($id);
        return view('admin.contact-submissions.show', compact('submission'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $submission = ContactSubmission::findOrFail($id);
        $submission->delete();

        return redirect()->route('admin.contact-submissions.index')
            ->with('success', 'Contact submission deleted successfully.');
    }
}
