<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'label',
        'description',
        'order'
    ];

    // Cache key
    const CACHE_KEY = 'settings';

    // Helper methods để lấy giá trị setting
    public static function get($key, $default = null)
    {
        $settings = Cache::rememberForever(self::CACHE_KEY, function () {
            return self::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    public static function getGroup($group)
    {
        return self::where('group', $group)
            ->orderBy('order')
            ->get();
    }

    // Override save method để clear cache
    public function save(array $options = [])
    {
        Cache::forget(self::CACHE_KEY);
        return parent::save($options);
    }

    // Override delete method để clear cache
    public function delete()
    {
        Cache::forget(self::CACHE_KEY);
        return parent::delete();
    }
}
