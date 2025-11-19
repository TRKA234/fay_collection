<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::where('is_active', true)->with('category');

        // Filter berdasarkan kategori
        if (request('category')) {
            $query->whereHas('category', function ($q) {
                $q->where('slug', request('category'));
            });
        }

        $products = $query->latest()->get();
        $categories = Category::has('products')->orderBy('name')->get();
        $selectedCategory = request('category') ? Category::where('slug', request('category'))->first() : null;

        return view('front.products.index', compact('products', 'categories', 'selectedCategory'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        return view('front.products.show', compact('product'));
    }
}
