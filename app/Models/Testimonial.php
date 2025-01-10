<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_name',
        'customer_avatar',
        'position',
        'content',
        'rating',
        'status',
        'language'
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

    public function scopeByLanguage($query, $language = null)
    {
        $lang = $language ?? App::getLocale();
        return $query->where('language', $lang);
    }
}
