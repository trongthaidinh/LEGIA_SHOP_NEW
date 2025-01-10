@extends('frontend.layouts.master')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto text-center">
        <div class="bg-white rounded-lg shadow-sm p-8">
            <h1 class="text-2xl font-bold text-[var(--color-primary-600)] mb-4">{{ __('Order Placed Successfully!') }}</h1>
            <p class="text-gray-600 mb-4">{{ __('Thank you for your order.') }}</p>
            <p class="font-medium mb-2">{{ __('Order Number') }}: {{ $order->order_number }}</p>
            <p class="text-gray-600">{{ __('We will contact you shortly to confirm your order.') }}</p>
            
            <a href="{{ route(app()->getLocale() . '.home') }}" 
               class="inline-block mt-6 px-6 py-3 bg-[var(--color-primary-600)] text-white rounded-lg hover:bg-[var(--color-primary-700)] transition-colors">
                {{ __('Continue Shopping') }}
            </a>
        </div>
    </div>
</div>
@endsection 