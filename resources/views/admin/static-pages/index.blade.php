@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Static Pages') }}</h1>
        <div class="flex items-center space-x-4">
            <!-- Language Filter -->
            <form action="{{ route(app()->getLocale() . '.admin.static-pages.index') }}" method="GET" class="flex items-center space-x-4">
                <label for="locale" class="text-sm font-medium text-gray-700">{{ __('Language') }}:</label>
                <select name="locale" id="locale" class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200" onchange="this.form.submit()">
                    <option value="vi" {{ $locale === 'vi' ? 'selected' : '' }}>{{ __('Vietnamese') }}</option>
                    <option value="zh" {{ $locale === 'zh' ? 'selected' : '' }}>{{ __('Chinese') }}</option>
                </select>
            </form>

            <a href="{{ route(app()->getLocale() . '.admin.static-pages.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>{{ __('Add New') }}
            </a>
        </div>
    </div>

    <!-- Static Pages List -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Title') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Slug') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Last Updated') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pages as $page)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $page->title }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500">{{ $page->slug }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button 
                                type="button" 
                                class="toggle-status px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $page->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                data-url="{{ route(app()->getLocale() . '.admin.static-pages.toggle', $page) }}"
                            >
                                {{ $page->is_active ? __('Active') : __('Inactive') }}
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $page->updated_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route(app()->getLocale() . '.admin.static-pages.edit', $page) }}" class="text-primary-600 hover:text-primary-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route(app()->getLocale() . '.admin.static-pages.destroy', $page) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure you want to delete this page?') }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            {{ __('No static pages found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $pages->links() }}
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