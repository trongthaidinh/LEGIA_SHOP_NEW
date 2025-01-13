@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-video mr-2"></i> Quản lý video
                </h3>
                <div class="flex space-x-2">
                    <a href="{{ route(app()->getLocale() . '.admin.videos.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg">
                        <i class="fas fa-plus mr-2"></i> Thêm video
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Filters -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="URL Youtube..."
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sắp xếp</label>
                    <select name="sort" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                        <option value="order" {{ request('sort') === 'order' ? 'selected' : '' }}>Thứ tự</option>
                    </select>
                </div>
            </div>

            <!-- Video Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($videos as $video)
                    <div class="relative group bg-white rounded-lg shadow-sm overflow-hidden">
                        <!-- Video Thumbnail -->
                        <div class="aspect-w-16 aspect-h-9">
                            <img src="{{ $video->thumbnail_url }}" 
                                 alt="Video thumbnail"
                                 class="object-cover w-full h-full">
                            
                            <!-- Play Button Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 bg-white bg-opacity-80 rounded-full flex items-center justify-center">
                                    <i class="fas fa-play text-2xl text-gray-800"></i>
                                </div>
                            </div>
                            
                            <!-- Actions Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center space-x-2">
                                <a href="{{ route(app()->getLocale() . '.admin.videos.show', $video) }}" 
                                   class="p-2 bg-blue-500 text-white rounded-full hover:bg-blue-600"
                                   title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route(app()->getLocale() . '.admin.videos.edit', $video) }}"
                                   class="p-2 bg-yellow-500 text-white rounded-full hover:bg-yellow-600"
                                   title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route(app()->getLocale() . '.admin.videos.destroy', $video) }}" 
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa video này?');">
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

                        <!-- Video Info -->
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $video->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $video->is_active ? 'Hoạt động' : 'Vô hiệu' }}
                                </span>
                                <form action="{{ route(app()->getLocale() . '.admin.videos.toggle', $video) }}"
                                      method="POST"
                                      class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="text-sm text-gray-500 hover:text-gray-700">
                                        {{ $video->is_active ? 'Vô hiệu hóa' : 'Kích hoạt' }}
                                    </button>
                                </form>
                            </div>
                            <p class="text-sm text-gray-500 break-all">
                                {{ $video->youtube_url }}
                            </p>
                            <div class="mt-2 text-xs text-gray-400">
                                Thứ tự: {{ $video->order }} | Ngày tạo: {{ $video->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <i class="fas fa-video text-gray-400 text-5xl mb-4"></i>
                            <p class="text-gray-500">Chưa có video nào</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $videos->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle filter changes
    $('select[name="status"], select[name="sort"]').change(function() {
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