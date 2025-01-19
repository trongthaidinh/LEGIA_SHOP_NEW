@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-file-alt mr-2"></i>{{ __('Tạo Trang Tĩnh') }}
                </h3>
                <a href="{{ route(app()->getLocale() . '.admin.static-pages.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>{{ __('Quay Lại Danh Sách') }}
                </a>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route(app()->getLocale() . '.admin.static-pages.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title & Slug -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Tiêu Đề') }} <span class="text-[var(--color-secondary-500)]">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="mt-1 block w-full rounded-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]"
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-[var(--color-secondary-500)]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Đường Dẫn') }}</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                            class="mt-1 block w-full rounded-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]"
                        >
                        <p class="mt-1 text-sm text-[var(--color-primary-600)]">{{ __('Để trống để tự động tạo từ tiêu đề') }}</p>
                        @error('slug')
                            <p class="mt-1 text-sm text-[var(--color-secondary-500)]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Nội Dung') }} <span class="text-[var(--color-secondary-500)]">*</span></label>
                    <textarea name="content" id="content" class="tinymce">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-[var(--color-secondary-500)]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Language & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="locale" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Ngôn Ngữ') }} <span class="text-[var(--color-secondary-500)]">*</span></label>
                        <select name="locale" id="locale" required
                            class="mt-1 block w-full rounded-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]"
                        >
                            <option value="vi" {{ old('locale') == 'vi' ? 'selected' : '' }}>{{ __('Tiếng Việt') }}</option>
                            <option value="zh" {{ old('locale') == 'zh' ? 'selected' : '' }}>{{ __('Tiếng Trung') }}</option>
                        </select>
                        @error('locale')
                            <p class="mt-1 text-sm text-[var(--color-secondary-500)]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="is_active" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Trạng Thái') }}</label>
                        <div class="mt-1">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                    class="rounded border-[var(--color-primary-300)] text-[var(--color-primary-600)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]"
                                >
                                <span class="ml-2 text-sm text-[var(--color-primary-600)]">{{ __('Hoạt Động') }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Meta Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-[var(--color-primary-700)]">{{ __('Thông Tin Meta') }}</h3>
                    
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Mô Tả Meta') }}</label>
                        <textarea name="meta_description" id="meta_description" rows="3"
                            class="mt-1 block w-full rounded-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]"
                        >{{ old('meta_description') }}</textarea>
                    </div>

                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Từ Khóa Meta') }}</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}"
                            class="mt-1 block w-full rounded-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]"
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-[var(--color-primary-500)] hover:bg-[var(--color-primary-600)] text-white rounded-md transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>{{ __('Lưu Trang') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
try {
    console.log('Script starting...');
    
    // Log initial state
    console.log('Initial check - TinyMCE:', typeof tinymce !== 'undefined' ? 'Loaded' : 'Not loaded');
    console.log('Initial check - jQuery:', typeof jQuery !== 'undefined' ? 'Loaded' : 'Not loaded');
    
    $(document).ready(function() {
        console.log('jQuery ready fired');
        
        // Initialize TinyMCE
        if (typeof tinymce !== 'undefined') {
            initTinyMCE('#content');
            console.log('TinyMCE initialized');
        } else {
            console.error('TinyMCE not loaded!');
        }

        // Setup title-slug conversion
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        if (titleInput && slugInput) {
            console.log('Title and slug inputs found');
            
            titleInput.addEventListener('input', function() {
                console.log('Title input event fired');
                if (!slugInput.value) {
                    slugInput.value = titleInput.value
                        .toLowerCase()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim();
                    console.log('Slug generated:', slugInput.value);
                }
            });
        } else {
            console.error('Title or slug input not found!');
        }
    });
} catch (error) {
    console.error('Error in script execution:', error);
}
</script>
@endpush
@endsection