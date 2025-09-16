<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function show($id)
    {
        $image = Image::findOrFail($id);
        
        // Decode base64 data
        $imageData = base64_decode($image->image_data);
        
        return response($imageData)
            ->header('Content-Type', $image->mime_type)
            ->header('Content-Length', strlen($imageData))
            ->header('Cache-Control', 'public, max-age=31536000');
    }
}
