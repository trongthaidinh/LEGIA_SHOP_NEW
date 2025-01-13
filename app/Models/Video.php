<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'youtube_url',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Relationships
    public function videoables()
    {
        return $this->morphMany(Videoable::class, 'videoable');
    }

    // Helpers
    public function getYoutubeIdAttribute()
    {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $this->youtube_url, $matches);
        return $matches[1] ?? null;
    }

    public function getEmbedUrlAttribute()
    {
        return 'https://www.youtube.com/embed/' . $this->youtube_id;
    }

    public function getThumbnailUrlAttribute()
    {
        return 'https://img.youtube.com/vi/' . $this->youtube_id . '/maxresdefault.jpg';
    }
}
