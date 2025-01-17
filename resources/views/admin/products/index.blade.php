@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-box mr-2"></i> Quản lý sản phẩm
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.products.create') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                        <i class="fas fa-plus mr-2 text-[var(--color-primary-500)]"></i> Thêm sản phẩm mới
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="p-6 border-b border-[var(--color-primary-100)]">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">Danh mục</label>
                    <select name="category" 
                            id="category" 
                            class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">Trạng thái</label>
                    <select name="status" 
                            id="status" 
                            class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50">
                        <option value="">Tất cả trạng thái</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang bán</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Ngừng bán</option>
                    </select>
                </div>

                <!-- Search -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">Tìm kiếm</label>
                    <div class="relative">
                        <input type="text" 
                               name="search"
                               id="search" 
                               value="{{ request('search') }}"
                               placeholder="Tìm theo tên, mã sản phẩm..."
                               class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-[var(--color-primary-400)]"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-primary-100)]">
                <thead class="bg-[var(--color-primary-50)]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Sản phẩm</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Giá</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-[var(--color-primary-100)]">
                    @foreach($products as $product)
                    <tr class="hover:bg-[var(--color-primary-50)] transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($product->featured_image)
                                <img src="{{ asset('storage/' . $product->featured_image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="h-12 w-12 object-cover rounded-md">
                                @else
                                <div class="h-12 w-12 rounded-md bg-[var(--color-primary-100)] flex items-center justify-center">
                                    <i class="fas fa-image text-[var(--color-primary-400)]"></i>
                                </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-[var(--color-primary-900)]">{{ $product->name }}</div>
                                    <div class="text-sm text-[var(--color-primary-500)]">SKU: {{ $product->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-[var(--color-primary-900)]">
                                {{ optional($product->category)->name ?? 'Không có danh mục' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->sale_price > 0)
                            <div class="text-sm text-[var(--color-primary-900)]">{{ number_format($product->sale_price) }}đ</div>
                            @endif
                            <div class="text-sm @if($product->sale_price > 0) line-through text-[var(--color-primary-500)] @endif">{{ number_format($product->price) }}đ</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-[var(--color-primary-100)] text-[var(--color-primary-700)]' : 'bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)]' }}">
                                {{ $product->is_active ? 'Đang bán' : 'Ngừng bán' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route(app()->getLocale() . '.admin.products.edit', $product) }}" 
                               class="inline-block px-3 py-1 mr-2 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] rounded-lg hover:bg-[var(--color-primary-200)] transition-colors duration-200"
                               title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route(app()->getLocale() . '.admin.products.destroy', $product) }}" 
                                  method="POST" 
                                  class="inline-block delete-form" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200"
                                        title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-[var(--color-primary-100)]">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-submit form when filters change
    $('#category, #status').change(function() {
        $(this).closest('form').submit();
    });

    // Handle search with debounce
    let searchTimeout;
    $('#search').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            $(this).closest('form').submit();
        }, 500);
    });
});
</script>
@endpush
@endsection