<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

class MenuController extends Controller
{
    /**
     * Get main menu with its items
     */
    public function getMainMenu()
    {
        $currentLocale = App::getLocale();
        $cacheKey = "main_menu_{$currentLocale}";
        
        // Clear cache for testing
        Cache::forget($cacheKey);
        
        return Cache::remember($cacheKey, 60 * 24, function () use ($currentLocale) {
            $mainMenu = Menu::where('type', 'main')
                ->where('language', $currentLocale)
                ->active()
                ->first();

            if (!$mainMenu) {
                return collect();
            }

            return $mainMenu->items()
                ->whereNull('parent_id')
                ->with(['children' => function ($query) {
                    $query->active()->orderBy('order');
                }])
                ->active()
                ->orderBy('order')
                ->get();
        });
    }

    /**
     * Get menu by type
     */
    public function getMenuByType($type)
    {
        $currentLocale = App::getLocale();
        $cacheKey = "menu_{$type}_{$currentLocale}";
        
        // Clear cache for testing
        Cache::forget($cacheKey);
        
        return Cache::remember($cacheKey, 60 * 24, function () use ($type, $currentLocale) {
            $menu = Menu::where('type', $type)
                ->where('language', $currentLocale)
                ->active()
                ->first();

            if (!$menu) {
                return collect();
            }

            return $menu->items()
                ->whereNull('parent_id')
                ->with(['children' => function ($query) {
                    $query->active()->orderBy('order');
                }])
                ->active()
                ->orderBy('order')
                ->get();
        });
    }
}
