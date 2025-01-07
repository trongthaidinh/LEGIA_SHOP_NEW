<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::getContent();
        return view('frontend.cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->sale_price ?? $product->price,
            'quantity' => $request->quantity ?? 1,
            'attributes' => [
                'image' => $product->featured_image,
                'slug' => $product->slug
            ]
        ]);

        return back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        Cart::update($request->rowId, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ]
        ]);

        return back()->with('success', 'Giỏ hàng đã được cập nhật!');
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);
        return back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }

    public function clear()
    {
        Cart::clear();
        return back()->with('success', 'Giỏ hàng đã được xóa!');
    }
}
