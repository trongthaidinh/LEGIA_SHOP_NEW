@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i> Tạo Menu Mới
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.menus.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

    <div class="p-6">
        <form action="{{ route(app()->getLocale() . '.admin.menus.store') }}" method="POST" class="max-w-2xl mx-auto">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">
                        Tên menu <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           class="block w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)] @error('name') border-red-500 @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">
                        Loại menu <span class="text-red-600">*</span>
                    </label>
                    <select class="block w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)] @error('type') border-red-500 @enderror" 
                            id="type" 
                            name="type" 
                            required>
                        <option value="">Chọn loại menu</option>
                        <option value="main" {{ old('type') == 'main' ? 'selected' : '' }}>Menu chính</option>
                        <option value="footer" {{ old('type') == 'footer' ? 'selected' : '' }}>Menu chân trang</option>
                        <option value="sidebar" {{ old('type') == 'sidebar' ? 'selected' : '' }}>Menu thanh bên</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- add language by url --}}
                <input type="hidden" name="language" value="{{ request()->segment(1) }}">

                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" 
                               class="rounded border-[var(--color-primary-300)] text-[var(--color-primary-600)] focus:ring-[var(--color-primary-500)]" 
                               id="is_active" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', 1) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-[var(--color-primary-700)]">Hoạt động</span>
                    </label>
                </div>

                <div class="flex items-center justify-end space-x-3 border-t border-[var(--color-primary-100)] pt-4">
                    <a href="{{ route(app()->getLocale() . '.admin.menus.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] rounded-lg hover:bg-[var(--color-primary-200)]">
                        Hủy
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-500)] text-white rounded-lg hover:bg-[var(--color-primary-600)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary-500)]">
                        Tạo Menu
                    </button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
@endsection