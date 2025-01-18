@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-star mr-2"></i> Đánh giá sản phẩm
                </h3>
                <div class="flex space-x-2">
                    <a href="{{ route(app()->getLocale() . '.admin.product-reviews.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                        Tất cả 
                        <span class="ml-2 px-2 py-0.5 text-xs bg-[var(--color-primary-100)] text-[var(--color-primary-700)] rounded-full">
                            {{ $reviews->total() }}
                        </span>
                    </a>
                    <button type="button" id="filterPending"
                            class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                        Chờ duyệt 
                        <span class="ml-2 px-2 py-0.5 text-xs bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)] rounded-full">
                            {{ $reviews->where('is_approved', false)->count() }}
                        </span>
                    </button>
                    <button type="button" id="filterApproved"
                            class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                        Đã duyệt 
                        <span class="ml-2 px-2 py-0.5 text-xs bg-[var(--color-primary-100)] text-[var(--color-primary-700)] rounded-full">
                            {{ $reviews->where('is_approved', true)->count() }}
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <div>
            @if(session('success'))
                <div class="mb-4 bg-[var(--color-primary-50)] text-[var(--color-primary-700)] p-4 rounded-md flex items-center justify-between" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-[var(--color-primary-500)]"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="text-[var(--color-primary-600)] hover:text-[var(--color-primary-800)]" data-dismiss="alert">
                        <span class="text-2xl">&times;</span>
                    </button>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[var(--color-primary-100)]">
                    <thead class="bg-[var(--color-primary-50)]">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider w-48">Sản phẩm</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider w-44">Người đánh giá</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider w-32">Đánh giá</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider w-28">Trạng thái</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider w-36">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[var(--color-primary-100)]">
                        @forelse($reviews as $review)
                            <tr class="{{ $review->is_approved ? '' : 'bg-[var(--color-secondary-50)]' }} hover:bg-[var(--color-primary-50)] transition-colors duration-200">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        @if($review->product)
                                            @if($review->product->featured_image)
                                                <img src="{{ Storage::url($review->product->featured_image) }}" 
                                                     alt="{{ $review->product->name }}" 
                                                     class="h-12 w-12 rounded-md object-cover mr-3">
                                            @endif
                                            <div class="text-sm">
                                                <div class="font-medium text-[var(--color-primary-900)]">{{ $review->product->name }}</div>
                                                <div class="text-[var(--color-primary-500)]">SKU: {{ $review->product->sku }}</div>
                                            </div>
                                        @else
                                            <div class="flex items-center">
                                                <div class="h-12 w-12 bg-[var(--color-secondary-100)] rounded-md flex items-center justify-center mr-3">
                                                    <i class="fas fa-exclamation-triangle text-[var(--color-secondary-400)] text-2xl"></i>
                                                </div>
                                                <div class="text-sm">
                                                    <div class="font-medium text-[var(--color-secondary-600)]">Sản phẩm đã bị xóa</div>
                                                    <div class="text-[var(--color-primary-500)]">ID: {{ $review->product_id }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm">
                                        <div class="text-[var(--color-primary-900)] flex items-center">
                                            <i class="fas fa-user text-[var(--color-primary-400)] mr-1.5"></i>
                                            {{ $review->reviewer_name }}
                                        </div>
                                        <div class="text-[var(--color-primary-500)] flex items-center">
                                            <i class="fas fa-envelope text-[var(--color-primary-400)] mr-1.5"></i>
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
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[var(--color-primary-100)] text-[var(--color-primary-700)]">
                                            <i class="fas fa-check mr-1"></i> Đã duyệt
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)]">
                                            <i class="fas fa-clock mr-1"></i> Chờ duyệt
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm font-medium">
                                    <div class="flex space-x-1">
                                        <a href="{{ route(app()->getLocale() . '.admin.product-reviews.show', $review) }}" 
                                           class="inline-flex items-center p-1.5 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] hover:bg-[var(--color-primary-200)] rounded-md transition-colors duration-200"
                                           title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(!$review->is_approved)
                                            <form action="{{ route(app()->getLocale() . '.admin.product-reviews.approve', $review) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="inline-flex items-center p-1.5 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] hover:bg-[var(--color-primary-200)] rounded-md transition-colors duration-200"
                                                        title="Duyệt đánh giá">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route(app()->getLocale() . '.admin.product-reviews.reject', $review) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="inline-flex items-center p-1.5 bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)] hover:bg-[var(--color-secondary-200)] rounded-md transition-colors duration-200"
                                                        title="Bỏ duyệt">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-sm text-[var(--color-primary-500)]">
                                    Không có đánh giá nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reviews->hasPages())
            <div class="px-6 py-4 border-t border-[var(--color-primary-100)]">
                {{ $reviews->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Filtering logic
    $('#filterPending').on('click', function() {
        window.location.href = "{{ route(app()->getLocale() . '.admin.product-reviews.index') }}?status=pending";
    });

    $('#filterApproved').on('click', function() {
        window.location.href = "{{ route(app()->getLocale() . '.admin.product-reviews.index') }}?status=approved";
    });
});
</script>
@endpush
@endsection