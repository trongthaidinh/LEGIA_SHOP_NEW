@extends('frontend.layouts.master')

@section('title', __('Checkout') . ' - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-[var(--color-primary-600)] mb-8">{{ __('Checkout') }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Billing Information') }}</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Full Name') }}</label>
                            <input type="text" id="fullName" class="w-full rounded-lg border-gray-300 focus:border-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Phone Number') }}</label>
                                <input type="tel" id="phone" class="w-full rounded-lg border-gray-300 focus:border-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email Address') }}</label>
                                <input type="email" id="email" class="w-full rounded-lg border-gray-300 focus:border-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Shipping Address') }}</h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Province/City') }}</label>
                                <select id="province" class="w-full rounded-lg border-gray-300 focus:border-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]">
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('District') }}</label>
                                <select id="district" class="w-full rounded-lg border-gray-300 focus:border-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]">
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Ward') }}</label>
                                <select id="ward" class="w-full rounded-lg border-gray-300 focus:border-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]">
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Street Address') }}</label>
                            <input type="text" id="address" class="w-full rounded-lg border-gray-300 focus:border-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Order Notes') }}</label>
                            <textarea id="notes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]" 
                                      placeholder="{{ __('Enter your notes here') }}"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Order Summary') }}</h2>
                    <div id="order-items" class="space-y-4 mb-4">
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ __('Subtotal') }}</span>
                            <span class="font-medium subtotal">0đ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ __('Shipping Fee') }}</span>
                            <span class="font-medium shipping-fee">0đ</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-[var(--color-primary-600)]">
                            <span>{{ __('Total Amount') }}</span>
                            <span class="total-amount">0đ</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 py-4 mt-4">
                        <h3 class="font-medium mb-3">{{ __('Payment Method') }}</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="payment" value="cod" checked
                                       class="text-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]">
                                <span class="ml-2">{{ __('Cash On Delivery') }}</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment" value="bank"
                                       class="text-[var(--color-primary-600)] focus:ring-[var(--color-primary-600)]">
                                <span class="ml-2">{{ __('Bank Transfer') }}</span>
                            </label>
                        </div>
                    </div>

                    <button onclick="placeOrder()" 
                            class="w-full mt-6 px-6 py-3 bg-[var(--color-primary-600)] text-white rounded-lg hover:bg-[var(--color-primary-700)] transition-colors">
                        {{ __('Place Order') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const API_PROVINCE = 'https://provinces.open-api.vn/api/p';
const API_DISTRICT = 'https://provinces.open-api.vn/api/p/{province_code}?depth=2';
const API_WARD = 'https://provinces.open-api.vn/api/d/{district_code}?depth=2';

document.addEventListener('DOMContentLoaded', function() {
    const currentLang = '{{ app()->getLocale() }}';
    const carts = JSON.parse(localStorage.getItem('carts')) || {};
    const currentCart = carts[currentLang] || {};
    
    if (Object.keys(currentCart).length === 0) {
        window.location.href = '{{ route(app()->getLocale() . ".cart") }}';
        return;
    }

    if (currentLang === 'vi') {
        loadProvinces();

        document.getElementById('province').addEventListener('change', function() {
            const provinceCode = this.value;
            if (provinceCode) {
                loadDistricts(provinceCode);
            } else {
                document.getElementById('district').innerHTML = '<option value="">{{ __("Select District") }}</option>';
                document.getElementById('ward').innerHTML = '<option value="">{{ __("Select Ward") }}</option>';
            }
        });

        document.getElementById('district').addEventListener('change', function() {
            const districtCode = this.value;
            if (districtCode) {
                loadWards(districtCode);
            } else {
                document.getElementById('ward').innerHTML = '<option value="">{{ __("Select Ward") }}</option>';
            }
        });
    }

    renderOrderItems();
});

async function loadProvinces() {
    try {
        const response = await fetch(API_PROVINCE);
        if (!response.ok) throw new Error('Network response was not ok');
        const provinces = await response.json();
        
        const select = document.getElementById('province');
        select.innerHTML = '<option value="">{{ __("Select Province/City") }}</option>';
        
        provinces.forEach(province => {
            select.innerHTML += `<option value="${province.code}">${province.name}</option>`;
        });
    } catch (error) {
        console.error('Error loading provinces:', error);
    }
}

async function loadDistricts(provinceCode) {
    try {
        const response = await fetch(API_DISTRICT.replace('{province_code}', provinceCode));
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        const select = document.getElementById('district');
        select.innerHTML = '<option value="">{{ __("Select District") }}</option>';
        
        data.districts.forEach(district => {
            select.innerHTML += `<option value="${district.code}">${district.name}</option>`;
        });
    } catch (error) {
        console.error('Error loading districts:', error);
    }
}

async function loadWards(districtCode) {
    try {
        const response = await fetch(API_WARD.replace('{district_code}', districtCode));
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        const select = document.getElementById('ward');
        select.innerHTML = '<option value="">{{ __("Select Ward") }}</option>';
        
        data.wards.forEach(ward => {
            select.innerHTML += `<option value="${ward.code}">${ward.name}</option>`;
        });
    } catch (error) {
        console.error('Error loading wards:', error);
    }
}

function renderOrderItems() {
    const currentLang = '{{ app()->getLocale() }}';
    const carts = JSON.parse(localStorage.getItem('carts')) || {};
    const currentCart = carts[currentLang] || {};
    
    
    const orderItems = document.getElementById('order-items');
    let subtotal = 0;

    let html = '';
    if (Object.keys(currentCart).length > 0) {
        for (const [id, item] of Object.entries(currentCart)) {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            html += `
                <div class="flex items-center gap-4">
                    <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-lg">
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-gray-900 truncate">${item.name}</h4>
                        <div class="text-sm text-gray-500">${item.quantity} x ${numberFormat(item.price)}đ</div>
                    </div>
                    <div class="font-medium text-[var(--color-primary-600)]">${numberFormat(itemTotal)}đ</div>
                </div>
            `;
        }
    } else {
        html = '<div class="text-gray-500">{{ __("No items in cart") }}</div>';
    }

    orderItems.innerHTML = html;
    document.querySelector('.subtotal').textContent = `${numberFormat(subtotal)}đ`;
    
    const shippingFee = subtotal >= 500000 ? 0 : 30000;
    document.querySelector('.shipping-fee').textContent = `${numberFormat(shippingFee)}đ`;
    
    const total = subtotal + shippingFee;
    document.querySelector('.total-amount').textContent = `${numberFormat(total)}đ`;
}

function numberFormat(number) {
    return new Intl.NumberFormat('vi-VN').format(number);
}

async function placeOrder() {
    const fullName = document.getElementById('fullName').value;
    const phone = document.getElementById('phone').value;
    const email = document.getElementById('email').value;
    const address = document.getElementById('address').value;
    const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
    
    if (!fullName || !phone || !email || !address) {
        alert("{{ __('Please fill in all required fields') }}");
        return;
    }

    let shippingAddress = '';
    let province, district, ward;
    if ('{{ app()->getLocale() }}' === 'vi') {
        province = document.getElementById('province');
        district = document.getElementById('district');
        ward = document.getElementById('ward');
        
        if (!province.value || !district.value || !ward.value) {
            alert("{{ __('Please select full address information') }}");
            return;
        }
        
        shippingAddress = `${address}, ${ward.options[ward.selectedIndex].text}, ${district.options[district.selectedIndex].text}, ${province.options[province.selectedIndex].text}`;
    } else {
        shippingAddress = address;
    }

    const orderData = {
        customer_info: {
            full_name: fullName,
            phone: phone,
            email: email
        },
        shipping_address: shippingAddress,
        province: province,
        district: district,
        ward: ward,
        payment_method: paymentMethod,
        notes: document.getElementById('notes').value,
        items: Object.entries(JSON.parse(localStorage.getItem('carts'))['{{ app()->getLocale() }}'] || {}).map(([id, item]) => ({
            ...item,
            id: parseInt(id)
        })),
        language: '{{ app()->getLocale() }}'
    };

    try {
        const response = await fetch('{{ route(app()->getLocale() . ".checkout.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(orderData)
        });

        const result = await response.json();

        if (result.success) {
            if (paymentMethod === 'bank') {
                window.location.href = '{{ route(app()->getLocale() . ".payment.bank") }}?order_id=' + result.order_id;
            } else {
                window.location.href = '{{ route(app()->getLocale() . ".checkout.success") }}?order_id=' + result.order_id;
            }
            const currentLang = '{{ app()->getLocale() }}';
            const carts = JSON.parse(localStorage.getItem('carts')) || {};
            delete carts[currentLang];
            if (Object.keys(carts).length === 0) {
                localStorage.removeItem('carts');
            } else {
                localStorage.setItem('carts', JSON.stringify(carts));
            }
        } else {
            alert(result.message || "{{ __('Order placement failed. Please try again.') }}");
        }
    } catch (error) {
        console.error('Error placing order:', error);
        alert("{{ __('An error occurred. Please try again.') }}");
    }
}

function numberFormat(number) {
    return new Intl.NumberFormat('vi-VN').format(number);
}
</script>
@endpush
@endsection 