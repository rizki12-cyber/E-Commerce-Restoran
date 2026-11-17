<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): View
    {
        $cart = $this->cartService->getCart();
        $cart->load(['items.product', 'items.variant']);
        
        $subtotal = 0;
        foreach ($cart->items as $item) {
            $price = $item->product->price;
            if ($item->product->discount_price) {
                $price = $item->product->discount_price;
            }
            if ($item->variant) {
                $price += $item->variant->additional_price;
            }
            
            // Hitung harga add-on
            if ($item->addon_ids) {
                $addons = \App\Models\ProductAddon::whereIn('id', $item->addon_ids)->get();
                foreach ($addons as $addon) {
                    $price += $addon->price;
                }
            }
            
            $subtotal += $price * $item->quantity;
        }

        return view('customer.cart.index', compact('cart', 'subtotal'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
            'addon_ids' => 'nullable|array',
            'addon_ids.*' => 'exists:product_addons,id',
        ]);

        try {
            $this->cartService->addItem(
                $request->product_id,
                $request->quantity,
                $request->variant_id,
                $request->addon_ids,
                $request->notes
            );

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $request->validate(['quantity' => 'required|integer']);

        try {
            $this->cartService->updateQuantity($cartItem, $request->quantity);
            return redirect()->route('customer.cart.index')->with('success', 'Keranjang diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('customer.cart.index')->with('error', $e->getMessage());
        }
    }

    public function destroy(CartItem $cartItem): RedirectResponse
    {
        $cartItem->delete();
        return redirect()->route('customer.cart.index')->with('success', 'Item dihapus dari keranjang.');
    }
}