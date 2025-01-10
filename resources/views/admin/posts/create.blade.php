@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center">
        <h3 class="text-gray-700 text-3xl font-medium">{{ __('Create New Post') }}</h3>
        <a href="{{ route(app()->getLocale() . '.admin.posts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
            {{ __('Back to List') }}
        </a>
    </div>

    <div class="mt-8">
        <form action="{{ route(app()->getLocale() . '.admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Post Information') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ __('Basic information about the post.') }}
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Title') }}</label>
                                <input type="text" name="title" id="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('title') }}" required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="post_category_id" class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
                                <select name="post_category_id" id="post_category_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('post_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('post_category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="excerpt" class="block text-sm font-medium text-gray-700">{{ __('Excerpt') }}</label>
                                <textarea name="excerpt" id="excerpt" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('excerpt') }}</textarea>
                                @error('excerpt')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Content') }}</label>
                                <textarea name="content" id="content" rows="10" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="featured_image" class="block text-sm font-medium text-gray-700">{{ __('Featured Image') }}</label>
                                <input type="file" name="featured_image" id="featured_image" class="mt-1 block w-full" accept="image/*">
                                @error('featured_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                                <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="published_at" class="block text-sm font-medium text-gray-700">{{ __('Publish Date') }}</label>
                                <input type="datetime-local" name="published_at" id="published_at" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('published_at') }}">
                                @error('published_at')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="is_featured" id="is_featured" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_featured" class="font-medium text-gray-700">{{ __('Featured Post') }}</label>
                                        <p class="text-gray-500">{{ __('Featured posts will be displayed prominently on the website.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Create Post') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 