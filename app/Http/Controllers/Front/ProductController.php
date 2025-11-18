<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->latest()->get();

        return view('front.products.index', compact('products'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
                          ->where('is_active', true)
                          ->firstOrFail();

        return view('front.products.show', compact('product'));
    }
}

