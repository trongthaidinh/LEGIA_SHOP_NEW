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

            <!-- Hidden fields for default values -->
            <input type="hidden" name="parent_id" value="{{ $category->parent_id }}">
            <input type="hidden" name="status" value="published">

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