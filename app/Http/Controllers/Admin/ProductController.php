<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\ActivityLogService; // TAMBAHAN
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku',
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);
        
        $slugCount = Product::where('slug', $validated['slug'])->count();
        if ($slugCount > 0) {
            $validated['slug'] .= '-' . time();
        }

        if ($request->hasFile('primary_image')) {
            $validated['primary_image'] = $request->file('primary_image')->store('products', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_best_seller'] = $request->has('is_best_seller');

        // Simpan ke variabel untuk log
        $product = Product::create($validated);

        // Catat Log
        ActivityLogService::log('Tambah Produk', 'Menambahkan produk baru: ' . $product->name, $product);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
        ]);

        if ($request->name !== $product->name) {
            $validated['slug'] = Str::slug($request->name);
            $slugCount = Product::where('slug', $validated['slug'])->where('id', '!=', $product->id)->count();
            if ($slugCount > 0) {
                $validated['slug'] .= '-' . time();
            }
        }

        if ($request->hasFile('primary_image')) {
            if ($product->primary_image) {
                Storage::disk('public')->delete($product->primary_image);
            }
            $validated['primary_image'] = $request->file('primary_image')->store('products', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_best_seller'] = $request->has('is_best_seller');

        $product->update($validated);

        // Catat Log
        ActivityLogService::log('Edit Produk', 'Mengubah data produk: ' . $product->name, $product);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        // Catat Log sebelum dihapus
        ActivityLogService::log('Hapus Produk', 'Menghapus produk: ' . $product->name, $product);

        if ($product->primary_image) {
            Storage::disk('public')->delete($product->primary_image);
        }
        
        $product->delete(); // Soft delete

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}