<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(CartService $cartService): View|RedirectResponse
    {
        $cart = $cartService->getCart();
        $cart->load(['items.product', 'items.variant']);
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Hitung subtotal
        $subtotal = 0;
        foreach ($cart->items as $item) {
            $price = $item->product->discount_price ?? $item->product->price;
            if ($item->variant) $price += $item->variant->additional_price;
            if ($item->addon_ids) {
                $addons = \App\Models\ProductAddon::whereIn('id', $item->addon_ids)->get();
                foreach ($addons as $addon) $price += $addon->price;
            }
            $subtotal += $price * $item->quantity;
        }

        return view('customer.checkout.index', compact('cart', 'subtotal'));
    }

        public function store(Request $request, CheckoutService $checkoutService): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_method' => 'required|in:pickup,delivery',
            'shipping_address' => 'required_if:shipping_method,delivery|nullable|string',
            'payment_method' => 'required|in:manual_transfer,cod',
            'notes' => 'nullable|string',
            'voucher_code' => 'nullable|string|exists:vouchers,code', // TAMBAHKAN INI
        ]);

        try {
            // Cari voucher jika diisi
            $voucher = null;
            if ($request->filled('voucher_code')) {
                $voucher = \App\Models\Voucher::where('code', $request->voucher_code)->where('is_active', true)->first();
                
                // Validasi tambahan (kuota, tanggal, min belanja bisa ditambahkan di sini)
                if ($voucher) {
                    $validated['voucher_id'] = $voucher->id;
                    $validated['voucher_code'] = $voucher->code;
                }
            }

            $order = $checkoutService->processCheckout($validated);
            
            return redirect()->route('customer.orders.show', $order->order_number)
                ->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');
                
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}