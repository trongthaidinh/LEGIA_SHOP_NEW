@extends('frontend.layouts.master')

@section('title', $product->name . ' - ' . config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product gallery -->
        <div class="border border-[var(--color-primary-200)] rounded-lg p-4">
            <div class="aspect-w-1 aspect-h-1 mb-4">
                <img id="mainImage" src="{{ Storage::url($product->featured_image) }}" 
                     alt="{{ $product->name }}" 
                     class="h-full w-full object-contain object-center">
            </div>

            <!-- @if($product->gallery)
            <div class="grid grid-cols-4 gap-4">
                <div>
                    <button onclick="changeMainImage('{{ Storage::url($product->featured_image) }}')" 
                            class="w-full aspect-w-1 aspect-h-1 rounded border-2 border-[var(--color-primary-200)] hover:border-[var(--color-primary-600)] overflow-hidden">
                        <img src="{{ Storage::url($product->featured_image) }}" 
                             alt="{{ $product->name }}" 
                             class="h-full w-full object-contain object-center">
                    </button>
                </div>
                @foreach(json_decode($product->gallery) as $image)
                <div>
                    <button onclick="changeMainImage('{{ Storage::url($image) }}')" 
                            class="w-full aspect-w-1 aspect-h-1 rounded border-2 border-[var(--color-primary-200)] hover:border-[var(--color-primary-600)] overflow-hidden">
                        <img src="{{ Storage::url($image) }}" 
                             alt="{{ $product->name }}" 
                             class="h-full w-full object-contain object-center">
                    </button>
                </div>
                @endforeach
            </div>
            @endif -->
        </div>

        <!-- Product details -->
        <div>
            @if($product->sale_price && $product->price > $product->sale_price)
                <div class="mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded text-sm font-medium bg-[var(--color-secondary-500)] text-white">
                        -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                    </span>
                </div>
            @endif

            <div class="flex flex-col border-b border-[var(--color-primary-200)] mb-4">
                <h1 class="text-3xl font-[800] text-[var(--color-primary-600)] pb-2">{{ $product->name }}</h1>
                <div class="text-gray-600 pb-4">{{ $product->description }}</div>
            </div>
            
            <!-- Price -->
            <div class="mt-4 flex items-center gap-4">
                <p class="text-2xl font-bold text-[var(--color-primary-600)]">{{ number_format($product->sale_price) }}đ</p>
                @if($product->price > $product->sale_price)
                    <p class="text-sm text-gray-400 line-through">{{ number_format($product->price) }}đ</p>
                @endif
            </div>

            <!-- Product code -->
            <div class="mt-4">
                <p class="text-sm text-gray-600">
                    {{ __('product_code') }}: <span class="font-medium">{{ $product->sku }}</span>
                </p>
            </div>

            <!-- Features -->
            <div class="mt-4">
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-check-circle text-[var(--color-primary-600)]"></i>
                        <span>{{ __('pure_product') }}</span>
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-check-circle text-[var(--color-primary-600)]"></i>
                        <span>{{ __('no_preservatives') }}</span>
                    </li>
                </ul>
            </div>

            <!-- Quantity and Add to cart -->
            <div class="mt-6">
                <div class="flex items-center gap-4">
                    <label class="text-sm text-gray-600">{{ __('quantity') }}:</label>
                    <div class="flex items-center">
                        <button onclick="decrementQuantity()" 
                                class="w-8 h-8 flex items-center justify-center bg-[var(--color-primary-600)] text-white rounded-l hover:bg-[var(--color-primary-700)]">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <input type="number" id="quantity" name="quantity" value="1" min="1"
                               class="w-16 h-8 border-t border-b border-gray-300 text-center focus:outline-none focus:ring-0">
                        <button onclick="incrementQuantity()"
                                class="w-8 h-8 flex items-center justify-center bg-[var(--color-primary-600)] text-white rounded-r hover:bg-[var(--color-primary-700)]">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                    @if($product->stock > 0)
                        <span class="text-sm text-gray-500">({{ $product->stock }} {{ __('products_in_stock') }})</span>
                    @else
                        <span class="text-sm text-red-500">{{ __('out_of_stock') }}</span>
                    @endif
                </div>

                <div class="flex flex-col gap-4 mt-6">
                    <form action="{{ route(app()->getLocale() . '.cart.add') }}" method="POST" class="contents">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit"
                                class="w-full bg-[var(--color-primary-600)] text-white px-6 py-3 rounded-lg hover:bg-[var(--color-primary-700)] transition-colors">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            {{ __('add_to_cart') }}
                        </button>
                    </form>

                    <div class="grid grid-cols-2 gap-4">
                        <a href="tel:077 233 2255" class="flex items-center justify-center gap-2 bg-white border-2 border-[var(--color-primary-600)] text-[var(--color-primary-600)] px-6 py-3 rounded-lg hover:bg-[var(--color-primary-50)] transition-colors">
                            <i class="fas fa-phone"></i>
                            077 233 2255
                        </a>
                        <button type="button" onclick="window.open('https://zalo.me/077233225', '_blank')"
                                class="flex items-center justify-center gap-2 bg-white border-2 border-[var(--color-primary-600)] text-[var(--color-primary-600)] px-6 py-3 rounded-lg hover:bg-[var(--color-primary-50)] transition-colors">
                            <i class="fas fa-comment-dots"></i>
                            ZALO
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mt-12 bg-gray-100 rounded-lg p-6">
        <div class="flex gap-4 mb-6">
            <button onclick="openTab('description')" 
                    class="tab-btn active px-8 py-3 text-md font-medium rounded-lg bg-transparent text-[var(--color-primary-600)] border border-[var(--color-primary-600)]">
                {{ __('product_information') }}
            </button>
            <button onclick="openTab('reviews')"
                    class="tab-btn px-8 py-3 text-md font-medium rounded-lg bg-transparent text-[var(--color-primary-600)] border border-[var(--color-primary-600)]">
                {{ __('customer_reviews') }}
            </button>
        </div>

        <!-- Product Information Tab -->
        <div id="description" class="tab-content p-8 rounded-lg">
            <div class="prose prose-sm max-w-none">
                {!! $product->content !!}
            </div>
        </div>

        <!-- Reviews Tab -->
        <div id="reviews" class="tab-content hidden p-8 rounded-lg">
            <div class="mx-auto">
                <!-- Review Form -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('write_review') }}</h3>
                    <form action="{{ route(app()->getLocale() . '.products.review', $product->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="reviewer_name" class="block text-sm font-medium text-gray-700">{{ __('your_name') }}</label>
                                <input type="text" name="reviewer_name" id="reviewer_name" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                            </div>
                            <div>
                                <label for="reviewer_email" class="block text-sm font-medium text-gray-700">{{ __('your_email') }}</label>
                                <input type="email" name="reviewer_email" id="reviewer_email" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                            </div>
                        </div>

                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700">{{ __('your_review') }}</label>
                            <textarea name="comment" id="comment" rows="4" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="px-6 py-2 text-sm font-medium bg-[var(--color-primary-600)] text-white rounded-lg hover:bg-[var(--color-primary-700)]">
                                {{ __('submit_review') }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Reviews List -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('customer_reviews') }}</h3>
                    @forelse($product->reviews()->approved()->latest()->get() as $review)
                        <div class="border-b border-gray-200 pb-4 mb-4">
                            <div class="flex items-start">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $review->reviewer_name }}</h4>
                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ $review->created_at->diffForHumans() }}
                                    </div>
                                    <div class="mt-2 text-sm text-gray-600">
                                        {{ $review->comment }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">{{ __('no_reviews_yet') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<style>
    /* Hide number input arrows */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush

@push('scripts')
<script>
    // Change main image with zoom effect
    function changeMainImage(src) {
        const mainImage = document.getElementById('mainImage');
        mainImage.style.transform = 'scale(0.95)';
        mainImage.style.transition = 'transform 0.2s ease-in-out';
        
        setTimeout(() => {
            mainImage.src = src;
            mainImage.style.transform = 'scale(1)';
        }, 200);
    }

    // Quantity controls
    function incrementQuantity() {
        const input = document.getElementById('quantity');
        input.value = parseInt(input.value) + 1;
    }

    function decrementQuantity() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    // Tabs
    function openTab(tabName) {
        // Hide all tab content
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Show selected tab content
        document.getElementById(tabName).classList.remove('hidden');

        // Update tab buttons
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.classList.remove('bg-[var(--color-primary-600)]', 'text-white');
            button.classList.add('bg-transparent', 'text-[var(--color-primary-600)]', 'border', 'border-[var(--color-primary-600)]');
        });

        // Highlight active tab button
        event.currentTarget.classList.remove('bg-transparent', 'text-[var(--color-primary-600)]', 'border', 'border-[var(--color-primary-600)]');
        event.currentTarget.classList.add('bg-[var(--color-primary-600)]', 'text-white');
    }

    // Initialize first tab as active
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.tab-btn').click();
    });
</script>
@endpush
