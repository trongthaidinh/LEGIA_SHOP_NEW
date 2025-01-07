<?php

namespace App\Services;

use Darryldecode\Cart\CartCollection;

class CartSessionStorage
{
    private $session;
    private $sessionKey;

    public function __construct()
    {
        $this->session = session();
        $this->sessionKey = config('shopping_cart.storage.key', 'cart_id');
    }

    public function has($key)
    {
        return $this->session->has($this->sessionKey . '_' . $key);
    }

    public function get($key)
    {
        $content = $this->session->get($this->sessionKey . '_' . $key);
        
        return new CartCollection($content);
    }

    public function put($key, $value)
    {
        $this->session->put($this->sessionKey . '_' . $key, $value);
    }
}
