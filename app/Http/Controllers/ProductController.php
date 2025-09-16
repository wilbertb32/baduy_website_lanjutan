<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:25600'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id()
        ]);

        // Upload image ke BLOB
        if ($request->hasFile('image')) {
            ImageHelper::uploadImage($request->file('image'), $product, 'main');
        }

        return redirect()->back()->with('success', 'Product berhasil ditambahkan');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:25600'
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'updated_by' => Auth::id()
        ]);

        // Update image jika ada
        if ($request->hasFile('image')) {
            ImageHelper::replaceImage($request->file('image'), $product, 'main');
        }

        return redirect()->back()->with('success', 'Product berhasil diupdate');
    }

    public function destroy(Product $product)
    {
        // Hapus semua images terkait
        $product->images()->delete();
        
        // Hapus product
        $product->delete();

        return redirect()->back()->with('success', 'Product berhasil dihapus');
    }
}