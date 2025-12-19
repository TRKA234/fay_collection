<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function show()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            if ($product && $product->is_active) {
                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang tidak valid.');
        }

        return view('front.checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $data = $request->validate([
            'customer_name'     => ['required', 'string', 'max:120'],
            'customer_contact'  => ['required', 'string', 'max:30'],
            'shipping_address'  => ['required', 'string', 'max:600'],
            'notes'             => ['nullable', 'string', 'max:500'],
        ]);

        $user = auth()->user();

        return DB::transaction(function () use ($cart, $data, $user) {

            // Lock stok biar aman
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;

            // Validasi stok + hitung total pakai harga DB
            foreach ($cart as $productId => $item) {
                $product = $products[$productId] ?? null;

                if (!$product || !$product->is_active) {
                    return redirect()->route('cart.index')->with('error', 'Ada produk yang sudah tidak tersedia.');
                }

                $qty = (int) $item['quantity'];
                if ($qty < 1) {
                    return redirect()->route('cart.index')->with('error', 'Jumlah item tidak valid.');
                }

                if ($qty > $product->stock) {
                    return redirect()->route('cart.index')->with(
                        'error',
                        "Stok {$product->name} tidak mencukupi. Sisa stok: {$product->stock}."
                    );
                }

                $total += ($product->price * $qty);
            }

            // Buat order
            $order = Order::create([
                'user_id'          => $user->id,
                'customer_name'    => $data['customer_name'],
                'customer_contact' => $data['customer_contact'],
                'shipping_address' => $data['shipping_address'],
                'total_amount'     => $total,
                'status'           => 'pending',
                'notes'            => $data['notes'] ?? null,
            ]);

            // Attach item + kurangi stok
            foreach ($cart as $productId => $item) {
                $product = $products[$productId];
                $qty = (int) $item['quantity'];

                $order->products()->attach($product->id, [
                    'quantity' => $qty,
                    'price'    => (int) $product->price,
                ]);

                $product->decrement('stock', $qty);
            }

            session()->forget('cart');

            return redirect()
                ->route('orders.mine.show', $order)
                ->with('success', 'Pesanan berhasil dibuat!');
        });
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('front.orders.index', compact('orders'));
    }

    public function myOrderShow(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('products');

        return view('front.orders.show', compact('order'));
    }
}
