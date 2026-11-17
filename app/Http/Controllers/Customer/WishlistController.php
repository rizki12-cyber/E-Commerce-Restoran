<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(): View
    {
        $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);
        $items = $wishlist->items()->with('product')->latest()->get();
        
        return view('customer.wishlist.index', compact('items'));
    }

    public function toggle(Request $request): RedirectResponse
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);
        
        $item = $wishlist->items()->where('product_id', $request->product_id)->first();

        if ($item) {
            $item->delete();
            return redirect()->back()->with('success', 'Produk dihapus dari wishlist.');
        }

        $wishlist->items()->create(['product_id' => $request->product_id]);
        return redirect()->back()->with('success', 'Produk ditambahkan ke wishlist!');
    }
}