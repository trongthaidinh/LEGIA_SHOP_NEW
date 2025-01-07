<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'youtube_url',
        'order',
        'is_active'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Helper method để lấy YouTube video ID
    public function getYoutubeIdAttribute()
    {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $this->youtube_url, $matches);
        return $matches[1] ?? null;
    }

    // Helper method để lấy YouTube thumbnail URL
    public function getThumbnailUrlAttribute()
    {
        return 'https://img.youtube.com/vi/' . $this->youtube_id . '/maxresdefault.jpg';
    }

    // Helper method để lấy YouTube embed URL
    public function getEmbedUrlAttribute()
    {
        return 'https://www.youtube.com/embed/' . $this->youtube_id;
    }
}
