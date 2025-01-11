@extends('frontend.layouts.master')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-[var(--color-primary-600)]">{{ __('Cart') }}</h1>
            <span class="text-[var(--color-primary-600)] cart-count">(0 {{ __('items') }})</span>
        </div>

        <div id="cart-content">
        </div>
    </div>
</div>
 
@push('scripts')
<script>
function renderCart() {
    const currentLang = '{{ app()->getLocale() }}';
    const carts = JSON.parse(localStorage.getItem('carts')) || {};
    const currentCart = carts[currentLang] || {};
    const cartContent = document.getElementById('cart-content');
    
    if (Object.keys(currentCart).length === 0) {
        cartContent.innerHTML = `
            <div class="text-center py-8">
                <div class="mb-4">
                    <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Empty Cart') }}</h3>
                <p class="text-gray-500 mb-4">{{ __('Empty Cart Message') }}</p>
                <a href="{{ route(app()->getLocale() . '.products') }}" class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-600)] text-white rounded-md hover:bg-[var(--color-primary-700)]">
                    {{ __('Continue Shopping') }}
                </a>
            </div>
        `;
        return;
    }

    let html = `
        <div class="hidden lg:block"> <!-- Desktop view -->
            <div class="bg-white rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left py-4 px-6 text-sm font-medium text-gray-600">{{ __('Product') }}</th>
                            <th class="text-right py-4 px-6 text-sm font-medium text-gray-600">{{ __('Price') }}</th>
                            <th class="text-center py-4 px-6 text-sm font-medium text-gray-600">{{ __('Quantity') }}</th>
                            <th class="text-right py-4 px-6 text-sm font-medium text-gray-600">{{ __('Total') }}</th>
                            <th class="w-16"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
    `;

    let mobileHtml = `
        <div class="lg:hidden space-y-4"> <!-- Mobile view -->
    `;

    let total = 0;
    for (const [id, item] of Object.entries(currentCart)) {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        // Desktop view
        html += `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="py-6 px-6">
                    <div class="flex items-center">
                        <img src="${item.image}" alt="${item.name}" 
                             class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                        <div class="ml-6">
                            <h3 class="text-base font-medium text-gray-900">${item.name}</h3>
                            <p class="mt-1 text-sm text-gray-500">SKU: ${id}</p>
                        </div>
                    </div>
                </td>
                <td class="py-6 px-6">
                    <div class="text-right">
                        <div class="text-sm text-gray-500 line-through">${numberFormat(item.original_price)}đ</div>
                        <div class="text-base font-medium text-[var(--color-primary-600)]">${numberFormat(item.price)}đ</div>
                    </div>
                </td>
                <td class="py-6 px-6">
                    <div class="flex items-center justify-center space-x-3">
                        <button onclick="updateQuantity('${id}', ${item.quantity - 1})"
                                class="w-8 h-8 rounded-full bg-[var(--color-primary-50)] text-[var(--color-primary-600)] flex items-center justify-center hover:bg-[var(--color-primary-100)] transition-colors">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <span class="w-12 text-center font-medium">${item.quantity}</span>
                        <button onclick="updateQuantity('${id}', ${item.quantity + 1})"
                                class="w-8 h-8 rounded-full bg-[var(--color-primary-50)] text-[var(--color-primary-600)] flex items-center justify-center hover:bg-[var(--color-primary-100)] transition-colors">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                </td>
                <td class="py-6 px-6 text-right font-medium text-[var(--color-primary-600)]">
                    ${numberFormat(itemTotal)}đ
                </td>
                <td class="py-6 px-6">
                    <button onclick="removeItem('${id}')" 
                            class="text-gray-400 hover:text-red-500 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        `;

        // Mobile view
        mobileHtml += `
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-start space-x-4">
                        <img src="${item.image}" alt="${item.name}" class="w-20 h-20 object-cover rounded-md">
                        <div>
                            <h3 class="font-medium text-gray-900">${item.name}</h3>
                            <div class="mt-1">
                                <span class="text-gray-500 line-through text-sm">${numberFormat(item.original_price)}đ</span>
                                <div class="text-[var(--color-primary-600)] font-medium">${numberFormat(item.price)}đ</div>
                            </div>
                        </div>
                    </div>
                    <button onclick="removeItem('${id}')" class="text-red-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <div class="flex items-center space-x-2">
                        <button class="w-8 h-8 rounded-full bg-[var(--color-primary-600)] text-white flex items-center justify-center hover:bg-[var(--color-primary-700)]"
                                onclick="updateQuantity('${id}', ${item.quantity - 1})">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="mx-4">${item.quantity}</span>
                        <button class="w-8 h-8 rounded-full bg-[var(--color-primary-600)] text-white flex items-center justify-center hover:bg-[var(--color-primary-700)]"
                                onclick="updateQuantity('${id}', ${item.quantity + 1})">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="font-medium text-[var(--color-primary-600)]">
                        ${numberFormat(itemTotal)}đ
                    </div>
                </div>
            </div>
        `;
    }

    html += `
                </tbody>
            </table>
        </div>

        <div class="mt-8 bg-white rounded-lg p-6">
            <div class="flex items-center justify-between border-b border-gray-200 pb-6 mb-6">
                <div class="text-base text-gray-600">{{ __('Total') }}</div>
                <div class="text-2xl font-bold text-[var(--color-primary-600)]">${numberFormat(total)}đ</div>
            </div>
            <div class="flex justify-end space-x-4">
                <a href="{{ route(app()->getLocale() . '.products') }}" 
                   class="px-6 py-3 text-[var(--color-primary-600)] border border-[var(--color-primary-600)] rounded-lg hover:bg-[var(--color-primary-50)] transition-colors">
                    {{ __('Continue Shopping') }}
                </a>
                <a href="{{ route(app()->getLocale() . '.checkout') }}" 
                   class="px-6 py-3 bg-[var(--color-primary-600)] text-white rounded-lg hover:bg-[var(--color-primary-700)] transition-colors">
                    {{ __('Checkout') }}
                </a>
            </div>
        </div>
    </div>
`;

    mobileHtml += `</div>`;

    cartContent.innerHTML = html + mobileHtml;
    updateCartCount();
}

function updateQuantity(id, newQuantity) {
    if (newQuantity < 1) {
        showToast('{{ __("Quantity cannot be less than 1") }}', 'error');
        return;
    }
    
    const currentLang = '{{ app()->getLocale() }}';
    const carts = JSON.parse(localStorage.getItem('carts')) || {};
    
    if (!carts[currentLang]) {
        carts[currentLang] = {};
    }
    
    carts[currentLang][id].quantity = newQuantity;
    updateCart(carts);
    renderCart();
    showToast('{{ __("Cart updated") }}', 'success');
}

function removeItem(id) {
    showConfirm('{{ __("Are you sure you want to remove this item?") }}', () => {
        const currentLang = '{{ app()->getLocale() }}';
        const carts = JSON.parse(localStorage.getItem('carts')) || {};
        
        if (carts[currentLang]) {
            delete carts[currentLang][id];
            updateCart(carts);
            renderCart();
            showToast('{{ __("Product removed from cart") }}', 'info');
        }
    });
}

function numberFormat(number) {
    return new Intl.NumberFormat('vi-VN').format(number);
}

// Initialize cart on page load
document.addEventListener('DOMContentLoaded', renderCart);
</script>
@endpush
@endsection
