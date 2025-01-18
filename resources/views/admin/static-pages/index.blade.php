@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-file-alt mr-2"></i> Quản lý trang tĩnh
                </h3>
                <div class="flex items-center space-x-4">
                    <a href="{{ route(app()->getLocale() . '.admin.static-pages.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>Thêm mới
                    </a>
                </div>
            </div>
        </div>

        <div>
            <!-- Static Pages List -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[var(--color-primary-100)]">
                    <thead class="bg-[var(--color-primary-50)]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Tên</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Ngày cập nhật</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[var(--color-primary-100)]">
                        @forelse($pages as $page)
                            <tr class="hover:bg-[var(--color-primary-50)] transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-[var(--color-primary-900)]">{{ $page->title }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-[var(--color-primary-600)]">{{ $page->slug }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button 
                                        type="button" 
                                        class="toggle-status px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $page->is_active ? 'bg-[var(--color-primary-100)] text-[var(--color-primary-700)]' : 'bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)]' }}"
                                        data-url="{{ route(app()->getLocale() . '.admin.static-pages.toggle', $page) }}"
                                    >
                                        {{ $page->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--color-primary-600)]">
                                    {{ $page->updated_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route(app()->getLocale() . '.admin.static-pages.edit', $page) }}" 
                                           class="inline-flex items-center p-1.5 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] hover:bg-[var(--color-primary-200)] rounded-md transition-colors duration-200">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route(app()->getLocale() . '.admin.static-pages.destroy', $page) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center p-1.5 bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)] hover:bg-[var(--color-secondary-200)] rounded-md transition-colors duration-200" 
                                                    onclick="return confirm('{{ __('Are you sure you want to delete this page?') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-[var(--color-primary-500)]">
                                    Không có trang tĩnh nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pages->hasPages())
            <div class="px-6 py-4 border-t border-[var(--color-primary-100)]">
                {{ $pages->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Status
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            fetch(this.dataset.url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.is_active) {
                    this.classList.remove('bg-[var(--color-secondary-100)]', 'text-[var(--color-secondary-700)]');
                    this.classList.add('bg-[var(--color-primary-100)]', 'text-[var(--color-primary-700)]');
                    this.textContent = 'Hoạt động';
                } else {
                    this.classList.remove('bg-[var(--color-primary-100)]', 'text-[var(--color-primary-700)]');
                    this.classList.add('bg-[var(--color-secondary-100)]', 'text-[var(--color-secondary-700)]');
                    this.textContent = 'Không hoạt động';
                }
            });
        });
    });
});
</script>
@endpush
@endsection