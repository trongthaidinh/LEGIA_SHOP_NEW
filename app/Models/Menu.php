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
        'language',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationships
    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    // Get ordered menu items
    public function getOrderedItems()
    {
        return $this->items()
            ->whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->active()->orderBy('order');
            }])
            ->active()
            ->orderBy('order')
            ->get();
    }
}
