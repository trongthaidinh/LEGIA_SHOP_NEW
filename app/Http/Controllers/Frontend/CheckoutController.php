<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::count() == 0) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        return view('frontend.checkout.index');
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|max:255',
            'customer_phone' => 'required|max:20',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|max:255',
            'shipping_city' => 'required|max:255',
            'shipping_district' => 'required|max:255',
            'shipping_ward' => 'required|max:255'
        ]);

        // Create order
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_district' => $request->shipping_district,
            'shipping_ward' => $request->shipping_ward,
            'notes' => $request->notes,
            'total_amount' => Cart::total(0, '', ''),
            'shipping_amount' => 0, // Có thể tính phí ship sau
            'status' => 'pending'
        ]);

        // Create order items
        foreach (Cart::content() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'product_name' => $item->name,
                'quantity' => $item->qty,
                'price' => $item->price,
                'total' => $item->total
            ]);
        }

        // Clear cart
        Cart::destroy();

        return redirect()->route('checkout.success', $order->id)
            ->with('success', 'Đơn hàng của bạn đã được đặt thành công!');
    }

    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('frontend.checkout.success', compact('order'));
    }
}
