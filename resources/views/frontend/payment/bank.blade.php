@extends('frontend.layouts.master')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-[var(--color-primary-600)] mb-8">{{ __('Bank Transfer Information') }}</h1>

        <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
            <!-- Order Information -->
            <div>
                <h2 class="text-lg font-semibold mb-4">{{ __('Order Information') }}</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">{{ __('Order Number') }}:</span>
                        <span class="font-medium">{{ $order->order_number }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">{{ __('Total Amount') }}:</span>
                        <span class="font-medium">{{ number_format($order->final_total) }}đ</span>
                    </div>
                </div>
            </div>

            <!-- Bank Account Information -->
            <div>
                <h2 class="text-lg font-semibold mb-4">{{ __('Bank Account Details') }}</h2>
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="grid grid-cols-1 gap-2">
                            <div>
                                <span class="text-gray-600">{{ __('Bank Name') }}:</span>
                                <span class="font-medium">VIETCOMBANK</span>
                            </div>
                            <div>
                                <span class="text-gray-600">{{ __('Account Number') }}:</span>
                                <span class="font-medium">1234567890</span>
                            </div>
                            <div>
                                <span class="text-gray-600">{{ __('Account Holder') }}:</span>
                                <span class="font-medium">CÔNG TY TNHH YẾN SÀO LEGIA'NEST</span>
                            </div>
                            <div>
                                <span class="text-gray-600">{{ __('Branch') }}:</span>
                                <span class="font-medium">{{ __('Dak Lak Branch') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Transfer Content -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Transfer Content') }}:
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" 
                                   value="LEGIANEST {{ $order->order_number }}"
                                   class="flex-1 rounded-lg border-gray-300 bg-gray-50" 
                                   readonly>
                            <button onclick="copyTransferContent(this)" 
                                    class="px-4 py-2 bg-[var(--color-primary-600)] text-white rounded-lg hover:bg-[var(--color-primary-700)] transition-colors">
                                {{ __('Copy') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="space-y-2">
                <h2 class="text-lg font-semibold">{{ __('Payment Instructions') }}</h2>
                <ol class="list-decimal list-inside space-y-2 text-sm text-gray-600">
                    <li>{{ __('Transfer the exact amount to the bank account above') }}</li>
                    <li>{{ __('Use the provided transfer content for reference') }}</li>
                    <li>{{ __('Keep your transfer receipt for verification') }}</li>
                    <li>{{ __('Your order will be processed after payment confirmation') }}</li>
                </ol>
            </div>

            <div class="text-center pt-4">
                <a href="{{ route(app()->getLocale() . '.home') }}" 
                   class="inline-block px-6 py-3 bg-[var(--color-primary-600)] text-white rounded-lg hover:bg-[var(--color-primary-700)] transition-colors">
                    {{ __('Back to Homepage') }}
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyTransferContent(button) {
    const input = button.previousElementSibling;
    input.select();
    document.execCommand('copy');
    
    // Change button text temporarily
    const originalText = button.textContent;
    button.textContent = '{{ __("Copied!") }}';
    setTimeout(() => {
        button.textContent = originalText;
    }, 2000);
}
</script>
@endpush
@endsection 