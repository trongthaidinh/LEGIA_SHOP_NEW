@extends('layouts.admin')

@push('styles')
<style>
.sortable-ghost {
    opacity: 0.4;
}
.sortable-handle {
    cursor: move;
}
.menu-item.is-dragging {
    background-color: #f3f4f6;
}
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-edit mr-2"></i> Chỉnh sửa Menu
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.menus.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
            <!-- Menu Settings -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-[var(--color-primary-200)]">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-[var(--color-primary-900)]">Cài đặt Menu</h3>
                    <form action="{{ route(app()->getLocale() . '.admin.menus.update', $menu) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">
                                    Tên menu <span class="text-red-600">*</span>
                                </label>
                                <input type="text" 
                                       class="block w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)] @error('name') border-red-500 @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $menu->name) }}" 
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">
                                    Loại menu <span class="text-red-600">*</span>
                                </label>
                                <select class="block w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)] @error('type') border-red-500 @enderror" 
                                        id="type" 
                                        name="type" 
                                        required>
                                    <option value="main" {{ old('type', $menu->type) == 'main' ? 'selected' : '' }}>Menu chính</option>
                                    <option value="footer" {{ old('type', $menu->type) == 'footer' ? 'selected' : '' }}>Menu chân trang</option>
                                    <option value="sidebar" {{ old('type', $menu->type) == 'sidebar' ? 'selected' : '' }}>Menu thanh bên</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <input type="hidden" name="language" value="{{ request()->segment(1) }}">

                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" 
                                           class="rounded border-[var(--color-primary-300)] text-[var(--color-primary-600)] focus:ring-[var(--color-primary-500)]" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-[var(--color-primary-700)]">Hoạt động</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end border-t border-[var(--color-primary-100)] pt-4">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-500)] text-white rounded-lg hover:bg-[var(--color-primary-600)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary-500)]">
                                    Cập nhật Menu
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Menu Items Management -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Add New Menu Item -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-[var(--color-primary-200)]">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-[var(--color-primary-900)]">Thêm Mục Menu</h3>
                        <form action="{{ route(app()->getLocale() . '.admin.menu-items.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">
                                        Tiêu đề <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" 
                                           class="block w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]" 
                                           id="title" 
                                           name="title" 
                                           required>
                                </div>

                                <div>
                                    <label for="url" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">Đường dẫn</label>
                                    <input type="text" 
                                           class="block w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]" 
                                           id="url" 
                                           name="url">
                                </div>

                                <div>
                                    <label for="parent_id" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">Mục cha</label>
                                    <select class="block w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]" 
                                            id="parent_id" 
                                            name="parent_id">
                                        <option value="">Không có</option>
                                        @foreach($menu->items()->whereNull('parent_id')->ordered()->get() as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="icon_class" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">Lớp biểu tượng</label>
                                    <input type="text" 
                                           class="block w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]" 
                                           id="icon_class" 
                                           name="icon_class">
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 border-t border-[var(--color-primary-100)] pt-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" 
                                           class="rounded border-[var(--color-primary-300)] text-[var(--color-primary-600)] focus:ring-[var(--color-primary-500)]" 
                                           name="is_active" 
                                           value="1" 
                                           checked>
                                    <span class="ml-2 text-sm text-[var(--color-primary-700)]">Hoạt động</span>
                                </label>

                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-500)] text-white rounded-lg hover:bg-[var(--color-primary-600)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary-500)]">
                                    Thêm Mục
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Menu Items List -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-[var(--color-primary-200)]">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-[var(--color-primary-900)]">Các Mục Menu</h3>
                        <div id="menu-items-container" class="space-y-4">
                            <div class="menu-list" data-parent-id="null">
                                @foreach($menu->getMenuTree() as $item)
                                    <div class="menu-item border rounded-lg p-4 bg-gray-50 mb-4" data-id="{{ $item->id }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <span class="sortable-handle text-gray-400 hover:text-gray-600">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                                    </svg>
                                                </span>
                                                @if($item->icon_class)
                                                    <i class="{{ $item->icon_class }}"></i>
                                                @endif
                                                <span class="font-medium">{{ $item->title }}</span>
                                                @if(!$item->is_active)
                                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Không hoạt động</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <button onclick="editMenuItem({{ $item->id }})" 
                                                        class="text-[var(--color-primary-600)] hover:text-[var(--color-primary-800)] bg-[var(--color-primary-50)] rounded-md p-1.5 inline-flex items-center justify-center">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <form action="{{ route(app()->getLocale() . '.admin.menu-items.destroy', $item) }}" 
                                                      method="POST" 
                                                      class="inline-block" 
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa mục menu này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 rounded-md p-1.5 inline-flex items-center justify-center">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        @if($item->url)
                                            <div class="text-sm text-gray-500 mt-1">{{ $item->url }}</div>
                                        @endif
                                        
                                        <!-- Nested Items -->
                                        @if($item->children->count() > 0)
                                            <div class="ml-8 mt-4 space-y-4 menu-list" data-parent-id="{{ $item->id }}">
                                                @foreach($item->children as $child)
                                                    <div class="menu-item border rounded-lg p-4 bg-white" data-id="{{ $child->id }}">
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex items-center space-x-2">
                                                                <span class="sortable-handle text-gray-400 hover:text-gray-600">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                                                    </svg>
                                                                </span>
                                                                @if($child->icon_class)
                                                                    <i class="{{ $child->icon_class }}"></i>
                                                                @endif
                                                                <span class="font-medium">{{ $child->title }}</span>
                                                                @if(!$child->is_active)
                                                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Không hoạt động</span>
                                                                @endif
                                                            </div>
                                                            <div class="flex items-center space-x-2">
                                                                <button onclick="editMenuItem({{ $child->id }})" 
                                                                        class="text-[var(--color-primary-600)] hover:text-[var(--color-primary-800)] bg-[var(--color-primary-50)] rounded-md p-1.5 inline-flex items-center justify-center">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                                    </svg>
                                                                </button>
                                                                <form action="{{ route(app()->getLocale() . '.admin.menu-items.destroy', $child) }}" 
                                                                      method="POST" 
                                                                      class="inline-block" 
                                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa mục menu này?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 rounded-md p-1.5 inline-flex items-center justify-center">
                                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        @if($child->url)
                                                            <div class="text-sm text-gray-500 mt-1">{{ $child->url }}</div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Menu Item Modal -->
<div id="editMenuItemModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-[var(--color-primary-900)] mb-4">Chỉnh sửa Mục Menu</h3>
            <form id="editMenuItemForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="edit_title" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">Tiêu đề</label>
                    <input type="text" id="edit_title" name="title" class="block w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]" required>
                </div>

                <div>
                    <label for="edit_url" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">Đường dẫn</label>
                    <input type="text" id="edit_url" name="url" class="block w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                </div>

                <div>
                    <label for="edit_icon_class" class="block text-sm font-medium text-[var(--color-primary-700)] mb-1">Lớp biểu tượng</label>
                    <input type="text" id="edit_icon_class" name="icon_class" class="block w-full rounded-lg border-[var(--color-primary-300)] focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                </div>

                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="edit_is_active" name="is_active" value="1" class="rounded border-[var(--color-primary-300)] text-[var(--color-primary-600)] focus:ring-[var(--color-primary-500)]">
                        <span class="ml-2 text-sm text-[var(--color-primary-700)]">Hoạt động</span>
                    </label>
                </div>

                <div class="flex items-center justify-end space-x-3 border-t border-[var(--color-primary-100)] pt-4">
                    <button type="button" onclick="closeEditModal()" class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] rounded-lg hover:bg-[var(--color-primary-200)]">
                        Hủy
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-500)] text-white rounded-lg hover:bg-[var(--color-primary-600)] focus:outline-none focus:ring-2 focus:ring-[var(--color-primary-500)]">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Sortable for each menu list
    document.querySelectorAll('.menu-list').forEach(function(el) {
        new Sortable(el, {
            group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            handle: '.sortable-handle',
            dragClass: 'is-dragging',
            onEnd: function(evt) {
                updateOrder();
            }
        });
    });
});

function updateOrder() {
    const items = [];
    let order = 0;
    
    // Process top-level items
    document.querySelectorAll('.menu-list[data-parent-id="null"] > .menu-item').forEach(function(item) {
        items.push({
            id: item.dataset.id,
            parent_id: null,
            order: order++
        });
        
        // Process children
        const childList = item.querySelector('.menu-list');
        if (childList) {
            childList.querySelectorAll('.menu-item').forEach(function(child) {
                items.push({
                    id: child.dataset.id,
                    parent_id: item.dataset.id,
                    order: order++
                });
            });
        }
    });

    // Send the order to the server
    fetch(`/{{ app()->getLocale() }}/admin/menu-items/reorder`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ items: items })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            // Optional: Show success message
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function editMenuItem(id) {
    fetch(`/{{ app()->getLocale() }}/admin/menu-items/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_title').value = data.title;
            document.getElementById('edit_url').value = data.url || '';
            document.getElementById('edit_icon_class').value = data.icon_class || '';
            document.getElementById('edit_is_active').checked = data.is_active;
            
            const form = document.getElementById('editMenuItemForm');
            form.action = `/{{ app()->getLocale() }}/admin/menu-items/${id}`;
            
            document.getElementById('editMenuItemModal').classList.remove('hidden');
        });
}

function closeEditModal() {
    document.getElementById('editMenuItemModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('editMenuItemModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>
@endpush

@endsection
