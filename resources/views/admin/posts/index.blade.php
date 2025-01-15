@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Header -->
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-newspaper mr-2"></i> Quản lý bài viết
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.posts.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-plus mr-2"></i> Thêm bài viết
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-wrap gap-4">
                <!-- Category Filter -->
                <div class="flex-1 min-w-[200px]">
                    <select id="category-filter" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="flex-1 min-w-[200px]">
                    <select id="status-filter" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
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
                               class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
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

        <!-- Posts Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiêu đề</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($posts as $post)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-12 h-12 object-cover rounded-lg">
                                @else
                                <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $post->title }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($post->excerpt, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($post->category)
                                {{ $post->category->name }}
                            @else
                                <span class="text-red-500">Không có danh mục</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $post->is_published ? 'Đã xuất bản' : 'Bản nháp' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $post->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route(app()->getLocale() . '.admin.posts.edit', $post) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route(app()->getLocale() . '.admin.posts.destroy', $post) }}" 
                                  method="POST" 
                                  class="inline-block"
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
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
        @if($posts->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $posts->links() }}
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