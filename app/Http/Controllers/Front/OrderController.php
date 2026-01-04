<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = Order::forUser(Auth::id())
            ->with('products')
            ->latest()
            ->paginate(10);

        return view('front.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        // Handle null user_id (order dibuat admin) dan type mismatch dengan casting ke integer
        if (!$order->user_id || (int) $order->user_id !== (int) Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $order->load('products');

        return view('front.orders.show', compact('order'));
    }
}
