@extends('frontend.layouts.master')

@section('title', __('Cart') . ' - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8 pb-24 lg:pb-8">
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-[var(--color-primary-600)]">{{ __('Cart') }}</h1>
        </div>

        <div id="cart-content">
        </div>
    </div>
</div>

<div class="lg:hidden mobile-checkout-bar">
    <div class="total cart-total">0đ</div>
    <a href="{{ route(app()->getLocale() . '.checkout') }}" class="checkout-btn">
        {{ __('Checkout') }}
    </a>
</div>

@push('styles')
<style>
    @media (max-width: 1024px) {
        .mobile-checkout-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: white;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.1);
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 50;
        }
        .mobile-checkout-bar .total {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--color-primary-600);
        }
        .mobile-checkout-bar .checkout-btn {
            background-color: var(--color-primary-600);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentLang = '{{ app()->getLocale() }}';
    const carts = JSON.parse(localStorage.getItem('carts')) || {};
    
    // Ensure current language exists in carts
    if (!carts[currentLang]) {
        carts[currentLang] = {};
        localStorage.setItem('carts', JSON.stringify(carts));
    }
    
    renderCart();
});

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
        updateCartCount();
        updateMobileCheckoutBar();
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
        const itemPrice = item.price && item.price < item.original_price ? item.price : item.original_price;
        const itemTotal = itemPrice * item.quantity;
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
                        ${item.price && item.price < item.original_price 
                            ? `<div class="text-sm text-gray-400 line-through">${numberFormat(item.original_price, currentLang)}</div>
                               <div class="text-base font-medium text-[var(--color-primary-600)]">${numberFormat(item.price, currentLang)}</div>`
                            : `<div class="text-base font-medium text-[var(--color-primary-600)]">${numberFormat(item.original_price, currentLang)}</div>`
                        }
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
                    ${numberFormat(itemTotal, currentLang)}
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
                                ${item.price && item.price < item.original_price 
                                    ? `<span class="text-gray-500 line-through text-sm">${numberFormat(item.original_price, currentLang)}</span>
                                       <div class="text-[var(--color-primary-600)] font-medium">${numberFormat(item.price, currentLang)}</div>`
                                    : `<div class="text-[var(--color-primary-600)] font-medium">${numberFormat(item.original_price, currentLang)}</div>`
                                }
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
                        ${numberFormat(itemTotal, currentLang)}
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
                <div class="text-2xl font-bold text-[var(--color-primary-600)] cart-total">${numberFormat(total, currentLang)}</div>
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
    updateMobileCheckoutBar();
}

function updateMobileCheckoutBar() {
    const currentLang = '{{ app()->getLocale() }}';
    const carts = JSON.parse(localStorage.getItem('carts')) || {};
    const currentCart = carts[currentLang] || {};
    
    let total = 0;
    for (const [id, item] of Object.entries(currentCart)) {
        const itemPrice = item.price && item.price < item.original_price ? item.price : item.original_price;
        total += itemPrice * item.quantity;
    }
    
    const mobileTotal = document.querySelector('.mobile-checkout-bar .cart-total');
    const desktopTotal = document.querySelector('.cart-total');
    
    if (mobileTotal) {
        mobileTotal.textContent = numberFormat(total, currentLang);
    }
    
    if (desktopTotal) {
        desktopTotal.textContent = numberFormat(total, currentLang);
    }
}

function removeItem(id) {
    showConfirm('{{ __("Are you sure you want to remove this item?") }}', () => {
        const currentLang = '{{ app()->getLocale() }}';
        const carts = JSON.parse(localStorage.getItem('carts')) || {};
        
        if (carts[currentLang]) {
            delete carts[currentLang][id];
            
            if (Object.keys(carts[currentLang]).length === 0) {
                delete carts[currentLang];
            }
            
            if (Object.keys(carts).length === 0) {
                localStorage.removeItem('carts');
            } else {
                localStorage.setItem('carts', JSON.stringify(carts));
            }
            
            renderCart();
            showToast('{{ __("Item removed from cart") }}', 'success');
        }
    });
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
    localStorage.setItem('carts', JSON.stringify(carts));
    renderCart();
    showToast('{{ __("Cart updated") }}', 'success');
}

function updateCartCount() {
    const currentLang = '{{ app()->getLocale() }}';
    const carts = JSON.parse(localStorage.getItem('carts')) || {};
    const currentCart = carts[currentLang] || {};
    
    const cartCountElement = document.querySelector('.cart-count');
    const itemCount = Object.keys(currentCart).length;
    
    if (cartCountElement) {
        cartCountElement.textContent = `(${itemCount} {{ __('items') }})`;
    }
}

function numberFormat(number, lang = '{{ app()->getLocale() }}') {
    switch(lang) {
        case 'vi':
            return new Intl.NumberFormat('vi-VN', { 
                style: 'currency', 
                currency: 'VND' 
            }).format(number).replace('₫', 'đ');
        case 'zh':
            return new Intl.NumberFormat('zh-CN', { 
                style: 'currency', 
                currency: 'CNY' 
            }).format(number);
        default:
            return new Intl.NumberFormat('vi-VN', { 
                style: 'currency', 
                currency: 'VND' 
            }).format(number).replace('₫', 'đ');
    }
}
</script>
@endpush
@endsection
