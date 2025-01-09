@extends('frontend.layouts.app')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Giỏ hàng của bạn</h1>
        </div>

        @if(Cart::isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="mb-4">
                    <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Giỏ hàng trống</h3>
                <p class="text-gray-500 mb-4">Hãy thêm sản phẩm vào giỏ hàng của bạn</p>
                <a href="{{ route(app()->getLocale() . '.products') }}" class="btn btn-primary">
                    Tiếp tục mua sắm
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-my-6 divide-y divide-gray-200">
                            @foreach(Cart::getContent() as $item)
                                <li class="py-6 flex">
                                    <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                        <img src="{{ $item->attributes->image }}" 
                             alt="{{ $item->name }}" 
                             class="w-full h-full object-center object-cover">
                                    </div>

                                    <div class="ml-4 flex-1 flex flex-col">
                                        <div>
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>
                                                    <a href="{{ route(app()->getLocale() . '.products.show', $item->attributes->slug) }}">
                                                        {{ $item->name }}
                                                    </a>
                                                </h3>
                                                <p class="ml-4">{{ number_format($item->price) }}đ</p>
                                            </div>
                                            @if($item->attributes->options)
                                                <p class="mt-1 text-sm text-gray-500">
                                                    {{ $item->attributes->options }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="flex-1 flex items-end justify-between text-sm">
                                            <div class="flex items-center">
                                                <label for="quantity" class="mr-2 text-gray-500">Số lượng</label>
                                                <select name="quantity" 
                                                        class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                                        data-item-id="{{ $item->id }}"
                                                        onchange="updateQuantity(this)">
                                                    @for($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="flex">
                                                <button type="button" 
                                                        class="font-medium text-primary-600 hover:text-primary-500"
                                                        onclick="removeItem('{{ $item->id }}')">
                                                    Xóa
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
                    <div class="flex justify-between text-base font-medium text-gray-900">
                        <p>Tổng tiền</p>
                        <p>{{ number_format(Cart::getTotal()) }}đ</p>
                    </div>
                    <p class="mt-0.5 text-sm text-gray-500">Đã bao gồm VAT nếu có</p>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <a href="{{ route(app()->getLocale() . '.checkout') }}" class="btn btn-primary w-full">
                        Thanh toán
                    </a>
                    <div class="mt-4 text-center">
                        <a href="{{ route(app()->getLocale() . '.products') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500">
                            Tiếp tục mua sắm
                            <span aria-hidden="true"> &rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function updateQuantity(select) {
    const itemId = select.dataset.itemId;
    const quantity = select.value;

    fetch(`/cart/${itemId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity })
    }).then(response => {
        if (response.ok) {
            window.location.reload();
        }
    });
}

function removeItem(itemId) {
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        fetch(`/cart/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }
}
</script>
@endpush
@endsection
