<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // Method to show upload form and display all images
    public function index()
    {
        $images = Image::all();
        return view('upload', compact('images'));
    }
    
    public function upload(Request $request)
    {
        // Custom validation messages
        $messages = [
            'image.required' => 'Please select an image to upload.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Only jpeg, png, jpg, and gif formats are allowed.',
            'image.max' => 'The image size must not exceed 2MB.',
        ];
    
        // Validate the image file
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $messages);
    
        // Store the image in the public/images directory
        $path = $request->file('image')->store('images', 'public');
    
        // Save the image filepath in the database
        Image::create(['filepath' => $path]);
    
        return redirect('/')->with('success', 'Image uploaded successfully');
    }
      
    
}
