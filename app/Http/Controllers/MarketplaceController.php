<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('marketplace', compact('products'));
    }
}