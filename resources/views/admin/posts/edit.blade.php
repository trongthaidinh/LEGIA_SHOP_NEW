@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Header -->
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-edit mr-2"></i> Chỉnh sửa bài viết
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.posts.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route(app()->getLocale() . '.admin.posts.update', $post) }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Tiêu đề <span class="text-red-600">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title', $post->title) }}" 
                       required
                       class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('title') border-red-300 @enderror">
                @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Thumbnail -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Ảnh đại diện
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        @if($post->thumbnail)
                        <div id="current-thumbnail" class="mb-4">
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                                 alt="{{ $post->title }}" 
                                 class="mx-auto h-32 w-auto">
                            <p class="mt-2 text-sm text-gray-500">Ảnh hiện tại</p>
                        </div>
                        @endif
                        <div class="flex flex-col items-center">
                            <i class="fas fa-image text-gray-400 text-3xl mb-3"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="thumbnail" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Tải ảnh mới</span>
                                    <input id="thumbnail" 
                                           name="thumbnail" 
                                           type="file" 
                                           accept="image/*"
                                           class="sr-only">
                                </label>
                                <p class="pl-1">hoặc kéo thả vào đây</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF tối đa 2MB</p>
                        </div>
                        <div id="thumbnail-preview" class="hidden mt-4">
                            <img src="#" alt="Preview" class="mx-auto h-32 w-auto">
                            <p class="mt-2 text-sm text-gray-500">Ảnh mới</p>
                        </div>
                    </div>
                </div>
                @error('thumbnail')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Nội dung <span class="text-red-600">*</span>
                </label>
                <textarea name="content" 
                          id="content" 
                          rows="10"
                          required
                          class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('content') border-red-300 @enderror">{{ old('content', $post->content) }}</textarea>
                @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt -->
            <div>
                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                    Tóm tắt
                </label>
                <textarea name="excerpt" 
                          id="excerpt" 
                          rows="3"
                          class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('excerpt') border-red-300 @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                @error('excerpt')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="flex items-center space-x-4">
                <label for="is_published" class="flex items-center">
                    <input type="checkbox" 
                           name="is_published" 
                           id="is_published" 
                           value="1"
                           {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Xuất bản</span>
                </label>

                <label for="is_featured" class="flex items-center">
                    <input type="checkbox" 
                           name="is_featured" 
                           id="is_featured" 
                           value="1"
                           {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Bài viết nổi bật</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-6">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition">
                    <i class="fas fa-save mr-2"></i> Cập nhật bài viết
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });

    // Handle thumbnail preview
    $('#thumbnail').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#current-thumbnail').addClass('hidden');
                $('#thumbnail-preview').removeClass('hidden').find('img').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
@endsection 