@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i> Chi tiết đơn hàng #{{ $order->id }}
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.orders.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Status -->
        <div class="p-6 border-b border-[var(--color-primary-100)]">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        {{ $order->status === 'processed' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-gray-100 text-gray-700' : '' }}">
                        {{ $order->status_label }}
                    </span>
                    <span class="ml-4 text-sm text-[var(--color-primary-500)]">
                        Đặt hàng lúc: {{ $order->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>
                @if($order->status === 'pending' || $order->status === 'processed')
                <div class="flex space-x-3">
                    @if($order->status === 'pending')
                    <form action="{{ route(app()->getLocale() . '.admin.orders.process', $order) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-600)] text-white text-sm font-medium rounded-md hover:bg-[var(--color-primary-700)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary-500)]">
                            <i class="fas fa-check mr-2"></i> Xử lý đơn hàng
                        </button>
                    </form>
                    @endif
                    <form action="{{ route(app()->getLocale() . '.admin.orders.destroy', $order) }}" 
                          method="POST"
                          onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-[var(--color-secondary-600)] text-white text-sm font-medium rounded-md hover:bg-[var(--color-secondary-700)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-secondary-500)]">
                            <i class="fas fa-times mr-2"></i> Hủy đơn hàng
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>

        <!-- Customer Information -->
        <div class="p-6 border-b border-[var(--color-primary-100)]">
            <h4 class="text-lg font-medium text-[var(--color-primary-900)] mb-4">Thông tin khách hàng</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-[var(--color-primary-600)] mb-1">Họ tên:</p>
                    <p class="text-sm font-medium text-[var(--color-primary-900)]">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-[var(--color-primary-600)] mb-1">Email:</p>
                    <p class="text-sm font-medium text-[var(--color-primary-900)]">{{ $order->customer_email }}</p>
                </div>
                <div>
                    <p class="text-sm text-[var(--color-primary-600)] mb-1">Số điện thoại:</p>
                    <p class="text-sm font-medium text-[var(--color-primary-900)]">{{ $order->customer_phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-[var(--color-primary-600)] mb-1">Địa chỉ giao hàng:</p>
                    <p class="text-sm font-medium text-[var(--color-primary-900)] break-words">{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>

        <!-- Payment and Shipping Information -->
        <div class="p-6 border-b border-[var(--color-primary-100)]">
            <h4 class="text-lg font-medium text-[var(--color-primary-900)] mb-4">Thông tin thanh toán</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-[var(--color-primary-600)] mb-1">Phương thức thanh toán:</p>
                    <p class="text-sm font-medium text-[var(--color-primary-900)]">
                        {{ $order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-[var(--color-primary-600)] mb-1">Phí vận chuyển:</p>
                    <p class="text-sm font-medium text-[var(--color-primary-900)]">
                        {{ number_format($order->shipping_amount) }}đ
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="p-6">
            <h4 class="text-lg font-medium text-[var(--color-primary-900)] mb-4">Chi tiết đơn hàng</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[var(--color-primary-100)]">
                    <thead class="bg-[var(--color-primary-50)]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Sản phẩm</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Đơn giá</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Số lượng</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[var(--color-primary-100)]">
                        @foreach($order->items as $item)
                        <tr class="hover:bg-[var(--color-primary-50)]">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img src="{{ Storage::url($item->product->featured_image) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-12 h-12 object-cover rounded-lg">
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-[var(--color-primary-900)]">{{ $item->product->name }}</p>
                                        <p class="text-sm text-[var(--color-primary-500)]">SKU: {{ $item->product->sku }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-[var(--color-primary-900)]">
                                {{ number_format($item->price) }}đ
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-[var(--color-primary-900)]">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-[var(--color-primary-900)]">
                                {{ number_format($item->price * $item->quantity) }}đ
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-[var(--color-primary-50)]">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-[var(--color-primary-900)]">Tổng cộng:</td>
                            <td class="px-6 py-4 text-right text-sm font-medium text-[var(--color-primary-900)]">
                                {{ number_format($order->total_amount) }}đ
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection