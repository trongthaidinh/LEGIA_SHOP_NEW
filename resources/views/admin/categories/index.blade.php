@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-folder mr-2"></i> Quản lý danh mục sản phẩm
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.categories.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                        <i class="fas fa-plus mr-2 text-[var(--color-primary-500)]"></i> Thêm danh mục
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="p-6 border-b border-[var(--color-primary-100)]">
            <div class="flex flex-wrap gap-4">
                <!-- Parent Category Filter -->
                <div class="flex-1 min-w-[200px]">
                    <select id="parent-filter" class="w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories->where('parent_id', null) as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="flex-1 min-w-[200px]">
                    <select id="status-filter" class="w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                        <option value="">Tất cả trạng thái</option>
                        <option value="1">Đang hoạt động</option>
                        <option value="0">Đã ẩn</option>
                    </select>
                </div>

                <!-- Search -->
                <div class="flex-1 min-w-[300px]">
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               placeholder="Tìm kiếm danh mục..." 
                               class="w-full pl-10 pr-4 py-2 rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-[var(--color-primary-400)]"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="p-4">
            <div class="bg-[var(--color-primary-50)] border border-[var(--color-primary-200)] rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-[var(--color-primary-500)]"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-[var(--color-primary-700)]">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Categories Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-primary-100)]">
                <thead class="bg-[var(--color-primary-50)]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Tên danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Danh mục cha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Số sản phẩm</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Ngày tạo</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-[var(--color-primary-100)]">
                    @foreach($categories as $category)
                    <tr class="hover:bg-[var(--color-primary-50)] transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-[var(--color-primary-900)]">{{ $category->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--color-primary-600)]">
                            {{ $category->parent ? $category->parent->name : 'Không có' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--color-primary-600)]">
                            {{ $category->products_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-[var(--color-primary-100)] text-[var(--color-primary-700)]' : 'bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)]' }}">
                                {{ $category->is_active ? 'Đang hoạt động' : 'Đã ẩn' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--color-primary-600)]">
                            {{ $category->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route(app()->getLocale() . '.admin.categories.edit', $category) }}" 
                               class="text-[var(--color-primary-600)] hover:text-[var(--color-primary-800)] mr-3 transition-colors duration-200">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route(app()->getLocale() . '.admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  class="inline-block"
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[var(--color-secondary-600)] hover:text-[var(--color-secondary-800)] transition-colors duration-200">
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
        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-[var(--color-primary-100)]">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle parent category filter change
    $('#parent-filter').change(function() {
        const parent = $(this).val();
        // Add your filter logic here
    });

    // Handle status filter change
    $('#status-filter').change(function() {
        const status = $(this).val();
        // Add your filter logic here
    });

    // Handle search input
    let searchTimeout;
    $('#search').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const search = $(this).val();
            // Add your search logic here
        }, 500);
    });
});
</script>
@endpush
@endsection