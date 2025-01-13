@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-image mr-2"></i> Chi tiết hình ảnh
                </h3>
                <div class="flex space-x-2">
                    <a href="{{ route(app()->getLocale() . '.admin.images.edit', $image) }}" 
                       class="inline-flex items-center px-3 py-2 bg-yellow-500 text-sm font-medium text-white hover:bg-yellow-600 rounded-md">
                        <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                    </a>
                    <a href="{{ route(app()->getLocale() . '.admin.images.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Image Preview -->
            <div class="mb-8">
                <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-100">
                    <img src="{{ $image->url }}" 
                         alt="{{ $image->name }}" 
                         class="object-contain">
                </div>
            </div>

            <!-- Image Details -->
            <div class="bg-gray-50 rounded-lg p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tên file</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $image->name }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Kích thước</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $image->formatted_size }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Phạm vi</dt>
                        <dd class="mt-1">
                            @if($image->visibility === 'public')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-globe-asia mr-1"></i> Công khai
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-lock mr-1"></i> Riêng tư
                                </span>
                            @endif
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Ngày tạo</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $image->created_at->format('d/m/Y H:i:s') }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Ngày cập nhật</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $image->updated_at->format('d/m/Y H:i:s') }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">URL</dt>
                        <dd class="mt-1 text-sm text-gray-900 break-all">
                            <div class="flex items-center space-x-2">
                                <span class="flex-1">{{ $image->url }}</span>
                                <button onclick="copyToClipboard('{{ $image->url }}')"
                                        class="inline-flex items-center p-1.5 border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-copy text-gray-400"></i>
                                </button>
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Delete Button -->
            <div class="mt-6 flex justify-end">
                <form action="{{ route(app()->getLocale() . '.admin.images.destroy', $image) }}" 
                      method="POST" 
                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa hình ảnh này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring ring-red-300 disabled:opacity-25 transition">
                        <i class="fas fa-trash-alt mr-2"></i> Xóa hình ảnh
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // You could add a toast notification here
        alert('Đã sao chép URL vào clipboard!');
    }).catch(function(err) {
        console.error('Không thể sao chép: ', err);
    });
}
</script>
@endpush
@endsection 