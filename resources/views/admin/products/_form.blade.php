@csrf
@php
    // true kalau dipakai di halaman edit
    $isEdit = isset($product) && $product;
@endphp

<div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="category_id" class="form-select" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ old('category_id', $isEdit ? $product->category_id : '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input
        type="text"
        name="name"
        class="form-control"
        value="{{ old('name', $isEdit ? $product->name : '') }}"
        required
    >
</div>

<div class="mb-3">
    <label class="form-label">Harga (Rp)</label>
    <input
        type="number"
        name="price"
        class="form-control"
        value="{{ old('price', $isEdit ? $product->price : 0) }}"
        min="0"
        required
    >
</div>

<div class="mb-3">
    <label class="form-label">Stok</label>
    <input
        type="number"
        name="stock"
        class="form-control"
        value="{{ old('stock', $isEdit ? $product->stock : 0) }}"
        min="0"
        required
    >
</div>

<div class="mb-3">
    <label class="form-label">Gambar Utama</label>

    {{-- Preview hanya saat edit & sudah ada gambar --}}
    @if($isEdit && $product->main_image)
        <div class="mb-2">
            <img
                src="{{ asset('storage/' . $product->main_image) }}"
                alt="Gambar Produk"
                style="max-width: 200px; border-radius: 8px;"
            >
        </div>
    @endif

    <input
        type="file"
        name="main_image"
        class="form-control"
        accept="image/*"
    >
    <small class="text-muted">Format: JPG, PNG. Max 2MB</small>
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea
        name="description"
        rows="4"
        class="form-control"
    >{{ old('description', $isEdit ? $product->description : '') }}</textarea>
</div>

<div class="mb-3 form-check">
    {{-- kalau tidak dicentang, tetap kirim 0 --}}
    <input type="hidden" name="is_active" value="0">

    <input
        type="checkbox"
        name="is_active"
        id="is_active"
        class="form-check-input"
        value="1"
        {{ old('is_active', $isEdit ? $product->is_active : 1) ? 'checked' : '' }}
    >
    <label for="is_active" class="form-check-label">Aktif</label>
</div>

<button type="submit" class="btn btn-primary">
    Simpan
</button>
<a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark">
    Batal
</a>
