<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function bank(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        return view('frontend.payment.bank', compact('order'));
    }
} 