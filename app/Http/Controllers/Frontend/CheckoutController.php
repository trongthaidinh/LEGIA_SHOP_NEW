<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('frontend.checkout.index');
    }

    public function process(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_info.full_name' => 'required|string',
                'customer_info.phone' => 'required|string',
                'customer_info.email' => 'required|email',
                'shipping_address' => 'required|string',
                'payment_method' => 'required|in:cod,bank',
                'items' => 'required|array'
            ]);

            $subtotal = $this->calculateSubtotal($validated['items']);
            $shippingAmount = $subtotal >= 500000 ? 0 : 30000;

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'customer_name' => $validated['customer_info']['full_name'],
                'customer_phone' => $validated['customer_info']['phone'],
                'customer_email' => $validated['customer_info']['email'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => 1,
                'shipping_district' => 1, 
                'shipping_ward' => 1, 
                'payment_method' => $validated['payment_method'],
                'notes' => $request->input('notes'),
                'status' => 'pending',
                'language' => $request->input('language'),
                'total_amount' => $subtotal,
                'shipping_amount' => $shippingAmount
            ]);

            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity']
                ]);
            }

            Mail::to($order->customer_email)->queue(new OrderConfirmation($order));

            return response()->json([
                'success' => true,
                'order_id' => $order->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function success(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        return view('frontend.checkout.success', compact('order'));
    }

    private function calculateSubtotal($items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
