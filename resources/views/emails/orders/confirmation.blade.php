<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .order-info {
            background: #fff;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .order-table th, 
        .order-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .order-table th {
            background: #f8f9fa;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            padding: 15px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #666;
            border-top: 1px solid #ddd;
        }
        .thank-you {
            color: #28a745;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        .shipping-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
    </div>

    <h2 class="thank-you">Cảm ơn bạn đã đặt hàng!</h2>

    <div class="order-info">
        <h3>Thông tin đơn hàng #{{ $order->order_number }}</h3>
        <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Trạng thái:</strong> 
            <span style="color: #28a745">{{ $order->status_label }}</span>
        </p>
        <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>
    </div>

    <div class="shipping-info">
        <h3>Thông tin giao hàng</h3>
        <p><strong>Người nhận:</strong> {{ $order->customer_name }}</p>
        <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->full_address }}</p>
        <p><strong>Ghi chú:</strong> {{ $order->notes ?? 'Không có' }}</p>
    </div>

    <h3>Chi tiết đơn hàng</h3>
    <table class="order-table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th style="text-align: center">Số lượng</th>
                <th style="text-align: right">Đơn giá</th>
                <th style="text-align: right">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    {{ $item->product_name }}
                    @if($item->options)
                        <br>
                        <small>{{ implode(', ', $item->options) }}</small>
                    @endif
                </td>
                <td style="text-align: center">{{ $item->quantity }}</td>
                <td style="text-align: right">{{ number_format($item->price) }}đ</td>
                <td style="text-align: right">{{ number_format($item->total) }}đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Tạm tính: {{ number_format($order->subtotal) }}đ</p>
        @if($order->discount > 0)
        <p>Giảm giá: -{{ number_format($order->discount) }}đ</p>
        @endif
        <p>Phí vận chuyển: {{ number_format($order->shipping_fee) }}đ</p>
        <p style="font-size: 20px; color: #dc3545;">Tổng cộng: {{ number_format($order->total) }}đ</p>
    </div>

    <div class="footer">
        <p>Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi qua:</p>
        <p>Email: {{ config('mail.from.address') }} | Hotline: {{ config('app.phone', '1900 xxxx') }}</p>
        <p>Địa chỉ: {{ config('app.address', '123 ABC Street, XYZ City') }}</p>
        <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>