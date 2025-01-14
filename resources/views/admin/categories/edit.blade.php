@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-edit mr-2"></i> Chỉnh sửa danh mục sản phẩm
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.categories.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2 text-[var(--color-primary-500)]"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route(app()->getLocale() . '.admin.categories.update', $category) }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                    Tên danh mục <span class="text-[var(--color-secondary-600)]">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $category->name) }}" 
                       required
                       class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('name') border-[var(--color-secondary-500)] @enderror">
                @error('name')
                <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parent Category -->
            <div>
                <label for="parent_id" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                    Danh mục cha
                </label>
                <select name="parent_id" 
                        id="parent_id"
                        class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('parent_id') border-[var(--color-secondary-500)] @enderror">
                    <option value="">Không có</option>
                    @foreach($categories as $parent)
                        @if($parent->id !== $category->id)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                        @endif
                    @endforeach
                </select>
                @error('parent_id')
                <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                    Mô tả
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="3"
                          class="w-full rounded-md shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('description') border-[var(--color-secondary-500)] @enderror">{{ old('description', $category->description) }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div>
                <label class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                    Ảnh danh mục
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-[var(--color-primary-300)] border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        @if($category->image)
                        <div id="current-image" class="mb-4">
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 class="mx-auto h-32 w-auto">
                            <p class="mt-2 text-sm text-[var(--color-primary-500)]">Ảnh hiện tại</p>
                        </div>
                        @endif
                        <div class="flex flex-col items-center">
                            <i class="fas fa-image text-[var(--color-primary-400)] text-3xl mb-3"></i>
                            <div class="flex text-sm text-[var(--color-primary-600)]">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-[var(--color-primary-600)] hover:text-[var(--color-primary-700)] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[var(--color-primary-500)]">
                                    <span>Tải ảnh mới</span>
                                    <input id="image" 
                                           name="image" 
                                           type="file" 
                                           accept="image/*"
                                           class="sr-only">
                                </label>
                                <p class="pl-1">hoặc kéo thả vào đây</p>
                            </div>
                            <p class="text-xs text-[var(--color-primary-500)]">PNG, JPG, GIF tối đa 2MB</p>
                        </div>
                        <div id="image-preview" class="hidden mt-4">
                            <img src="#" alt="Preview" class="mx-auto h-32 w-auto">
                            <p class="mt-2 text-sm text-[var(--color-primary-500)]">Ảnh mới</p>
                        </div>
                    </div>
                </div>
                @error('image')
                <p class="mt-1 text-sm text-[var(--color-secondary-600)]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="is_active" class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1"
                           {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                           class="rounded border-[var(--color-primary-300)] text-[var(--color-primary-500)] shadow-sm focus:border-[var(--color-primary-300)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-[var(--color-primary-700)]">Kích hoạt</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-6">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-500)] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[var(--color-primary-600)] active:bg-[var(--color-primary-700)] focus:outline-none focus:border-[var(--color-primary-700)] focus:ring ring-[var(--color-primary-300)] disabled:opacity-25 transition">
                    <i class="fas fa-save mr-2"></i> Cập nhật danh mục
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle image preview
    $('#image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#current-image').addClass('hidden');
                $('#image-preview').removeClass('hidden').find('img').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
@endsection