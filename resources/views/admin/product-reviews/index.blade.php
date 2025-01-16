@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-star mr-2"></i> Đánh giá sản phẩm
                </h3>
                <div class="flex space-x-2">
                    <a href="{{ route(app()->getLocale() . '.admin.product-reviews.index') }}" 
                       class="inline-flex items-center px-3 py-1.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        Tất cả 
                        <span class="ml-2 px-2 py-0.5 text-xs bg-blue-100 text-blue-600 rounded-full">
                            {{ $reviews->total() }}
                        </span>
                    </a>
                    <button type="button" id="filterPending"
                            class="inline-flex items-center px-3 py-1.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        Chờ duyệt 
                        <span class="ml-2 px-2 py-0.5 text-xs bg-yellow-100 text-yellow-600 rounded-full">
                            {{ $reviews->where('is_approved', false)->count() }}
                        </span>
                    </button>
                    <button type="button" id="filterApproved"
                            class="inline-flex items-center px-3 py-1.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        Đã duyệt 
                        <span class="ml-2 px-2 py-0.5 text-xs bg-green-100 text-green-600 rounded-full">
                            {{ $reviews->where('is_approved', true)->count() }}
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-50 text-green-700 p-4 rounded-md flex items-center justify-between" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="text-green-600 hover:text-green-800" data-dismiss="alert">
                        <span class="text-2xl">&times;</span>
                    </button>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Sản phẩm</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-44">Người đánh giá</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Đánh giá</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Trạng thái</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reviews as $review)
                            <tr class="{{ $review->is_approved ? '' : 'bg-yellow-50' }} hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        @if($review->product)
                                            @if($review->product->featured_image)
                                                <img src="{{ Storage::url($review->product->featured_image) }}" 
                                                     alt="{{ $review->product->name }}" 
                                                     class="h-12 w-12 rounded-md object-cover mr-3">
                                            @endif
                                            <div class="text-sm">
                                                <div class="font-medium text-gray-900">{{ $review->product->name }}</div>
                                                <div class="text-gray-500">SKU: {{ $review->product->sku }}</div>
                                            </div>
                                        @else
                                            <div class="flex items-center">
                                                <div class="h-12 w-12 bg-red-100 rounded-md flex items-center justify-center mr-3">
                                                    <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                                                </div>
                                                <div class="text-sm">
                                                    <div class="font-medium text-red-600">Sản phẩm đã bị xóa</div>
                                                    <div class="text-gray-500">ID: {{ $review->product_id }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm">
                                        <div class="text-gray-900 flex items-center">
                                            <i class="fas fa-user text-gray-400 mr-1.5"></i>
                                            {{ $review->reviewer_name }}
                                        </div>
                                        <div class="text-gray-500 flex items-center">
                                            <i class="fas fa-envelope text-gray-400 mr-1.5"></i>
                                            {{ $review->reviewer_email }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($review->is_approved)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i> Đã duyệt
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> Chờ duyệt
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm font-medium">
                                    <div class="flex space-x-1">
                                        <a href="{{ route(app()->getLocale() . '.admin.product-reviews.show', $review) }}" 
                                           class="inline-flex items-center p-1.5 bg-blue-100 text-blue-600 hover:bg-blue-200 rounded-md"
                                           title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(!$review->is_approved)
                                            <form action="{{ route(app()->getLocale() . '.admin.product-reviews.approve', $review) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="inline-flex items-center p-1.5 bg-green-100 text-green-600 hover:bg-green-200 rounded-md"
                                                        title="Duyệt đánh giá">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route(app()->getLocale() . '.admin.product-reviews.reject', $review) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="inline-flex items-center p-1.5 bg-yellow-100 text-yellow-600 hover:bg-yellow-200 rounded-md"
                                                        title="Hủy duyệt">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route(app()->getLocale() . '.admin.product-reviews.destroy', $review) }}" 
                                              method="POST"
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center p-1.5 bg-red-100 text-red-600 hover:bg-red-200 rounded-md"
                                                    title="Xóa đánh giá">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8">
                                    <div class="text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-3"></i>
                                        <p>Chưa có đánh giá nào</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Filter buttons functionality
    $('#filterAll').click(function() {
        window.location.href = "{{ route(app()->getLocale() . '.admin.product-reviews.index') }}";
    });
    
    $('#filterPending').click(function() {
        $('.table tbody tr').hide();
        $('.table tbody tr:has(.bg-yellow-100)').show();
    });
    
    $('#filterApproved').click(function() {
        $('.table tbody tr').hide();
        $('.table tbody tr:has(.bg-green-100)').show();
    });

    // Auto-hide alert after 5 seconds
    $('.alert').delay(5000).fadeOut(500);
});
</script>
@endpush
@endsection 