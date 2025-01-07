<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'visibility',
        'is_active',
        'order'
    ];

    // Relationships
    public function products()
    {
        return $this->morphedByMany(Product::class, 'imageable');
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'imageable');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Accessors
    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFullUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
