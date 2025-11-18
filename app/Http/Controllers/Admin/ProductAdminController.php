<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    // Tampilkan dashboard: daftar produk
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    // Form tambah produk
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'price'       => ['required', 'integer', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'main_image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);

        if ($request->hasFile('main_image')) {
        $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    // Form edit produk
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, Product $product)
{
    $data = $request->validate([
        'category_id' => ['required', 'exists:categories,id'],
        'name'        => ['required', 'string', 'max:255'],
        'price'       => ['required', 'integer', 'min:0'],
        'stock'       => ['required', 'integer', 'min:0'],
        'description' => ['nullable', 'string'],
        'main_image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        'is_active'   => ['nullable', 'boolean'],
    ]);

    // Kalau nama berubah, perbarui slug juga
    if ($product->name !== $data['name']) {
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);
    }

    // Kalau upload gambar baru
    if ($request->hasFile('main_image')) {
        // (opsional) hapus file lama
        // if ($product->main_image) {
        //     \Storage::disk('public')->delete($product->main_image);
        // }

        $data['main_image'] = $request->file('main_image')->store('products', 'public');
    } else {
        // kalau tidak upload baru, jangan ubah field main_image
        unset($data['main_image']);
    }

    $data['is_active'] = $request->boolean('is_active', true);

    $product->update($data);

    return redirect()->route('admin.products.index')
        ->with('success', 'Produk berhasil diperbarui.');
}


    // Hapus produk
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
