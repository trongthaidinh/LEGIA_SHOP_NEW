@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-folder-plus mr-2"></i> Thêm danh mục bài viết
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.post-categories.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2 text-[var(--color-primary-500)]"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route(app()->getLocale() . '.admin.post-categories.store') }}" method="POST" class="p-6">
            @csrf

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                    Tên danh mục <span class="text-red-600">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}" 
                       required
                       class="w-full rounded-lg shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50 @error('name') border-red-300 @enderror">
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parent Category -->
            <div class="mb-6">
                <label for="parent_id" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                    Danh mục cha
                </label>
                <select name="parent_id" 
                        id="parent_id"
                        class="w-full rounded-lg shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50">
                    <option value="">Không có</option>
                    @if($categories->count() > 0)
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    @else
                        <option value="" disabled>Chưa có danh mục nào</option>
                    @endif
                </select>
                @error('parent_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-[var(--color-primary-700)] mb-2">
                    Mô tả
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="3"
                          class="w-full rounded-lg shadow-sm border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label for="is_active" class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded border-[var(--color-primary-300)] text-[var(--color-primary-600)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-[var(--color-primary-600)]">Kích hoạt</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-500)] border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-[var(--color-primary-600)] active:bg-[var(--color-primary-700)] focus:outline-none focus:border-[var(--color-primary-700)] focus:ring ring-[var(--color-primary-300)] disabled:opacity-25 transition">
                    <i class="fas fa-save mr-2"></i> Lưu danh mục
                </button>
            </div>
        </form>
    </div>
</div>
@endsection