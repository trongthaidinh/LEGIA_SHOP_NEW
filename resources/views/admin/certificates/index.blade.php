@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-certificate mr-2"></i> Chứng chỉ
                </h3>
                <a href="{{ route(app()->getLocale() . '.admin.certificates.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>Thêm mới
                </a>
            </div>
        </div>

        <div>
            <!-- Certificates List -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[var(--color-primary-100)]" id="sortable-table">
                    <thead class="bg-[var(--color-primary-50)]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Ảnh</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Tên</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Mô tả</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Thứ tự</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[var(--color-primary-100)]">
                        @forelse($certificates as $certificate)
                            <tr data-id="{{ $certificate->id }}" class="hover:bg-[var(--color-primary-50)] transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ Storage::url($certificate->image) }}" alt="{{ $certificate->name }}" class="h-32 w-24 object-cover rounded-md shadow-sm">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-[var(--color-primary-900)]">{{ $certificate->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-[var(--color-primary-700)] line-clamp-2">{{ $certificate->description }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button 
                                        type="button" 
                                        class="toggle-status px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $certificate->is_active ? 'bg-[var(--color-primary-100)] text-[var(--color-primary-700)]' : 'bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)]' }}"
                                        data-url="{{ route(app()->getLocale() . '.admin.certificates.toggle', $certificate) }}"
                                    >
                                        {{ $certificate->is_active ? __('Active') : __('Inactive') }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--color-primary-600)]">
                                    {{ $certificate->order }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route(app()->getLocale() . '.admin.certificates.edit', $certificate) }}" 
                                           class="inline-flex items-center p-1.5 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] hover:bg-[var(--color-primary-200)] rounded-md transition-colors duration-200">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route(app()->getLocale() . '.admin.certificates.destroy', $certificate) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center p-1.5 bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)] hover:bg-[var(--color-secondary-200)] rounded-md transition-colors duration-200" 
                                                    onclick="return confirm('{{ __('Are you sure you want to delete this certificate?') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-[var(--color-primary-500)]">
                                    {{ __('No certificates found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($certificates->hasPages())
            <div class="px-6 py-4 border-t border-[var(--color-primary-100)]">
                {{ $certificates->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Sortable
    new Sortable(document.querySelector('#sortable-table tbody'), {
        handle: 'tr',
        animation: 150,
        onEnd: function(evt) {
            const items = [...evt.to.children].map((tr, index) => ({
                id: tr.dataset.id,
                order: index
            }));

            // Update order via AJAX
            fetch('{{ route(app()->getLocale() . ".admin.certificates.order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ orders: items })
            });
        }
    });

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
                    this.textContent = '{{ __("Active") }}';
                } else {
                    this.classList.remove('bg-[var(--color-primary-100)]', 'text-[var(--color-primary-700)]');
                    this.classList.add('bg-[var(--color-secondary-100)]', 'text-[var(--color-secondary-700)]');
                    this.textContent = '{{ __("Inactive") }}';
                }
            });
        });
    });
});
</script>
@endpush
@endsection