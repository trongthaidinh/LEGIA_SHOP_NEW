@extends('frontend.layouts.master')

@section('title', __('search_results') . ' - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">
                {{ __('search_results') }}
                @if(request('q'))
                    <span class="text-[var(--color-primary-600)] ml-2">"{{ request('q') }}"</span>
                @endif
            </h1>
        </div>
        
        <!-- Search Info -->
        <div class="mt-4 text-sm text-gray-600">
            @if($products->total() > 0)
                {{ __('showing_results', [
                    'start' => $products->firstItem(),
                    'end' => $products->lastItem(),
                    'total' => $products->total()
                ]) }}
            @endif
        </div>
    </div>

    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-2 md:gap-4 lg:gap-6">
            @foreach($products as $product)
                @include('frontend.partials.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $products->appends(request()->query())->links('frontend.components.pagination') }}
        </div>
    @else
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <i class="fas fa-search text-6xl text-gray-400 mb-4"></i>
            <p class="text-2xl text-gray-600 mb-4">{{ __('no_products_found') }}</p>
            <p class="text-gray-500 mb-6">{{ __('try_different_search') }}</p>
            <a href="{{ route(app()->getLocale() . '.products') }}" 
               class="inline-block px-8 py-3 bg-[var(--color-primary-600)] text-white rounded-full hover:bg-[var(--color-primary-700)] transition-colors">
                {{ __('back_to_products') }}
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortSelect = document.getElementById('sort-select');
    
    // Set current sort option if exists in URL
    const currentSort = new URLSearchParams(window.location.search).get('sort');
    if (currentSort) {
        sortSelect.value = currentSort;
    }

    // Handle sort change
    sortSelect.addEventListener('change', function() {
        const currentUrl = new URL(window.location);
        const selectedSort = this.value;

        if (selectedSort) {
            currentUrl.searchParams.set('sort', selectedSort);
        } else {
            currentUrl.searchParams.delete('sort');
        }

        window.location.href = currentUrl.toString();
    });
});
</script>
@endpush

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
