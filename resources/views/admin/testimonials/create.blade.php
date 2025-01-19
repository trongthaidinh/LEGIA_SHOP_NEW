@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <h3 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Thêm đánh giá mới
            </h3>
        </div>

        <div class="p-6">
            <form action="{{ route(app()->getLocale() . '.admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Name -->
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-[var(--color-primary-700)]">Tên khách hàng <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required
                               class="mt-1 block w-full rounded-md border-[var(--color-primary-200)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]">
                        @error('customer_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Customer Position -->
                    <div>
                        <label for="customer_position" class="block text-sm font-medium text-[var(--color-primary-700)]">Chức danh</label>
                        <input type="text" name="customer_position" id="customer_position" value="{{ old('customer_position') }}"
                               class="mt-1 block w-full rounded-md border-[var(--color-primary-200)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]">
                        @error('customer_position')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company -->
                    <div>
                        <label for="company" class="block text-sm font-medium text-[var(--color-primary-700)]">Công ty</label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}"
                               class="mt-1 block w-full rounded-md border-[var(--color-primary-200)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]">
                        @error('company')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-[var(--color-primary-700)]">Địa điểm</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                               class="mt-1 block w-full rounded-md border-[var(--color-primary-200)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]">
                        @error('location')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rating -->
                    <div>
                        <label for="rating" class="block text-sm font-medium text-[var(--color-primary-700)]">Đánh giá <span class="text-red-500">*</span></label>
                        <select name="rating" id="rating" required
                                class="mt-1 block w-full rounded-md border-[var(--color-primary-200)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]">
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('rating', 5) == $i ? 'selected' : '' }}>
                                    {{ $i }} sao
                                </option>
                            @endfor
                        </select>
                        @error('rating')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Language -->
                    <div>
                        <label for="language" class="block text-sm font-medium text-[var(--color-primary-700)]">Ngôn ngữ <span class="text-red-500">*</span></label>
                        <select name="language" id="language" required
                                class="mt-1 block w-full rounded-md border-[var(--color-primary-200)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]">
                            <option value="vi" {{ old('language', 'vi') == 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
                            <option value="zh" {{ old('language') == 'zh' ? 'selected' : '' }}>Tiếng Trung</option>
                        </select>
                        @error('language')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Content -->
                <div class="mt-6">
                    <label for="content" class="block text-sm font-medium text-[var(--color-primary-700)]">Nội dung <span class="text-red-500">*</span></label>
                    <textarea name="content" id="content" rows="4" required
                              class="mt-1 block w-full rounded-md border-[var(--color-primary-200)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Customer Avatar -->
                <div class="mt-6">
                    <label for="customer_avatar" class="block text-sm font-medium text-[var(--color-primary-700)]">Ảnh đại diện</label>
                    <input type="file" name="customer_avatar" id="customer_avatar" accept="image/*"
                           class="mt-1 block w-full text-sm text-[var(--color-primary-700)]
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-medium
                                  file:bg-[var(--color-primary-50)] file:text-[var(--color-primary-700)]
                                  hover:file:cursor-pointer hover:file:bg-[var(--color-primary-100)]">
                    @error('customer_avatar')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additional Options -->
                <div class="mt-6 space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                               class="h-4 w-4 text-[var(--color-primary-600)] focus:ring-[var(--color-primary-500)] border-[var(--color-primary-300)] rounded">
                        <label for="is_featured" class="ml-2 block text-sm text-[var(--color-primary-700)]">
                            Đánh giá nổi bật
                        </label>
                    </div>
                </div>

                <!-- Status -->
                <div class="mt-6">
                    <label for="status" class="block text-sm font-medium text-[var(--color-primary-700)]">Trạng thái <span class="text-red-500">*</span></label>
                    <select name="status" id="status" required
                            class="mt-1 block w-full rounded-md border-[var(--color-primary-200)] focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)]">
                        <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Xuất bản</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Nháp</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route(app()->getLocale() . '.admin.testimonials.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-[var(--color-primary-300)] rounded-md shadow-sm text-sm font-medium text-[var(--color-primary-700)] bg-white hover:bg-[var(--color-primary-50)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary-500)]">
                        Hủy
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[var(--color-primary-600)] hover:bg-[var(--color-primary-700)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary-500)]">
                        Thêm đánh giá
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 