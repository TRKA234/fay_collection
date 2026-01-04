<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminOrderNotificationMail;
use App\Mail\OrderStatusChangedMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('products', 'user')
            ->latest()
            ->paginate(10);

        // Filter by status if provided
        if (request('status')) {
            $orders = Order::where('status', request('status'))
                ->with('products', 'user')
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
            'shipping_method' => ['required', 'in:jnt,pickup'],
            'shipping_address' => ['required_if:shipping_method,jnt', 'nullable', 'string'],
            'shipping_cost' => ['required', 'integer', 'min:0'],
            'payment_method' => ['nullable', 'string'],
            'payment_info' => ['nullable', 'string'],
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
            'shipping_address' => $validated['shipping_address'] ?? null,
            'shipping_method' => $validated['shipping_method'],
            'shipping_cost' => $validated['shipping_cost'] ?? 0,
            'payment_method' => $validated['payment_method'] ?? 'transfer',
            'payment_info' => $validated['payment_info'] ?? null,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        // Attach products
        $order->products()->attach($productsData);

        // Load order dengan products untuk email
        $order->load('products', 'user');

        // Kirim email ke customer jika ada user_id
        try {
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(new OrderCreatedMail($order));
            }
        } catch (\Exception $e) {
                Log::error('Failed to send order created email: ' . $e->getMessage());
        }

        // Kirim email ke admin
        try {
            Mail::to(config('mail.from.address'))->send(new AdminOrderNotificationMail($order, 'new_order'));
        } catch (\Exception $e) {
                Log::error('Failed to send admin notification email: ' . $e->getMessage());
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('products', 'user');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load('products', 'user');
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
            'shipping_method' => ['required', 'in:jnt,pickup'],
            'shipping_address' => ['required_if:shipping_method,jnt', 'nullable', 'string'],
            'shipping_cost' => ['required', 'integer', 'min:0'],
            'payment_method' => ['nullable', 'string'],
            'payment_info' => ['nullable', 'string'],
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

        $oldStatus = $order->status;
        
        // Update order
        $order->update([
            'customer_name' => $validated['customer_name'],
            'customer_contact' => $validated['customer_contact'],
            'shipping_address' => $validated['shipping_address'] ?? null,
            'shipping_method' => $validated['shipping_method'],
            'shipping_cost' => $validated['shipping_cost'] ?? 0,
            'payment_method' => $validated['payment_method'] ?? 'transfer',
            'payment_info' => $validated['payment_info'] ?? null,
            'total_amount' => $totalAmount,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Sync products
        $order->products()->sync($productsData);

        // Load order dengan products untuk email
        $order->load('products', 'user');

        // Kirim email ke customer jika status berubah (bukan pending)
        if ($oldStatus !== $validated['status'] && $validated['status'] !== 'pending') {
            try {
                if ($order->user && $order->user->email) {
                    Mail::to($order->user->email)->send(new OrderStatusChangedMail($order, $oldStatus));
                }
            } catch (\Exception $e) {
                Log::error('Failed to send order status changed email: ' . $e->getMessage());
            }
        }

        // Kirim email ke admin untuk notifikasi perubahan status
        try {
            Mail::to(config('mail.from.address'))->send(new AdminOrderNotificationMail($order, 'status_changed'));
        } catch (\Exception $e) {
            \Log::error('Failed to send admin status change notification email: ' . $e->getMessage());
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Update shipping cost quickly.
     */
    public function updateShippingCost(Request $request, Order $order)
    {
        try {
            $validated = $request->validate([
                'shipping_cost' => ['required', 'integer', 'min:0'],
            ]);

            $order->update([
                'shipping_cost' => $validated['shipping_cost'],
            ]);

            // Refresh order
            $order->refresh();

            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ongkos kirim berhasil diupdate menjadi Rp ' . number_format($validated['shipping_cost'], 0, ',', '.'),
                    'shipping_cost' => $order->shipping_cost,
                    'total_with_shipping' => $order->getTotalWithShipping(),
                ]);
            }

            return redirect()->back()
                ->with('success', 'Ongkos kirim berhasil diupdate.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ], 500);
            }
            throw $e;
        }
    }

    /**
     * Update order status quickly.
     */
    public function updateStatus(Request $request, Order $order)
    {
        try {
            $validated = $request->validate([
                'status' => ['required', 'in:pending,paid,shipped,completed,cancelled'],
            ]);

            $oldStatus = $order->status;
            $order->update([
                'status' => $validated['status'],
            ]);

            // Refresh order to get updated status and load relationships
            $order->refresh();
            $order->load('products', 'user');

            // Kirim email ke customer jika status berubah (bukan pending)
            if ($oldStatus !== $validated['status'] && $validated['status'] !== 'pending') {
                try {
                    if ($order->user && $order->user->email) {
                        Mail::to($order->user->email)->send(new OrderStatusChangedMail($order, $oldStatus));
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to send order status changed email: ' . $e->getMessage());
                }
            }

            // Kirim email ke admin untuk notifikasi perubahan status
            try {
                Mail::to(config('mail.from.address'))->send(new AdminOrderNotificationMail($order, 'status_changed'));
            } catch (\Exception $e) {
                Log::error('Failed to send admin status change notification email: ' . $e->getMessage());
            }

            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status pesanan berhasil diubah menjadi ' . $order->getStatusLabel(),
                    'status' => $order->status,
                    'status_label' => $order->getStatusLabel(),
                    'status_badge_class' => $order->getStatusBadgeClass(),
                ]);
            }

            return redirect()->back()
                ->with('success', 'Status pesanan berhasil diubah menjadi ' . $order->getStatusLabel());
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ], 500);
            }
            throw $e;
        }
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
