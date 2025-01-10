@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h3 class="text-gray-700 text-3xl font-medium">{{ __('Edit Product') }}</h3>

    <div class="mt-8">
        <form action="{{ route('admin.' . request()->segment(2) . '.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-5 mt-5">
            @csrf
            @method('PUT')
            <input type="hidden" name="language" value="{{ request()->segment(2) }}">

            <div>
                <label for="name" class="text-gray-700">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" class="form-input w-full mt-2" value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="type" class="text-gray-700">{{ __('Type') }}</label>
                <select name="type" id="type" class="form-input w-full mt-2" required>
                    @foreach($types as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $product->type) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="text-gray-700">{{ __('Category') }}</label>
                <select name="category_id" id="category_id" class="form-input w-full mt-2" required>
                    <option value="">{{ __('Select Category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="text-gray-700">{{ __('Description') }}</label>
                <textarea name="description" id="description" class="form-input w-full mt-2" rows="4">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="text-gray-700">{{ __('Content') }}</label>
                <textarea name="content" id="content" class="form-input w-full mt-2" rows="6">{{ old('content', $product->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="text-gray-700">{{ __('Price') }}</label>
                <input type="number" name="price" id="price" class="form-input w-full mt-2" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
                @error('price')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="sale_price" class="text-gray-700">{{ __('Sale Price') }}</label>
                <input type="number" name="sale_price" id="sale_price" class="form-input w-full mt-2" value="{{ old('sale_price', $product->sale_price) }}" min="0" step="0.01">
                @error('sale_price')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stock" class="text-gray-700">{{ __('Stock') }}</label>
                <input type="number" name="stock" id="stock" class="form-input w-full mt-2" value="{{ old('stock', $product->stock) }}" min="0" required>
                @error('stock')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="sku" class="text-gray-700">{{ __('SKU') }}</label>
                <input type="text" name="sku" id="sku" class="form-input w-full mt-2" value="{{ old('sku', $product->sku) }}" required>
                @error('sku')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="featured_image" class="text-gray-700">{{ __('Featured Image') }}</label>
                @if($product->featured_image)
                    <div class="mt-2">
                        <img src="{{ Storage::url($product->featured_image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover">
                    </div>
                @endif
                <input type="file" name="featured_image" id="featured_image" class="form-input w-full mt-2" accept="image/*">
                @error('featured_image')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-checkbox" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                <label for="is_featured" class="ml-2 text-gray-700">{{ __('Featured') }}</label>
                @error('is_featured')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="text-gray-700">{{ __('Status') }}</label>
                <select name="status" id="status" class="form-input w-full mt-2" required>
                    <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                    <option value="published" {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                </select>
                @error('status')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                    {{ __('Update Product') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 