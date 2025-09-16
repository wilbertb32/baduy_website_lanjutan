<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class CarouselController extends Controller
{
    public function index()
    {
        $carousels = Carousel::orderBy('order')->get();
        return view('admin', compact('carousels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:25600'
        ]);

        $carousel = Carousel::create([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id()
        ]);

        // Upload image ke BLOB
        if ($request->hasFile('image')) {
            ImageHelper::uploadImage($request->file('image'), $carousel, 'main');
        }

        return redirect()->back()->with('success', 'Carousel berhasil ditambahkan');
    }

    public function update(Request $request, Carousel $carousel)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:25600'
        ]);

        $carousel->update([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order,
            'updated_by' => Auth::id()
        ]);

        // Update image jika ada
        if ($request->hasFile('image')) {
            ImageHelper::replaceImage($request->file('image'), $carousel, 'main');
        }

        return redirect()->back()->with('success', 'Carousel berhasil diupdate');
    }

    public function destroy(Carousel $carousel)
    {
        // Hapus semua images terkait
        $carousel->images()->delete();
        
        // Hapus carousel
        $carousel->delete();

        return redirect()->back()->with('success', 'Carousel berhasil dihapus');
    }
}