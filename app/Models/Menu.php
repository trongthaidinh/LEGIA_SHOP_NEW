<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'is_active'
    ];

    // Relationships
    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }

    // Scope
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper method để lấy menu items đã sắp xếp
    public function getOrderedItems()
    {
        return $this->items()
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->nest();
    }
}
