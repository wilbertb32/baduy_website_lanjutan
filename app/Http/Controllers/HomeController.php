<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $carousels = Carousel::orderBy('order')->get();
        $products = Product::latest()->take(8)->get(); 
        return view('homepage', compact('carousels', 'products'));
    }
}