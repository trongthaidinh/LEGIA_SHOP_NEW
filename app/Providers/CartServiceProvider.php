<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Darryldecode\Cart\Cart;
use App\Services\CartSessionStorage;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('cart', function($app)
        {
            $storage = new CartSessionStorage();
            
            $events = $app['events'];
            $instanceName = 'cart';
            $session_key = 'cart_id';
            
            $config = config('shopping_cart');
            if(is_null($config)) {
                $config = [
                    'format_numbers' => false,
                    'decimals' => 0,
                    'dec_point' => '.',
                    'thousands_sep' => ','
                ];
            }
            
            return new Cart(
                $storage,
                $events,
                $instanceName,
                $session_key,
                $config
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
