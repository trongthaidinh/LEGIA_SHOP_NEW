@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-user-edit mr-2"></i> Chỉnh sửa quản trị viên
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.managers.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route(app()->getLocale() . '.admin.managers.update', $manager) }}" 
              method="POST" 
              class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Tên</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $manager->name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $manager->email) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Mật khẩu mới
                        <span class="text-sm text-gray-500">(để trống nếu không muốn thay đổi)</span>
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu mới</label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                </div>

                <!-- Is Super Admin -->
                <div>
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_super_admin" 
                               id="is_super_admin" 
                               value="1"
                               {{ old('is_super_admin', $manager->is_super_admin) ? 'checked' : '' }}
                               {{ $manager->is_super_admin ? 'disabled' : '' }}
                               class="h-4 w-4 text-[var(--color-primary-600)] focus:ring-[var(--color-primary-500)] border-gray-300 rounded">
                        <label for="is_super_admin" class="ml-2 block text-sm text-gray-700">
                            Super Admin
                            @if($manager->is_super_admin)
                                <span class="text-sm text-gray-500">(không thể thay đổi)</span>
                            @endif
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-[var--color-primary-600] text-white hover:bg-[var--color-primary-700] rounded-md">
                    <i class="fas fa-save mr-2"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 