<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    public function addItem(int $productId, int $quantity, ?int $variantId = null, ?array $addonIds = null, ?string $notes = null): CartItem
    {
        $product = Product::findOrFail($productId);

        if ($product->stock < $quantity) {
            throw new \Exception('Stok tidak mencukupi.');
        }

        $cart = $this->getCart();

        // Ambil semua item di keranjang dengan produk & varian yang sama
        $potentialItems = $cart->items()
            ->where('product_id', $productId)
            ->where('product_variant_id', $variantId)
            ->get();

        // Cari item yang add-on-nya PERSIS sama (menggunakan filter PHP)
        $existingItem = $potentialItems->first(function ($item) use ($addonIds) {
            // Bandingkan array addon_ids (karena cast 'array' di model, ini sudah berupa array)
            return $item->addon_ids == $addonIds;
        });

        if ($existingItem) {
            $newQty = $existingItem->quantity + $quantity;
            if ($product->stock < $newQty) {
                throw new \Exception('Total jumlah melebihi stok yang tersedia.');
            }
            $existingItem->update(['quantity' => $newQty]);
            return $existingItem;
        }

        return $cart->items()->create([
            'product_id' => $productId,
            'product_variant_id' => $variantId,
            'quantity' => $quantity,
            'addon_ids' => $addonIds,
            'notes' => $notes,
        ]);
    }

    public function updateQuantity(CartItem $cartItem, int $quantity): void
    {
        if ($cartItem->product->stock < $quantity) {
            throw new \Exception('Stok tidak mencukupi.');
        }

        if ($quantity <= 0) {
            $cartItem->delete();
            return;
        }

        $cartItem->update(['quantity' => $quantity]);
    }
}