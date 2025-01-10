@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-gray-700 text-3xl font-medium">{{ __('Create Product') }}</h3>
        <a href="{{ route(request()->segment(1) . '.admin.products.index') }}" class="px-6 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>{{ __('Back') }}
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <form action="{{ route(request()->segment(1) . '.admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="language" value="{{ request()->segment(1) }}">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
                    <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('category_id') border-red-300 @enderror">
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('type') border-red-300 @enderror">
                        @foreach($types as $key => $value)
                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700">{{ __('SKU') }}</label>
                    <input type="text" name="sku" id="sku" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('sku') border-red-300 @enderror" value="{{ old('sku') }}">
                    @error('sku')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">{{ __('Price') }} <span class="text-red-500">*</span></label>
                    <input type="number" name="price" id="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('price') border-red-300 @enderror" value="{{ old('price') }}" min="0" step="1" required>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sale_price" class="block text-sm font-medium text-gray-700">{{ __('Sale Price') }}</label>
                    <input type="number" name="sale_price" id="sale_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('sale_price') border-red-300 @enderror" value="{{ old('sale_price') }}" min="0" step="1">
                    @error('sale_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">{{ __('Stock') }} <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" id="stock" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('stock') border-red-300 @enderror" value="{{ old('stock', 0) }}" min="0" step="1" required>
                    @error('stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Content') }}</label>
                <textarea name="content" id="content" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('content') border-red-300 @enderror">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-700">{{ __('Featured Image') }}</label>
                <input type="file" name="featured_image" id="featured_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('featured_image') border-red-300 @enderror">
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 @error('is_active') border-red-300 @enderror" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">{{ __('Active') }}</label>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" id="is_featured" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 @error('is_featured') border-red-300 @enderror" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    <label for="is_featured" class="ml-2 block text-sm text-gray-700">{{ __('Featured') }}</label>
                    @error('is_featured')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('status') border-red-300 @enderror">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-save mr-2"></i>{{ __('Save Product') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 