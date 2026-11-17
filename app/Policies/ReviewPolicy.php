<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    // Admin bisa moderasi, customer bisa melihat review miliknya
    public function viewAny(User $user): bool
    {
        return true;
    }

    // Hanya Admin yang bisa mengubah status (approve/reject)
    public function update(User $user, Review $review): bool
    {
        return $user->role === 'admin';
    }
}