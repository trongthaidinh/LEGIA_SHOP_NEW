@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-plus mr-2"></i> Thêm slider mới
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.sliders.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route(app()->getLocale() . '.admin.sliders.store') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề</label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                    <textarea name="description" 
                              id="description" 
                              rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Hình ảnh</label>
                    <input type="file" 
                           name="image" 
                           id="image"
                           accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[var(--color-primary-50)] file:text-[var(--color-primary-700)] hover:file:bg-[var(--color-primary-100)]">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button Text & URL -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-gray-700">Nút bấm - Text</label>
                        <input type="text" 
                               name="button_text" 
                               id="button_text" 
                               value="{{ old('button_text') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                    </div>
                    <div>
                        <label for="button_url" class="block text-sm font-medium text-gray-700">Nút bấm - URL</label>
                        <input type="text" 
                               name="button_url" 
                               id="button_url" 
                               value="{{ old('button_url') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                    </div>
                </div>

                <!-- Order & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700">Thứ tự</label>
                        <input type="number" 
                               name="order" 
                               id="order" 
                               value="{{ old('order', 0) }}"
                               min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái</label>
                        <select name="status" 
                                id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Xuất bản</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                        </select>
                    </div>
                </div>

                <!-- Time Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="starts_at" class="block text-sm font-medium text-gray-700">Thời gian bắt đầu</label>
                        <input type="datetime-local" 
                               name="starts_at" 
                               id="starts_at" 
                               value="{{ old('starts_at') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                    </div>
                    <div>
                        <label for="ends_at" class="block text-sm font-medium text-gray-700">Thời gian kết thúc</label>
                        <input type="datetime-local" 
                               name="ends_at" 
                               id="ends_at" 
                               value="{{ old('ends_at') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                    </div>
                </div>

                <!-- Is Active -->
                <div>
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-[var(--color-primary-600)] focus:ring-[var(--color-primary-500)] border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Hiển thị slider
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-600)] text-white hover:bg-[var(--color-primary-700)] rounded-md">
                    <i class="fas fa-save mr-2"></i> Lưu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 