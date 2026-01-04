<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\AdminOrderNotificationMail;
use App\Mail\OrderCreatedMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang
     */
    public function index()
    {
        $cart = session()->get('cart', []);
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

        return view('front.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Tambahkan produk ke keranjang
     */
    public function add(Request $request, Product $product)
    {
        // Validasi stok
        if (!$product->is_active) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        $quantity = $request->input('quantity', 1);

        if ($quantity < 1) {
            return back()->with('error', 'Jumlah minimal 1.');
        }

        if ($quantity > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
        }

        $cart = session()->get('cart', []);

        // Jika produk sudah ada di cart, tambahkan quantity
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;

            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
            }

            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            // Tambahkan produk baru
            $cart[$product->id] = [
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update quantity produk di keranjang
     */
    public function update(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);

        if ($quantity < 1) {
            return back()->with('error', 'Jumlah minimal 1.');
        }

        if ($quantity > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            if ($quantity == 0) {
                // Hapus dari cart
                unset($cart[$product->id]);
            } else {
                $cart[$product->id]['quantity'] = $quantity;
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Hapus produk dari keranjang
     */
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * Kosongkan keranjang
     */
    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }

    /**
     * Get cart count (untuk AJAX/API)
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = 0;

        foreach ($cart as $item) {
            $count += $item['quantity'];
        }

        return response()->json(['count' => $count]);
    }

    /**
     * Checkout - Simpan order dari cart ke database
     */
    public function checkout(Request $request)
    {
        // Validasi harus login sebagai customer
        if (!Auth::check() || Auth::user()->role !== 'customer') {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk checkout.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Validasi form
        $validated = $request->validate([
            'customer_contact' => ['required', 'string', 'max:255'],
            'shipping_method' => ['required', 'in:jnt,pickup'],
            'shipping_address' => ['required_if:shipping_method,jnt', 'nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        // Hitung total dan siapkan data produk
        $totalAmount = 0;
        $productsData = [];
        $cartItems = [];

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            
            if (!$product || !$product->is_active) {
                return redirect()->route('cart.index')
                    ->with('error', 'Produk ' . ($product ? $product->name : 'tidak ditemukan') . ' tidak tersedia.');
            }

            $quantity = $item['quantity'];
            
            if ($quantity > $product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', 'Stok ' . $product->name . ' tidak mencukupi. Stok tersedia: ' . $product->stock);
            }

            $subtotal = $product->price * $quantity;
            $totalAmount += $subtotal;

            $productsData[$product->id] = [
                'quantity' => $quantity,
                'price' => $product->price,
            ];

            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }

        // Simpan order ke database
        // Ongkos kirim akan ditentukan oleh admin setelah pesanan dibuat
        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => Auth::user()->name,
                'customer_contact' => $validated['customer_contact'],
                'shipping_address' => $validated['shipping_address'] ?? null,
                'shipping_method' => $validated['shipping_method'],
                'shipping_cost' => 0, // Akan diisi admin setelah konfirmasi
                'payment_method' => 'transfer', // Default payment method
                'total_amount' => $totalAmount, // Subtotal tanpa ongkos kirim
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Attach products
            $order->products()->attach($productsData);

            // Kurangi stok produk
            foreach ($productsData as $productId => $data) {
                $product = Product::find($productId);
                $product->decrement('stock', $data['quantity']);
            }

            DB::commit();

            // Load order dengan products untuk email
            $order->load('products');

            // Kirim email ke customer
            try {
                if ($order->user && $order->user->email) {
                    Mail::to($order->user->email)->send(new OrderCreatedMail($order));
                }
            } catch (\Exception $e) {
                // Log error but don't fail the order creation
                Log::error('Failed to send order created email: ' . $e->getMessage());
            }

            // Kirim email ke admin
            try {
                Mail::to(config('mail.from.address'))->send(new AdminOrderNotificationMail($order, 'new_order'));
            } catch (\Exception $e) {
                // Log error but don't fail the order creation
                Log::error('Failed to send admin notification email: ' . $e->getMessage());
            }

            // Kosongkan cart
            session()->forget('cart');

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi dari admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }
}
