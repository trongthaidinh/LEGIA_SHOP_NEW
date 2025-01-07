<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_name',
        'customer_avatar',
        'position',
        'content',
        'rating',
        'status'
    ];

    protected $casts = [
        'rating' => 'integer'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
