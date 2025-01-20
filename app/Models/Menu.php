<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

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

    // New methods for menu management
    public function addItem(array $data): MenuItem
    {
        return $this->items()->create($data);
    }

    public function updateItem(MenuItem $item, array $data): bool
    {
        return $item->update($data);
    }

    public function deleteItem(MenuItem $item): bool
    {
        return $item->delete();
    }

    public function reorderItems(array $items): bool
    {
        try {
            collect($items)->each(function ($item) {
                $this->items()->where('id', $item['id'])->update([
                    'parent_id' => $item['parent_id'] ?? null,
                    'order' => $item['order']
                ]);
            });
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getMenuTree(): Collection
    {
        return $this->items()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->active()
            ->ordered()
            ->get();
    }

    public function getActiveItems(): Collection
    {
        return $this->items()
            ->active()
            ->ordered()
            ->get();
    }

    public function findItem($id): ?MenuItem
    {
        return $this->items()->find($id);
    }
}
