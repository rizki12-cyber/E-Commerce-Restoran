<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\WishlistItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        if (!$product->is_active) {
            abort(404);
        }

        // Load relasi
        $product->load(['category', 'images', 'variants', 'addons']);

        // Ambil review yang sudah di-approve admin
        $reviews = Review::with(['user', 'images'])
            ->where('product_id', $product->id)
            ->where('status', 'approved')
            ->latest()
            ->paginate(5);

        // Rekomendasi produk (kategori sama, kecuali produk ini)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        // --- LOGIKA WISHLIST DIPINDAH KE SINI ---
        $inWishlist = false;
        if (Auth::check() && Auth::user()->role === 'customer') {
            $inWishlist = WishlistItem::whereHas('wishlist', function($q) {
                $q->where('user_id', Auth::id());
            })->where('product_id', $product->id)->exists();
        }
        // ----------------------------------------

        // Pastikan $inWishlist dimasukkan ke dalam compact()
        return view('customer.catalog.show', compact('product', 'reviews', 'relatedProducts', 'inWishlist'));
    }
}