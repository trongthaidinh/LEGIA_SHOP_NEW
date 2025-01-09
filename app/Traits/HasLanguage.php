<?php

namespace App\Traits;

trait HasLanguage
{
    protected static function bootHasLanguage()
    {
        static::creating(function ($model) {
            if (!$model->language) {
                $model->language = session('admin_language', 'vi');
            }
        });

        static::addGlobalScope('language', function ($query) {
            $language = request()->segment(1) === 'admin' 
                ? session('admin_language', 'vi') 
                : request()->segment(1);
            
            return $query->where('language', $language);
        });
    }

    public function scopeLanguage($query, $language)
    {
        return $query->where('language', $language);
    }
}
