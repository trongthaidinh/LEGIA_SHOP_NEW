@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Edit Static Page') }}</h1>
        <a href="{{ route(app()->getLocale() . '.admin.static-pages.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to List') }}
        </a>
    </div>

    <form action="{{ route(app()->getLocale() . '.admin.static-pages.update', $staticPage) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Title & Slug -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Title') }} <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $staticPage->title) }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200"
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700">{{ __('Slug') }}</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $staticPage->slug) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200"
                >
                <p class="mt-1 text-sm text-gray-500">{{ __('Leave empty to auto-generate from title') }}</p>
                @error('slug')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Content -->
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Content') }} <span class="text-red-500">*</span></label>
            <textarea name="content" id="content" class="tinymce">{{ old('content', $staticPage->content) }}</textarea>
            @error('content')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Language & Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="locale" class="block text-sm font-medium text-gray-700">{{ __('Language') }} <span class="text-red-500">*</span></label>
                <select name="locale" id="locale" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200"
                >
                    <option value="vi" {{ old('locale', $staticPage->locale) === 'vi' ? 'selected' : '' }}>{{ __('Vietnamese') }}</option>
                    <option value="zh" {{ old('locale', $staticPage->locale) === 'zh' ? 'selected' : '' }}>{{ __('Chinese') }}</option>
                </select>
                @error('locale')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="is_active" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                <div class="mt-1">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $staticPage->is_active) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200"
                        >
                        <span class="ml-2">{{ __('Active') }}</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Meta Information -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('SEO Information') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700">{{ __('Meta Description') }}</label>
                    <textarea name="meta_description" id="meta_description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200"
                    >{{ old('meta_description', $staticPage->meta_description) }}</textarea>
                    @error('meta_description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700">{{ __('Meta Keywords') }}</label>
                    <textarea name="meta_keywords" id="meta_keywords" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200"
                    >{{ old('meta_keywords', $staticPage->meta_keywords) }}</textarea>
                    @error('meta_keywords')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-md transition-colors duration-200">
                <i class="fas fa-save mr-2"></i>{{ __('Update Page') }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TinyMCE
    initTinyMCE('#content');

    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const originalSlug = slugInput.value;

    titleInput.addEventListener('input', function() {
        if (!originalSlug || !slugInput.value) {
            slugInput.value = titleInput.value
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
        }
    });
});
</script>
@endpush
@endsection 