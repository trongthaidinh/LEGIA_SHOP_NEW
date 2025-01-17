@extends('frontend.layouts.master')

@section('title', __('products') . ' - ' . config('app.name'))

@section('content')
<div class="container mx-auto py-8 px-4 max-w-7xl">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="w-full lg:w-1/4 lg:min-w-[280px]">
            <form id="filter-form" class="bg-white rounded-lg shadow-sm p-6 lg:sticky lg:top-4">
                <div class="space-y-6">
                    <!-- Categories -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('categories') }}</h3>
                        <div class="space-y-2">
                            @foreach($categories as $category)
                            <div class="flex items-center">
                                <input type="checkbox"
                                    id="category-{{ $category->id }}"
                                    name="categories[]"
                                    value="{{ $category->id }}"
                                    @checked(in_array($category->id, explode(',', request('categories', ''))))
                                class="h-4 w-4 text-[var(--color-primary-600)] border-gray-300 rounded focus:ring-[var(--color-primary-600)]">
                                <label for="category-{{ $category->id }}" class="ml-2 text-sm text-gray-700">
                                    {{ $category->name }} ({{ $category->products_count }})
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('price_range') }}</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="min-price" class="block text-sm text-gray-700 mb-1">{{ __('min_price') }}</label>
                                <input type="number"
                                    id="min-price"
                                    name="min_price"
                                    value="{{ request('min_price') }}"
                                    min="{{ $priceRange->min_price }}"
                                    max="{{ $priceRange->max_price }}"
                                    placeholder="{{ number_format($priceRange->min_price) }} {{ app()->getLocale() === 'zh' ? '¥' : '₫' }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]">
                            </div>
                            <div>
                                <label for="max-price" class="block text-sm text-gray-700 mb-1">{{ __('max_price') }}</label>
                                <input type="number"
                                    id="max-price"
                                    name="max_price"
                                    value="{{ request('max_price') }}"
                                    min="{{ $priceRange->min_price }}"
                                    max="{{ $priceRange->max_price }}"
                                    placeholder="{{ number_format($priceRange->max_price) }} {{ app()->getLocale() === 'zh' ? '¥' : '₫' }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]">
                            </div>
                        </div>
                    </div>

                    <!-- Sort By -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('sort_by') }}</h3>
                        <select name="sort"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]">
                            <option value="latest" @selected(request('sort')=='latest' )>{{ __('latest') }}</option>
                            <option value="price_asc" @selected(request('sort')=='price_asc' )>{{ __('price_low_to_high') }}</option>
                            <option value="price_desc" @selected(request('sort')=='price_desc' )>{{ __('price_high_to_low') }}</option>
                            <option value="name_asc" @selected(request('sort')=='name_asc' )>{{ __('name_a_to_z') }}</option>
                            <option value="name_desc" @selected(request('sort')=='name_desc' )>{{ __('name_z_to_a') }}</option>
                        </select>
                    </div>

                    <!-- Apply Filters Button -->
                    <button type="button"
                        id="apply-filter"
                        class="w-full bg-[var(--color-primary-600)] text-white py-2 px-4 rounded-md hover:bg-[var(--color-primary-700)] transition duration-150 ease-in-out">
                        {{ __('apply_filters') }}
                    </button>
                </div>
            </form>
        </aside>

        <!-- Products Grid -->
        <div class="w-full lg:w-3/4">
            <!-- Grid Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">{{ __('products') }}</h2>
                <span class="text-xs md:text-sm text-gray-500 mt-2 md:mt-0">
                    {{ __('showing') }} {{ $products->firstItem() }} - {{ $products->lastItem() }} {{ __('of') }} {{ $products->total() }} {{ __('products') }}
                </span>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-2 md:gap-4 lg:gap-6">
                @forelse($products as $product)
                @include('frontend.partials.product-card', ['product' => $product])
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">{{ __('no_products_found') }}</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="flex justify-end mt-8">
                {{ $products->links('vendor.pagination.tailwind') }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .pagination {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }

    .pagination .page-item {
        @apply rounded-md border border-gray-300 text-gray-500 hover:bg-gray-50 transition duration-150 ease-in-out;
    }

    .pagination .page-item.active .page-link {
        @apply bg-[var(--color-primary-600)] text-white;
    }

    .pagination .page-link {
        @apply px-3 py-2 text-sm block;
    }

    .pagination .page-item.disabled .page-link {
        @apply text-gray-300 cursor-not-allowed;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Price formatting function
        function formatCurrency(value) {
            // Remove non-numeric characters
            const numericValue = value.replace(/[^\d]/g, '');
            
            // Convert to number
            const number = parseFloat(numericValue);
            
            // Check if it's a valid number
            if (isNaN(number)) return '';
            
            // Format with commas
            return number.toLocaleString('vi-VN');
        }

        // Price input formatting
        const minPriceInput = document.getElementById('min-price');
        const maxPriceInput = document.getElementById('max-price');

        // Format on input
        [minPriceInput, maxPriceInput].forEach(input => {
            input.addEventListener('input', function(e) {
                // Store current cursor position
                const start = this.selectionStart;
                const end = this.selectionEnd;

                // Format the value
                this.value = formatCurrency(this.value);

                // Restore cursor position
                this.setSelectionRange(start, end);
            });
        });

        // Apply filter button
        const applyFilterBtn = document.querySelector('#apply-filter');
        applyFilterBtn.addEventListener('click', function() {
            // Prepare parameters for redirect
            const params = new URLSearchParams(window.location.search);

            // Remove type parameter when applying filters
            params.delete('type');

            // Collect category values
            const categoryCheckboxes = document.querySelectorAll('input[name="categories[]"]:checked');
            const categoryValues = Array.from(categoryCheckboxes).map(cb => cb.value);

            // Remove existing category parameters
            params.delete('categories');
            
            // Add selected categories
            if (categoryValues.length > 0) {
                params.set('categories', categoryValues.join(','));
            }

            // Get price values (remove non-numeric characters)
            const minPrice = minPriceInput.value.replace(/[^\d]/g, '');
            const maxPrice = maxPriceInput.value.replace(/[^\d]/g, '');

            // Update or remove price parameters
            if (minPrice) params.set('min_price', minPrice);
            else params.delete('min_price');

            if (maxPrice) params.set('max_price', maxPrice);
            else params.delete('max_price');

            // Update sort parameter
            const sortSelect = document.querySelector('select[name="sort"]');
            if (sortSelect.value) {
                params.set('sort', sortSelect.value);
            } else {
                params.delete('sort');
            }

            // Redirect with updated parameters
            window.location.href = `{{ route(app()->getLocale() . '.products') }}?${params.toString()}`;
        });

        // Debug: Log filter parameters
        console.log('Current URL Parameters:', Object.fromEntries(new URLSearchParams(window.location.search)));
    });
</script>
@endpush
@endsection