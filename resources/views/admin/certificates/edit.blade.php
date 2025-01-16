@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Edit Certificate') }}</h1>
        <a href="{{ route(app()->getLocale() . '.admin.certificates.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>{{ __('Back') }}
        </a>
    </div>

    <form action="{{ route(app()->getLocale() . '.admin.certificates.update', $certificate) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Language -->
        <div>
            <label for="language" class="block text-sm font-medium text-gray-700">{{ __('Language') }} <span class="text-red-500">*</span></label>
            <select name="language" id="language" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200" required>
                <option value="vi" {{ $certificate->language === 'vi' ? 'selected' : '' }}>{{ __('Vietnamese') }}</option>
                <option value="zh" {{ $certificate->language === 'zh' ? 'selected' : '' }}>{{ __('Chinese') }}</option>
            </select>
            @error('language')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">{{ __('Image') }}</label>
            <div class="mt-1 flex items-center space-x-4">
                <div class="relative">
                    <input type="file" name="image" id="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                    <div class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                        {{ __('Choose File') }}
                    </div>
                </div>
                <div id="image-preview" class="{{ $certificate->image ? '' : 'hidden' }}">
                    <img src="{{ $certificate->image ? Storage::url($certificate->image) : '' }}" alt="Preview" class="h-20 w-32 object-cover rounded">
                </div>
            </div>
            <p class="mt-1 text-sm text-gray-500">{{ __('Leave empty to keep the current image') }}</p>
            @error('image')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }} <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $certificate->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200" required>
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200">{{ old('description', $certificate->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label for="is_active" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
            <div class="mt-1">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200" value="1" {{ old('is_active', $certificate->is_active) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-600">{{ __('Active') }}</span>
                </label>
            </div>
            @error('is_active')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Order -->
        <div>
            <label for="order" class="block text-sm font-medium text-gray-700">{{ __('Order') }}</label>
            <input type="number" name="order" id="order" value="{{ old('order', $certificate->order) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200">
            @error('order')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-md transition-colors duration-200">
                {{ __('Update') }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endpush

@endsection 