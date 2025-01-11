<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'admin_id',
        'post_category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'published_at',
        'language',
        'is_featured'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where(function($q) {
                        $q->whereNull('published_at')
                          ->orWhere('published_at', '<=', now());
                    });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByLanguage($query, $language = null)
    {
        $lang = $language ?? App::getLocale();
        return $query->where('language', $lang);
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function categories()
    {
        return $this->belongsToMany(PostCategory::class, 'post_post_category', 'post_id', 'post_category_id');
    }
}
