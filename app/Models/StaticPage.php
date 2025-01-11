<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StaticPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 
        'title', 
        'content', 
        'locale', 
        'is_active', 
        'meta_description', 
        'meta_keywords'
    ];

    // Automatically generate slug if not provided
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $value 
            ? Str::slug($value) 
            : Str::slug($this->title);
    }

    // Scope to find page by slug and locale
    public function scopeFindBySlug($query, $slug, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        
        return $query->where('slug', $slug)
            ->where('locale', $locale)
            ->where('is_active', true)
            ->firstOrFail();
    }

    // Method to create or update static page
    public static function createOrUpdatePage($data)
    {
        return self::updateOrCreate(
            [
                'slug' => $data['slug'] ?? Str::slug($data['title']),
                'locale' => $data['locale'] ?? 'vi'
            ],
            [
                'title' => $data['title'],
                'content' => $data['content'],
                'is_active' => $data['is_active'] ?? true,
                'meta_description' => $data['meta_description'] ?? null,
                'meta_keywords' => $data['meta_keywords'] ?? null
            ]
        );
    }
}
