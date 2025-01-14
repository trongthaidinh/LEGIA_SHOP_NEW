@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Header -->
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-edit mr-2"></i> Chỉnh sửa sản phẩm
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.products.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route(app()->getLocale() . '.admin.products.update', $product) }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên sản phẩm <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $product->name) }}" 
                           required
                           class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('name') border-red-300 @enderror">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                        Mã sản phẩm (SKU) <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           name="sku" 
                           id="sku" 
                           value="{{ old('sku', $product->sku) }}" 
                           required
                           class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('sku') border-red-300 @enderror">
                    @error('sku')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Danh mục <span class="text-red-600">*</span>
                </label>
                <select name="category_id" 
                        id="category_id"
                        required
                        class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('category_id') border-red-300 @enderror">
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Mô tả sản phẩm
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="5"
                          class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('description') border-red-300 @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pricing -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Regular Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Giá bán <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               name="price" 
                               id="price" 
                               value="{{ old('price', $product->price) }}" 
                               required
                               min="0"
                               step="1000"
                               class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('price') border-red-300 @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">đ</span>
                        </div>
                    </div>
                    @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Compare Price -->
                <div>
                    <label for="compare_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Giá gốc
                    </label>
                    <div class="relative">
                        <input type="number" 
                               name="compare_price" 
                               id="compare_price" 
                               value="{{ old('compare_price', $product->compare_price) }}"
                               min="0"
                               step="1000"
                               class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('compare_price') border-red-300 @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">đ</span>
                        </div>
                    </div>
                    @error('compare_price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Featured Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Ảnh đại diện
                </label>
                <div class="mt-1 flex items-center space-x-4">
                    <div class="flex-shrink-0 h-32 w-32 border-2 border-gray-300 border-dashed rounded-lg flex items-center justify-center">
                        @if($product->featured_image)
                            <img id="featured-preview" 
                                 src="{{ asset('storage/' . $product->featured_image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="h-full w-full object-cover rounded-lg">
                            <div id="featured-placeholder" class="text-gray-400 hidden">
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        @else
                            <img id="featured-preview" src="#" alt="" class="h-full w-full object-cover rounded-lg hidden">
                            <div id="featured-placeholder" class="text-gray-400">
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" 
                               name="featured_image" 
                               id="featured_image"
                               accept="image/*"
                               class="sr-only"
                               onchange="previewFeaturedImage(this)">
                        <label for="featured_image" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer">
                            <i class="fas fa-upload mr-2"></i>
                            {{ $product->featured_image ? 'Thay đổi ảnh' : 'Chọn ảnh đại diện' }}
                        </label>
                        @if($product->featured_image)
                            <button type="button" 
                                    onclick="removeFeaturedImage()"
                                    class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <i class="fas fa-trash-alt mr-2"></i>
                                Xóa ảnh
                            </button>
                        @endif
                        <p class="mt-2 text-sm text-gray-500">PNG, JPG, GIF tối đa 2MB</p>
                    </div>
                </div>
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gallery Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Thư viện ảnh
                </label>
                <div class="mt-1">
                    <div class="flex items-center space-x-4 mb-4">
                        <input type="file" 
                               name="gallery[]" 
                               id="gallery"
                               accept="image/*"
                               multiple
                               class="sr-only"
                               onchange="previewGalleryImages(this)">
                        <label for="gallery" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer">
                            <i class="fas fa-images mr-2"></i>
                            Thêm ảnh mới
                        </label>
                        <p class="text-sm text-gray-500">PNG, JPG, GIF tối đa 2MB mỗi ảnh</p>
                    </div>
                    
                    <div id="gallery-preview" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @if($product->gallery)
                            @foreach(json_decode($product->gallery) as $index => $image)
                            <div class="relative aspect-w-1 aspect-h-1">
                                <div class="group relative h-32 w-full border-2 border-gray-300 rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         alt="Gallery image {{ $index + 1 }}" 
                                         class="h-full w-full object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <button type="button" 
                                                onclick="removeGalleryImage(this)" 
                                                class="text-white hover:text-red-500 transition-colors">
                                            <i class="fas fa-trash-alt fa-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="existing_gallery[]" value="{{ $image }}">
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @error('gallery')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('gallery.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="flex items-center space-x-4">
                <label for="is_active" class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1"
                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Đang bán</span>
                </label>

                <label for="is_featured" class="flex items-center">
                    <input type="checkbox" 
                           name="is_featured" 
                           id="is_featured" 
                           value="1"
                           {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Sản phẩm nổi bật</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-6">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition">
                    <i class="fas fa-save mr-2"></i> Cập nhật sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewFeaturedImage(input) {
    const preview = document.getElementById('featured-preview');
    const placeholder = document.getElementById('featured-placeholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeFeaturedImage() {
    const preview = document.getElementById('featured-preview');
    const placeholder = document.getElementById('featured-placeholder');
    const input = document.getElementById('featured_image');
    
    preview.src = '#';
    preview.classList.add('hidden');
    placeholder.classList.remove('hidden');
    input.value = '';
    
    // Add a hidden input to mark the image for deletion
    const deleteInput = document.createElement('input');
    deleteInput.type = 'hidden';
    deleteInput.name = 'delete_featured_image';
    deleteInput.value = '1';
    input.parentNode.appendChild(deleteInput);
}

function previewGalleryImages(input) {
    const galleryPreview = document.getElementById('gallery-preview');
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewContainer = document.createElement('div');
                    previewContainer.className = 'relative aspect-w-1 aspect-h-1';
                    previewContainer.innerHTML = `
                        <div class="group relative h-32 w-full border-2 border-gray-300 rounded-lg overflow-hidden">
                            <img src="${e.target.result}" alt="Gallery preview ${index + 1}" class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" 
                                        onclick="removeGalleryImage(this)" 
                                        class="text-white hover:text-red-500 transition-colors">
                                    <i class="fas fa-trash-alt fa-lg"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    galleryPreview.appendChild(previewContainer);
                }
                reader.readAsDataURL(file);
            }
        });
    }
}

function removeGalleryImage(button) {
    const container = button.closest('.relative');
    const hiddenInput = container.querySelector('input[type="hidden"]');
    
    if (hiddenInput && hiddenInput.name === 'existing_gallery[]') {
        // If this is an existing image, mark it for deletion
        const deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = 'delete_gallery[]';
        deleteInput.value = hiddenInput.value;
        container.parentNode.appendChild(deleteInput);
    }
    
    container.remove();
}
</script>
@endpush
@endsection 