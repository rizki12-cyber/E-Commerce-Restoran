<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    // Admin bisa melihat semua pesanan
    public function viewAny(User $user): bool
    {
        return true; 
    }

    // Customer hanya bisa melihat pesanannya sendiri, Admin bisa melihat semua
    public function view(User $user, Order $order): bool
    {
        return $user->role === 'admin' || $user->id === $order->user_id;
    }

    // Hanya customer pemilik pesanan yang bisa membatalkan
    public function cancel(User $user, Order $order): bool
    {
        return $user->role === 'customer' && $user->id === $order->user_id && $order->status === \App\Enums\OrderStatus::PENDING_PAYMENT;
    }
}