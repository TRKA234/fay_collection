<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('products')
            ->latest()
            ->paginate(10);

        // Filter by status if provided
        if (request('status')) {
            $orders = Order::where('status', request('status'))
                ->with('products')
                ->latest()
                ->paginate(10);
        }

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.orders.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_contact' => ['required', 'string', 'max:255'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string'],
        ]);

        // Calculate total amount
        $totalAmount = 0;
        $productsData = [];

        foreach ($validated['products'] as $productData) {
            $product = Product::findOrFail($productData['id']);
            $quantity = $productData['quantity'];
            $price = $product->price;
            $subtotal = $price * $quantity;

            $totalAmount += $subtotal;

            $productsData[$product->id] = [
                'quantity' => $quantity,
                'price' => $price,
            ];
        }

        // Create order
        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'customer_contact' => $validated['customer_contact'],
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        // Attach products
        $order->products()->attach($productsData);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('products');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load('products');
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.orders.edit', compact('order', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_contact' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:pending,paid,shipped,completed,cancelled'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string'],
        ]);

        // Calculate total amount
        $totalAmount = 0;
        $productsData = [];

        foreach ($validated['products'] as $productData) {
            $product = Product::findOrFail($productData['id']);
            $quantity = $productData['quantity'];
            $price = $product->price;
            $subtotal = $price * $quantity;

            $totalAmount += $subtotal;

            $productsData[$product->id] = [
                'quantity' => $quantity,
                'price' => $price,
            ];
        }

        // Update order
        $order->update([
            'customer_name' => $validated['customer_name'],
            'customer_contact' => $validated['customer_contact'],
            'total_amount' => $totalAmount,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Sync products
        $order->products()->sync($productsData);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}
