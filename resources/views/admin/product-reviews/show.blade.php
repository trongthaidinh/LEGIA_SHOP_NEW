@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-star mr-2"></i> Chi tiết đánh giá
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.product-reviews.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h5 class="text-lg font-medium text-gray-900 mb-4">Thông tin đánh giá</h5>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <dl>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Sản phẩm</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @if($productReview->product)
                                        <a href="{{ route(app()->getLocale() . '.admin.products.edit', $productReview->product) }}" 
                                           class="text-blue-600 hover:text-blue-800">
                                            {{ $productReview->product->name }}
                                        </a>
                                    @else
                                        <div class="flex items-center text-red-600">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            Sản phẩm đã bị xóa (ID: {{ $productReview->product_id }})
                                        </div>
                                    @endif
                                </dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Người đánh giá</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $productReview->reviewer_name }}
                                </dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $productReview->reviewer_email }}
                                </dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Đánh giá</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $productReview->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $productReview->rating }}/5</span>
                                </dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50">
                                <dt class="text-sm font-medium text-gray-500">Trạng thái</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @if($productReview->is_approved)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i> Đã duyệt
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> Chờ duyệt
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Ngày tạo</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $productReview->created_at->format('d/m/Y H:i:s') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div>
                    <h5 class="text-lg font-medium text-gray-900 mb-4">Nội dung đánh giá</h5>
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <p class="text-gray-700 whitespace-pre-line">{{ $productReview->comment }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                @if(!$productReview->is_approved)
                    <form action="{{ route(app()->getLocale() . '.admin.product-reviews.approve', $productReview) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 hover:bg-green-200 rounded-md">
                            <i class="fas fa-check mr-2"></i> Duyệt đánh giá
                        </button>
                    </form>
                @else
                    <form action="{{ route(app()->getLocale() . '.admin.product-reviews.reject', $productReview) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-md">
                            <i class="fas fa-times mr-2"></i> Hủy duyệt
                        </button>
                    </form>
                @endif
                <form action="{{ route(app()->getLocale() . '.admin.product-reviews.destroy', $productReview) }}" 
                      method="POST"
                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 hover:bg-red-200 rounded-md">
                        <i class="fas fa-trash mr-2"></i> Xóa đánh giá
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 