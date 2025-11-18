<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik singkat
        $totalProducts      = Product::count();
        $activeProducts     = Product::where('is_active', true)->count();
        $lowStockProducts   = Product::where('stock', '<=', 3)->orderBy('stock')->get();
        $lowStockCount      = $lowStockProducts->count();
        $recentProducts     = Product::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'user',
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'lowStockCount',
            'recentProducts'
        ));
    }
}
