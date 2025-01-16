@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-newspaper mr-2"></i> Quản lý bài viết
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.posts.create') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md">
                        <i class="fas fa-plus mr-2"></i> Thêm bài viết
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="p-4">
            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Filters -->
        <div class="p-6 border-b border-[var(--color-primary-100)]">
            <div class="flex flex-wrap gap-4">
                <!-- Category Filter -->
                <div class="flex-1 min-w-[200px]">
                    <select id="category-filter" class="w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="flex-1 min-w-[200px]">
                    <select id="status-filter" class="w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                        <option value="">Tất cả trạng thái</option>
                        <option value="1">Đã xuất bản</option>
                        <option value="0">Bản nháp</option>
                    </select>
                </div>

                <!-- Search -->
                <div class="flex-1 min-w-[300px]">
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               placeholder="Tìm kiếm bài viết..." 
                               class="w-full pl-10 pr-4 py-2 rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-[var(--color-primary-400)]"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-primary-200)]">
                <thead class="bg-[var(--color-primary-50)]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-500)] uppercase tracking-wider">Tiêu đề</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-500)] uppercase tracking-wider">Danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-500)] uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-[var(--color-primary-500)] uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-[var(--color-primary-200)]">
                    @foreach($posts as $post)
                    <tr class="hover:bg-[var(--color-primary-50)]">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-md object-cover" 
                                         src="{{ Storage::url($post->featured_image) }}" 
                                         alt="{{ $post->title }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-[var(--color-primary-900)]">
                                        {{ $post->title }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-[var(--color-primary-500)]">
                                {{ $post->category ? $post->category->name : 'Không có danh mục' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $post->is_published ? 'Đã xuất bản' : 'Bản nháp' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route(app()->getLocale() . '.admin.posts.edit', $post) }}" 
                                   class="inline-flex items-center justify-center w-9 h-9 bg-[var(--color-primary-100)] text-[var(--color-primary-600)] hover:bg-[var(--color-primary-200)] rounded-md">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route(app()->getLocale() . '.admin.posts.destroy', $post) }}" 
                                      method="POST"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center w-9 h-9 bg-[var(--color-secondary-100)] text-[var(--color-secondary-600)] hover:bg-[var(--color-secondary-200)] rounded-md">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="bg-white px-4 py-3 border-t border-[var(--color-primary-200)] sm:px-6">
            {{ $posts->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle category filter change
    $('#category-filter').change(function() {
        const category = $(this).val();
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