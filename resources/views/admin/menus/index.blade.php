@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-bars mr-2"></i> Quản lý Menu
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.menus.create') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md">
                        <i class="fas fa-plus mr-2"></i> Thêm Menu Mới
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="p-4">
            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Menus Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @forelse($menus as $menu)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-[var(--color-primary-200)]">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-sm font-medium text-[var(--color-primary-900)]">{{ $menu->name }}</h3>
                                <div class="mt-1 flex items-center space-x-2">
                                    <span class="text-xs text-[var(--color-primary-500)] capitalize">{{ $menu->type }}</span>
                                    <span class="text-[var(--color-primary-300)]">•</span>
                                    <span class="text-xs text-[var(--color-primary-500)] uppercase">{{ $menu->language }}</span>
                                </div>
                            </div>
                            <span class="inline-flex px-2 text-xs leading-5 font-semibold rounded-full 
                                {{ $menu->is_active ? 'bg-[var(--color-primary-100)] text-[var(--color-primary-700)]' : 'bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)]' }}">
                                {{ $menu->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                            </span>
                        </div>

                        <div class="border-t border-[var(--color-primary-200)] pt-4">
                            <div class="text-xs text-[var(--color-primary-500)] mb-2">Các mục menu:</div>
                            <div class="space-y-1">
                                @forelse($menu->items()->parents()->ordered()->take(3)->get() as $item)
                                    <div class="flex items-center space-x-2">
                                        @if($item->icon_class)
                                            <i class="{{ $item->icon_class }} text-[var(--color-primary-400)]"></i>
                                        @endif
                                        <span class="text-sm text-[var(--color-primary-600)]">{{ $item->title }}</span>
                                        @if($item->children_count > 0)
                                            <span class="text-xs text-[var(--color-primary-400)]">({{ $item->children_count }} mục con)</span>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-sm text-[var(--color-primary-400)]">Chưa có mục menu</p>
                                @endforelse
                                @if($menu->items()->parents()->count() > 3)
                                    <div class="text-sm text-[var(--color-primary-400)]">
                                        Và {{ $menu->items()->parents()->count() - 3 }} mục khác...
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end space-x-2">
                            <a href="{{ route(app()->getLocale() . '.admin.menus.edit', $menu) }}" 
                               class="inline-flex items-center justify-center w-9 h-9 bg-[var(--color-primary-100)] text-[var(--color-primary-600)] hover:bg-[var(--color-primary-200)] rounded-md">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route(app()->getLocale() . '.admin.menus.destroy', $menu) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa menu này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center justify-center w-9 h-9 bg-[var(--color-secondary-100)] text-[var(--color-secondary-600)] hover:bg-[var(--color-secondary-200)] rounded-md">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12 bg-white rounded-lg shadow border border-[var(--color-primary-200)]">
                        <i class="fas fa-bars text-[var(--color-primary-400)] text-4xl mb-4"></i>
                        <h3 class="mt-2 text-sm font-medium text-[var(--color-primary-900)]">Chưa có menu</h3>
                        <p class="mt-1 text-sm text-[var(--color-primary-500)]">Bắt đầu bằng cách tạo menu mới.</p>
                        <div class="mt-6">
                            <a href="{{ route(app()->getLocale() . '.admin.menus.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-500)] text-white text-sm font-medium rounded-md hover:bg-[var(--color-primary-600)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary-500)]">
                                <i class="fas fa-plus mr-2"></i> Thêm Menu Mới
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($menus->hasPages())
        <div class="bg-white px-4 py-3 border-t border-[var(--color-primary-200)] sm:px-6">
            {{ $menus->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Xử lý thay đổi bộ lọc ngôn ngữ
    $('#language-filter').change(function() {
        const language = $(this).val();
        // Thêm logic lọc của bạn tại đây
    });

    // Xử lý thay đổi bộ lọc trạng thái
    $('#status-filter').change(function() {
        const status = $(this).val();
        // Thêm logic lọc của bạn tại đây
    });

    // Xử lý nhập tìm kiếm
    let searchTimeout;
    $('#search').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const search = $(this).val();
            // Thêm logic tìm kiếm của bạn tại đây
        }, 500);
    });
});
</script>
@endpush
@endsection