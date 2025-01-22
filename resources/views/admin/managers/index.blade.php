@extends('layouts.admin')

@section('content')
<div class="flex flex-col">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-users-cog mr-2"></i> Quản lý tài khoản quản trị
                </h3>
                <a href="{{ route(app()->getLocale() . '.admin.managers.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Thêm quản trị viên
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-[var(--color-primary-50)] text-[var(--color-primary-700)] p-4 flex items-center" role="alert">
                <i class="fas fa-check-circle mr-3 text-[var(--color-primary-600)]"></i>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-[var(--color-secondary-50)] text-[var(--color-secondary-700)] p-4 flex items-center" role="alert">
                <i class="fas fa-exclamation-circle mr-3 text-[var(--color-secondary-600)]"></i>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Search and Filter Section -->
        <div class="p-6 border-b border-[var(--color-primary-100)]">
            <form action="{{ route(app()->getLocale() . '.admin.managers.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">Tìm kiếm</label>
                        <div class="relative flex">
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Tìm theo tên hoặc email..."
                                   class="block w-full rounded-l-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)] sm:text-sm">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-500)] text-white text-sm font-medium rounded-r-md hover:bg-[var(--color-primary-600)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary-500)] focus:ring-offset-2">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request('search'))
                                <a href="{{ route(app()->getLocale() . '.admin.managers.index', array_merge(request()->except('search'), ['page' => 1])) }}" 
                                   class="absolute right-14 inset-y-0 flex items-center pr-3 text-[var(--color-primary-400)] hover:text-[var(--color-primary-600)]">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Role Filter -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">Vai trò</label>
                        <select name="role" 
                                id="role" 
                                class="block w-full rounded-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)] sm:text-sm"
                                onchange="this.form.submit()">
                            <option value="">Tất cả vai trò</option>
                            <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">Sắp xếp</label>
                        <select name="sort" 
                                id="sort" 
                                class="block w-full rounded-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)] sm:text-sm"
                                onchange="this.form.submit()">
                            <option value="created_at" {{ request('sort', 'created_at') === 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                            <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Tên</option>
                            <option value="email" {{ request('sort') === 'email' ? 'selected' : '' }}>Email</option>
                        </select>
                        <input type="hidden" 
                               name="direction" 
                               value="{{ request('direction', 'desc') === 'desc' ? 'asc' : 'desc' }}">
                    </div>
                </div>

                <!-- Active Filters -->
                @if(request()->anyFilled(['search', 'role', 'sort']))
                    <div class="flex items-center space-x-2 text-sm text-[var(--color-primary-600)]">
                        <span>Bộ lọc đang dùng:</span>
                        <div class="flex flex-wrap gap-2">
                            @if(request('search'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[var(--color-primary-100)] text-[var(--color-primary-800)]">
                                    Tìm kiếm: {{ request('search') }}
                                </span>
                            @endif
                            @if(request('role'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[var(--color-primary-100)] text-[var(--color-primary-800)]">
                                    Vai trò: {{ request('role') === 'super_admin' ? 'Super Admin' : 'Admin' }}
                                </span>
                            @endif
                            @if(request('sort') && request('sort') !== 'created_at')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[var(--color-primary-100)] text-[var(--color-primary-800)]">
                                    Sắp xếp: {{ request('sort') === 'name' ? 'Tên' : 'Email' }}
                                    ({{ request('direction', 'desc') === 'desc' ? 'Giảm dần' : 'Tăng dần' }})
                                </span>
                            @endif
                            <a href="{{ route(app()->getLocale() . '.admin.managers.index') }}" 
                               class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[var(--color-primary-50)] text-[var(--color-primary-700)] hover:bg-[var(--color-primary-100)]">
                                <i class="fas fa-times mr-1"></i> Xóa bộ lọc
                            </a>
                        </div>
                    </div>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-primary-200)]">
                <thead class="bg-[var(--color-primary-50)]">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-700)] uppercase tracking-wider">
                            Tên
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-700)] uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-700)] uppercase tracking-wider">
                            Vai trò
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-700)] uppercase tracking-wider">
                            Ngày tạo
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[var(--color-primary-700)] uppercase tracking-wider">
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-[var(--color-primary-200)]">
                    @forelse($managers as $manager)
                        <tr class="hover:bg-[var(--color-primary-50)] transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-[var(--color-primary-900)]">{{ $manager->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-[var(--color-primary-600)]">{{ $manager->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 text-xs leading-5 font-semibold rounded-full {{ $manager->is_super_admin ? 'bg-[var(--color-secondary-100)] text-[var(--color-secondary-800)]' : 'bg-[var(--color-primary-100)] text-[var(--color-primary-800)]' }}">
                                    {{ $manager->is_super_admin ? 'Super Admin' : 'Admin' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--color-primary-500)]">
                                {{ $manager->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route(app()->getLocale() . '.admin.managers.edit', $manager) }}" 
                                       class="inline-flex items-center p-1.5 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] hover:bg-[var(--color-primary-200)] rounded-md transition-colors duration-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(!$manager->is_super_admin)
                                        <form action="{{ route(app()->getLocale() . '.admin.managers.destroy', $manager) }}" 
                                              method="POST" 
                                              class="inline-block" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa quản trị viên này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center p-1.5 bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)] hover:bg-[var(--color-secondary-200)] rounded-md transition-colors duration-200">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-[var(--color-primary-500)] text-center">
                                Không tìm thấy quản trị viên nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-[var(--color-primary-200)]">
            {{ $managers->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-submit form when filters change
    $('#role, #sort').change(function() {
        $(this).closest('form').submit();
    });
});
</script>
@endpush