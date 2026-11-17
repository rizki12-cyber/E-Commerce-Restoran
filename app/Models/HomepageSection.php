<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = [
        'section_key', 'title', 'content', 'image', 'settings', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];
}