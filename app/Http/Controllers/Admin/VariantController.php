<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductAddon;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('name')->get();
        $selectedProduct = null;

        if ($request->filled('product_id')) {
            $selectedProduct = Product::with(['variants', 'addons'])->findOrFail($request->product_id);
        }

        return view('admin.variants.index', compact('products', 'selectedProduct'));
    }

    // --- LOGIKA VARIASI ---
    public function storeVariant(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'additional_price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0'
        ]);

        $product->variants()->create([
            'name' => $request->name,
            'additional_price' => $request->additional_price,
            'stock' => $request->stock,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->back()->with('success', 'Variasi berhasil ditambahkan.');
    }

    public function updateVariant(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'additional_price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0'
        ]);

        $variant->update([
            'name' => $request->name,
            'additional_price' => $request->additional_price,
            'stock' => $request->stock,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->back()->with('success', 'Variasi berhasil diperbarui.');
    }

    public function destroyVariant(ProductVariant $variant)
    {
        $variant->delete();
        return redirect()->back()->with('success', 'Variasi berhasil dihapus.');
    }

    // --- LOGIKA ADD-ON ---
    public function storeAddon(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $product->addons()->create([
            'name' => $request->name,
            'price' => $request->price,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->back()->with('success', 'Add-on berhasil ditambahkan.');
    }

    public function updateAddon(Request $request, ProductAddon $addon)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $addon->update([
            'name' => $request->name,
            'price' => $request->price,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->back()->with('success', 'Add-on berhasil diperbarui.');
    }

    public function destroyAddon(ProductAddon $addon)
    {
        $addon->delete();
        return redirect()->back()->with('success', 'Add-on berhasil dihapus.');
    }
}