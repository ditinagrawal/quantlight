<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CkeditorImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('upload')) {
            $image = $request->file('upload');
            $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            $imageDir = public_path('images/blogs/content');
            
            // Create directory if it doesn't exist
            if (!File::exists($imageDir)) {
                File::makeDirectory($imageDir, 0755, true);
            }
            
            $image->move($imageDir, $imageName);
            
            // Generate absolute URL - use request to get current host
            $url = $request->getSchemeAndHttpHost() . '/images/blogs/content/' . $imageName;
            
            // CKEditor expects this response format
            return response()->json([
                'uploaded' => true,
                'url' => $url
            ]);
        }
        
        return response()->json([
            'uploaded' => false,
            'error' => ['message' => 'Image upload failed']
        ], 400);
    }
}
