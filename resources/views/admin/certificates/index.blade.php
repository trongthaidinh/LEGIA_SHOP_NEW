@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Certificates') }}</h1>
        <a href="{{ route(app()->getLocale() . '.admin.certificates.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>{{ __('Add New') }}
        </a>
    </div>

    <!-- Language Filter -->
    <div class="mb-6">
        <form action="{{ route(app()->getLocale() . '.admin.certificates.index') }}" method="GET" class="flex items-center space-x-4">
            <label for="language" class="text-sm font-medium text-gray-700">{{ __('Language') }}:</label>
            <select name="language" id="language" class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200" onchange="this.form.submit()">
                <option value="vi" {{ $language === 'vi' ? 'selected' : '' }}>{{ __('Vietnamese') }}</option>
                <option value="zh" {{ $language === 'zh' ? 'selected' : '' }}>{{ __('Chinese') }}</option>
            </select>
        </form>
    </div>

    <!-- Certificates List -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200" id="sortable-table">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Image') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Description') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Order') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($certificates as $certificate)
                    <tr data-id="{{ $certificate->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ Storage::url($certificate->image) }}" alt="{{ $certificate->name }}" class="h-16 w-24 object-cover rounded">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $certificate->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 line-clamp-2">{{ $certificate->description }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button 
                                type="button" 
                                class="toggle-status px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $certificate->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                data-url="{{ route(app()->getLocale() . '.admin.certificates.toggle', $certificate) }}"
                            >
                                {{ $certificate->is_active ? __('Active') : __('Inactive') }}
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $certificate->order }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route(app()->getLocale() . '.admin.certificates.edit', $certificate) }}" class="text-primary-600 hover:text-primary-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route(app()->getLocale() . '.admin.certificates.destroy', $certificate) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure you want to delete this certificate?') }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            {{ __('No certificates found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $certificates->links() }}
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
                    this.classList.remove('bg-red-100', 'text-red-800');
                    this.classList.add('bg-green-100', 'text-green-800');
                    this.textContent = '{{ __("Active") }}';
                } else {
                    this.classList.remove('bg-green-100', 'text-green-800');
                    this.classList.add('bg-red-100', 'text-red-800');
                    this.textContent = '{{ __("Inactive") }}';
                }
            });
        });
    });
});
</script>
@endpush
@endsection 