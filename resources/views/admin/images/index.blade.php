@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-images mr-2"></i> Quản lý hình ảnh
                </h3>
                <div class="flex space-x-2">
                    <a href="{{ route(app()->getLocale() . '.admin.images.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg">
                        <i class="fas fa-plus mr-2"></i> Thêm hình ảnh
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Filters -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Tên file..."
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                    <select name="status" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">Tất cả</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Đã vô hiệu</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phạm vi</label>
                    <select name="visibility" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">Tất cả</option>
                        <option value="public" {{ request('visibility') === 'public' ? 'selected' : '' }}>Công khai</option>
                        <option value="private" {{ request('visibility') === 'private' ? 'selected' : '' }}>Riêng tư</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sắp xếp</label>
                    <select name="sort" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                        <option value="file_name" {{ request('sort') === 'file_name' ? 'selected' : '' }}>Tên file</option>
                        <option value="file_size" {{ request('sort') === 'file_size' ? 'selected' : '' }}>Kích thước</option>
                        <option value="order" {{ request('sort') === 'order' ? 'selected' : '' }}>Thứ tự</option>
                    </select>
                </div>
            </div>

            <!-- Image Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @forelse($images as $image)
                    <div class="relative group">
                        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200">
                            <img src="{{ $image->full_url }}" 
                                 alt="{{ $image->file_name }}"
                                 class="object-cover w-full h-full">
                            
                            <!-- Overlay with actions -->
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center space-x-2">
                                <a href="{{ route(app()->getLocale() . '.admin.images.show', $image) }}" 
                                   class="p-2 bg-blue-500 text-white rounded-full hover:bg-blue-600"
                                   title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route(app()->getLocale() . '.admin.images.edit', $image) }}"
                                   class="p-2 bg-yellow-500 text-white rounded-full hover:bg-yellow-600"
                                   title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route(app()->getLocale() . '.admin.images.destroy', $image) }}" 
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa hình ảnh này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600"
                                            title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Image Info -->
                        <div class="mt-2">
                            <p class="text-sm font-medium text-gray-900 truncate" title="{{ $image->file_name }}">
                                {{ $image->file_name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $image->human_file_size }}
                            </p>
                            <div class="flex items-center mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $image->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $image->is_active ? 'Hoạt động' : 'Vô hiệu' }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ml-2 {{ $image->visibility === 'public' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $image->visibility === 'public' ? 'Công khai' : 'Riêng tư' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <i class="fas fa-images text-gray-400 text-5xl mb-4"></i>
                            <p class="text-gray-500">Chưa có hình ảnh nào</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $images->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle filter changes
    $('select[name="status"], select[name="visibility"], select[name="sort"]').change(function() {
        $(this).closest('form').submit();
    });

    // Handle search input
    let timeout = null;
    $('input[name="search"]').keyup(function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            $(this).closest('form').submit();
        }, 500);
    });
});
</script>
@endpush
@endsection 