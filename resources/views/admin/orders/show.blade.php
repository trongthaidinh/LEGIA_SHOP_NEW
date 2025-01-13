@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Header -->
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i> Chi tiết đơn hàng #{{ $order->id }}
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.orders.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Status -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ $order->status }}
                    </span>
                    <span class="ml-4 text-sm text-gray-500">
                        Đặt hàng lúc: {{ $order->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>
                @if($order->status === 'pending')
                <div class="flex space-x-3">
                    <form action="{{ route(app()->getLocale() . '.admin.orders.process', $order) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-check mr-2"></i> Xử lý đơn hàng
                        </button>
                    </form>
                    <form action="{{ route(app()->getLocale() . '.admin.orders.destroy', $order) }}" 
                          method="POST"
                          onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="fas fa-times mr-2"></i> Hủy đơn hàng
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>

        <!-- Customer Information -->
        <div class="p-6 border-b border-gray-200">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Thông tin khách hàng</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Họ tên:</p>
                    <p class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Email:</p>
                    <p class="text-sm font-medium text-gray-900">{{ $order->customer_email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Số điện thoại:</p>
                    <p class="text-sm font-medium text-gray-900">{{ $order->customer_phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Địa chỉ:</p>
                    <p class="text-sm font-medium text-gray-900">{{ $order->customer_address }}</p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Chi tiết đơn hàng</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Đơn giá</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img src="{{ $item->product->image_url }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-12 h-12 object-cover rounded-lg">
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-500">SKU: {{ $item->product->sku }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-900">
                                {{ number_format($item->price) }}đ
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-900">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-900">
                                {{ number_format($item->price * $item->quantity) }}đ
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Tổng cộng:</td>
                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
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