@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
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
                    <label for="name" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                        Tên sản phẩm <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $product->name) }}" 
                           required
                           class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('name') border-[var(--color-secondary-500)] @enderror">
                    @error('name')
                    <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                        Mã sản phẩm (SKU) <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           name="sku" 
                           id="sku" 
                           value="{{ old('sku', $product->sku) }}" 
                           required
                           class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('sku') border-[var(--color-secondary-500)] @enderror">
                    @error('sku')
                    <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                    Danh mục <span class="text-[var(--color-secondary-600)]">*</span>
                </label>
                <select name="category_id" 
                        id="category_id"
                        required
                        class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('category_id') border-[var(--color-secondary-500)] @enderror">
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                    Loại sản phẩm <span class="text-[var(--color-secondary-600)]">*</span>
                </label>
                <select name="type" 
                        id="type"
                        required
                        class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('type') border-[var(--color-secondary-500)] @enderror">
                    <option value="">Chọn loại sản phẩm</option>
                    @foreach($types as $key => $label)
                    <option value="{{ $key }}" {{ old('type', $product->type) == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
                @error('type')
                <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                    Số lượng trong kho <span class="text-[var(--color-secondary-600)]">*</span>
                </label>
                <input type="number" 
                       name="stock" 
                       id="stock" 
                       value="{{ old('stock', $product->stock) }}" 
                       required
                       min="0"
                       class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('stock') border-[var(--color-secondary-500)] @enderror">
                @error('stock')
                <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                    Mô tả sản phẩm
                </label>
                <textarea 
                    name="description" 
                    id="description"
                    rows="5"
                    class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50"
                >{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                    Nội dung sản phẩm
                </label>
                <textarea 
                    name="content" 
                    id="content"
                    rows="5"
                    class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50"
                >{{ old('content', $product->content) }}</textarea>
            </div>

            <!-- Pricing -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Regular Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                        Giá gốc <span class="text-[var(--color-secondary-600)]">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               name="price" 
                               id="price" 
                               value="{{ old('price', $product->price) }}" 
                               required
                               min="0"
                               step="1000"
                               class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('price') border-[var(--color-secondary-500)] @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            @if(request()->segment(1) == 'vi')
                                <span class="text-[var(--color-primary-500)]">đ</span>
                            @else
                                <span class="text-[var(--color-primary-500)]">¥</span>
                            @endif
                        </div>
                    </div>
                    @error('price')
                    <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sale Price -->
                <div>
                    <label for="sale_price" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                        Giá bán (đã giảm giá)
                    </label>
                    <div class="relative">
                        <input type="number" 
                               name="sale_price" 
                               id="sale_price" 
                               value="{{ old('sale_price', $product->sale_price) }}"
                               min="0"
                               step="1000"
                               class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('sale_price') border-[var(--color-secondary-500)] @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            @if(request()->segment(1) == 'vi')
                                <span class="text-[var(--color-primary-500)]">đ</span>
                            @else
                                <span class="text-[var(--color-primary-500)]">¥</span>
                            @endif
                        </div>
                    </div>
                    @error('sale_price')
                    <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Featured Image -->
            <div>
                <label class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
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

            <!-- Status -->
            <div class="flex items-center space-x-4">
                <label for="is_active" class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1"
                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                           class="rounded border-[var(--color-primary-300)] text-[var(--color-primary-600)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-[var(--color-primary-700)]">Kích hoạt sản phẩm</span>
                </label>
            </div>

            <!-- Hidden Language Field -->
            <input type="hidden" name="language" value="{{ request()->segment(1) }}">

            <!-- Hidden Status Field -->
            <input type="hidden" name="status" value="published">

            <!-- Submit Button -->
            <div class="flex justify-end pt-6 border-t border-[var(--color-primary-100)]">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-500)] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[var(--color-primary-600)] active:bg-[var(--color-primary-700)] focus:outline-none focus:border-[var(--color-primary-700)] focus:ring ring-[var(--color-primary-300)] disabled:opacity-25 transition">
                    <i class="fas fa-save mr-2"></i> Lưu sản phẩm
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

document.addEventListener('DOMContentLoaded', function() {
    // Initialize TinyMCE for both editors
    initTinyMCE('#content');

    // ... rest of your existing script
});
</script>
@endpush
@endsection 