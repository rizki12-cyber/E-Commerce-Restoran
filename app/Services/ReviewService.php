<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    public function createReview(array $data)
    {
        $orderItem = OrderItem::with('order')->findOrFail($data['order_item_id']);

        // 1. Validasi kepemilikan order
        if ($orderItem->order->user_id !== Auth::id()) {
            throw new \Exception('Anda tidak berhak mereview pesanan ini.');
        }

        // 2. Validasi status order harus completed
        if ($orderItem->order->status->value !== 'completed') {
            throw new \Exception('Pesanan belum selesai, Anda belum bisa memberikan ulasan.');
        }

        // 3. Validasi belum pernah direview
        $existingReview = Review::where('user_id', Auth::id())
            ->where('order_item_id', $orderItem->id)
            ->exists();

        if ($existingReview) {
            throw new \Exception('Anda sudah memberikan ulasan untuk item pesanan ini.');
        }

        // 4. Simpan review (Status default: pending)
        return Review::create([
            'user_id' => Auth::id(),
            'product_id' => $orderItem->product_id,
            'order_id' => $orderItem->order_id,
            'order_item_id' => $orderItem->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'],
            'status' => 'pending', // Menunggu moderasi admin
            'is_verified_purchase' => true,
        ]);
    }
}