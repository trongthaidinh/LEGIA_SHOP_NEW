<?php

namespace App\Helpers;

class LocaleHelper
{
    public static function getAlternateUrls()
    {
        $urls = [];
        $currentPath = request()->path();
        $segments = explode('/', $currentPath);
        
        // Remove current locale from path
        if (count($segments) > 0) {
            array_shift($segments);
        }
        
        $path = implode('/', $segments);
        
        // Generate URLs for each supported locale
        foreach (['vi', 'zh'] as $locale) {
            $urls[$locale] = url($locale . '/' . $path);
        }
        
        return $urls;
    }
}
