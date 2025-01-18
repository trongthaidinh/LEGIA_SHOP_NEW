@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i> Thêm sản phẩm mới
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.products.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2 text-[var(--color-primary-500)]"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route(app()->getLocale() . '.admin.products.store') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="p-6 space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                        Tên sản phẩm <span class="text-[var(--color-secondary-600)]">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}" 
                           required
                           class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('name') border-[var(--color-secondary-500)] @enderror">
                    @error('name')
                    <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                        Mã sản phẩm (SKU) <span class="text-[var(--color-secondary-600)]">*</span>
                    </label>
                    <input type="text" 
                           name="sku" 
                           id="sku" 
                           value="{{ old('sku') }}" 
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
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                    @foreach(\App\Models\Product::getTypes() as $key => $value)
                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                        {{ $value }}
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
                       value="{{ old('stock', 0) }}" 
                       required
                       min="0"
                       class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('stock') border-[var(--color-secondary-500)] @enderror">
                @error('stock')
                <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                @enderror
            </div>

                <input type="hidden" name="status" value="published">

            <!-- Hidden Language Field -->
            <input type="hidden" name="language" value="{{ request()->segment(1) }}">

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">Mô tả ngắn <span class="text-[var(--color-secondary-600)]">*</span></label>
                <textarea name="description" id="description" class="tinymce">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">Nội dung chi tiết <span class="text-[var(--color-secondary-600)]">*</span></label>
                <textarea name="content" id="content" class="tinymce">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                @enderror
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
                               value="{{ old('price') }}" 
                               required
                               min="0"
                               step="1000"
                               class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('price') border-[var(--color-secondary-500)] @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-[var(--color-primary-500)]">đ</span>
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
                               value="{{ old('sale_price') }}"
                               min="0"
                               step="1000"
                               class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('sale_price') border-[var(--color-secondary-500)] @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-[var(--color-primary-500)]">đ</span>
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
                    <div class="w-32 h-32 rounded-md bg-[var(--color-primary-100)] flex items-center justify-center">
                        <i class="fas fa-image text-[var(--color-primary-400)] text-3xl"></i>
                    </div>
                    <div>
                        <label for="featured_image" class="inline-block px-3 py-2 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] rounded-md cursor-pointer hover:bg-[var(--color-primary-200)] transition-colors duration-200">
                            <input type="file" 
                                   name="featured_image" 
                                   id="featured_image" 
                                   accept="image/*"
                                   class="hidden"
                                   onchange="previewFeaturedImage(this)">
                            <span>Chọn ảnh</span>
                        </label>
                        <p class="mt-2 text-xs text-[var(--color-primary-500)]">PNG, JPG, GIF tối đa 2MB</p>
                    </div>
                </div>
                <div id="image-preview" class="hidden mt-4">
                    <img src="#" alt="Preview" class="h-32 w-auto rounded-md">
                </div>
            </div>

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
    const preview = document.getElementById('image-preview');
    const previewImg = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.classList.remove('hidden');
            previewImg.src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize TinyMCE for both editors
    initTinyMCE('#description');
    initTinyMCE('#content');
});
</script>
@endpush
@endsection