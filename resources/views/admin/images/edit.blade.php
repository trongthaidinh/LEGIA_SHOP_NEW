@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-images mr-2"></i> Chỉnh sửa hình ảnh
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.images.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route(app()->getLocale() . '.admin.images.update', $image) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Current Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hình ảnh hiện tại
                    </label>
                    <div class="mt-1 relative">
                        <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-100">
                            <img src="{{ $image->url }}" 
                                 alt="{{ $image->name }}" 
                                 class="object-cover">
                        </div>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-gray-900">{{ $image->name }}</p>
                            <p class="text-sm text-gray-500">{{ $image->formatted_size }}</p>
                        </div>
                    </div>
                </div>

                <!-- New Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tải lên hình ảnh mới
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Tải lên hình ảnh</span>
                                    <input id="image" 
                                           name="image" 
                                           type="file" 
                                           class="sr-only"
                                           accept="image/*">
                                </label>
                                <p class="pl-1">hoặc kéo thả vào đây</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, GIF tối đa 2MB
                            </p>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preview -->
                <div id="imagePreview" class="hidden">
                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-100">
                        <img id="preview" src="#" alt="Preview" class="object-cover">
                    </div>
                </div>

                <!-- Visibility -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Phạm vi
                    </label>
                    <select name="visibility" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="public" {{ $image->visibility === 'public' ? 'selected' : '' }}>Công khai</option>
                        <option value="private" {{ $image->visibility === 'private' ? 'selected' : '' }}>Riêng tư</option>
                    </select>
                    @error('visibility')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition">
                        <i class="fas fa-save mr-2"></i> Cập nhật hình ảnh
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle file input change
    $('#image').change(function() {
        const preview = $('#imagePreview');
        const previewImg = $('#preview');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.attr('src', e.target.result);
                preview.removeClass('hidden');
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Handle drag and drop
    const dropZone = $('.border-dashed');
    
    dropZone.on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('border-blue-500');
    });
    
    dropZone.on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('border-blue-500');
    });
    
    dropZone.on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('border-blue-500');
        
        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            $('#image')[0].files = files;
            $('#image').trigger('change');
        }
    });
});
</script>
@endpush
@endsection 