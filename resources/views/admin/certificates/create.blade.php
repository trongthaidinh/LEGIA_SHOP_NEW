@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-certificate mr-2"></i>{{ __('Thêm mới chứng nhận') }}
                </h3>
                <a href="{{ route(app()->getLocale() . '.admin.certificates.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>{{ __('Quay lại danh sách') }}
                </a>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route(app()->getLocale() . '.admin.certificates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Language -->
                <div>
                    <label for="language" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Ngôn ngữ') }} <span class="text-[var(--color-secondary-500)]">*</span></label>
                    <select name="language" id="language" class="mt-1 block w-full rounded-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]" required>
                        <option value="vi" {{ old('language') === 'vi' ? 'selected' : '' }}>{{ __('Tiếng Việt') }}</option>
                        <option value="zh" {{ old('language') === 'zh' ? 'selected' : '' }}>{{ __('Tiếng Trung') }}</option>
                    </select>
                    @error('language')
                        <p class="mt-1 text-sm text-[var(--color-secondary-500)]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Hình ảnh') }} <span class="text-[var(--color-secondary-500)]">*</span></label>
                    <div class="mt-1 flex items-center space-x-4">
                        <div class="relative">
                            <input type="file" name="image" id="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" required>
                            <div class="px-4 py-2 bg-[var(--color-primary-50)] border border-[var(--color-primary-300)] rounded-md shadow-sm text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-100)]">
                                {{ __('Chọn File') }}
                            </div>
                        </div>
                        <div id="image-preview" class="hidden">
                            <img src="" alt="Preview" class="h-20 w-32 object-cover rounded">
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-[var(--color-secondary-500)]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Tên') }} <span class="text-[var(--color-secondary-500)]">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]" required>
                    @error('name')
                        <p class="mt-1 text-sm text-[var(--color-secondary-500)]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mô tả -->
                <div>
                    <label for="description" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Mô tả') }}</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-[var(--color-secondary-500)]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trạng thái -->
                <div>
                    <label for="is_active" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Trạng thái') }}</label>
                    <div class="mt-1">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" class="rounded border-[var(--color-primary-300)] text-[var(--color-primary-600)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-[var(--color-primary-600)]">{{ __('Hoạt động') }}</span>
                        </label>
                    </div>
                    @error('is_active')
                        <p class="mt-1 text-sm text-[var(--color-secondary-500)]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Thứ tự') }}</label>
                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}" class="mt-1 block w-full rounded-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]">
                    @error('order')
                        <p class="mt-1 text-sm text-[var(--color-secondary-500)]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-[var(--color-primary-500)] hover:bg-[var(--color-primary-600)] text-white rounded-md transition-colors duration-200">
                        {{ __('Lưu') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
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
    } else {
        preview.classList.add('hidden');
    }
});
</script>
@endpush

@endsection