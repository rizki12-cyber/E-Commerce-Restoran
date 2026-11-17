<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $fillable = ['user_id', 'product_id', 'order_id', 'order_item_id', 'rating', 'comment', 'status', 'is_verified_purchase', 'admin_note'];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function product(): BelongsTo { return $this->belongsTo(Product::class); }
    public function order(): BelongsTo { return $this->belongsTo(Order::class); }
    public function images(): HasMany { return $this->hasMany(ReviewImage::class); }
    public function replies(): HasMany { return $this->hasMany(ReviewReply::class); }
}