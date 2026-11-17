<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Cart;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutService
{
    public function processCheckout(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $user = Auth::user();
            $cart = Cart::with(['items.product', 'items.variant'])->where('user_id', $user->id)->first();

            if (!$cart || $cart->items->isEmpty()) {
                throw new \Exception('Keranjang belanja kosong.');
            }

            $subtotal = 0;
            $orderItemsData = [];

            // 1. Validasi Stok & Hitung Subtotal
            foreach ($cart->items as $item) {
                // Kunci baris produk untuk mencegah race condition (overselling)
                $product = Product::lockForUpdate()->find($item->product_id);

                if (!$product->is_active || $product->stock < $item->quantity) {
                    throw new \Exception("Stok untuk {$product->name} tidak mencukupi atau produk tidak aktif.");
                }

                $price = $product->discount_price ?? $product->price;
                
                if ($item->variant) {
                    $price += $item->variant->additional_price;
                }

                $addonNames = [];
                if ($item->addon_ids) {
                    $addons = \App\Models\ProductAddon::whereIn('id', $item->addon_ids)->get();
                    foreach ($addons as $addon) {
                        $price += $addon->price;
                        $addonNames[] = $addon->name;
                    }
                }

                $lineTotal = $price * $item->quantity;
                $subtotal += $lineTotal;

                // Simpan data untuk snapshot order_items
                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'variant_name' => $item->variant ? $item->variant->name : null,
                    'addon_names' => empty($addonNames) ? null : $addonNames,
                    'unit_price' => $price,
                    'quantity' => $item->quantity,
                    'line_total' => $lineTotal,
                    'notes' => $item->notes,
                ];

                // 2. Kurangi Stok & Catat Inventory Movement
                $product->decrement('stock', $item->quantity);
                
                InventoryMovement::create([
                    'product_id' => $product->id,
                    'product_variant_id' => $item->product_variant_id,
                    'type' => 'out',
                    'quantity' => $item->quantity,
                    'reason' => 'sale',
                    'reference_type' => 'order',
                    'created_by' => $user->id, 
                ]);
            }

            // 3. Buat Order
            $shippingCost = $data['shipping_method'] === 'delivery' ? 10000 : 0; // Ongkir statis
            $totalAmount = $subtotal + $shippingCost;

            $order = Order::create([
                'order_number' => 'DK-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
                'user_id' => $user->id,
                'status' => OrderStatus::PENDING_PAYMENT->value,
                'payment_status' => PaymentStatus::UNPAID->value,
                'payment_method' => $data['payment_method'],
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total_amount' => $totalAmount,
                'shipping_method' => $data['shipping_method'],
                'shipping_address' => [
                    'name' => $data['customer_name'],
                    'phone' => $data['customer_phone'],
                    'address' => $data['shipping_address'] ?? null,
                    'notes' => $data['notes'] ?? null,
                ],
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $user->email,
            ]);

            // 4. Simpan Order Items (Snapshot)
            $order->items()->createMany($orderItemsData);

            // 5. Buat Record Pembayaran (Status Unpaid)
            $order->payments()->create([
                'method' => $data['payment_method'],
                'status' => PaymentStatus::UNPAID->value,
                'amount' => $totalAmount,
            ]);

            // 6. Catat Status History
            $order->statusHistories()->create([
                'from_status' => null,
                'to_status' => OrderStatus::PENDING_PAYMENT->value,
                'changed_by' => $user->id,
                'note' => 'Pesanan dibuat oleh customer.',
            ]);

            // 7. Kosongkan Keranjang
            $cart->items()->delete();

            return $order;
        });

                    // ... setelah perhitungan $totalAmount ...

            $discountAmount = 0;
            if (isset($data['voucher_id'])) {
                $voucher = \App\Models\Voucher::find($data['voucher_id']);
                if ($voucher) {
                    if ($voucher->type->value === 'percentage') {
                        $discountAmount = ($subtotal * $voucher->value) / 100;
                        if ($voucher->max_discount && $discountAmount > $voucher->max_discount) {
                            $discountAmount = $voucher->max_discount;
                        }
                    } else {
                        $discountAmount = $voucher->value;
                    }
                    
                    $totalAmount -= $discountAmount;
                    if ($totalAmount < 0) $totalAmount = 0;

                    // Catat penggunaan voucher
                    \App\Models\VoucherUsage::create([
                        'voucher_id' => $voucher->id,
                        'user_id' => $user->id,
                        'order_id' => $order->id ?? 0, // Disesuaikan setelah order dibuat
                        'used_at' => now(),
                    ]);
                }
            }

            // ... lanjut ke pembuatan Order ...
            $order = Order::create([
                // ...
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount, // Simpan diskon
                'total_amount' => $totalAmount,       // Total akhir setelah diskon
                'voucher_id' => $data['voucher_id'] ?? null,
                'voucher_code' => $data['voucher_code'] ?? null,
                // ...
            ]);
    }
}