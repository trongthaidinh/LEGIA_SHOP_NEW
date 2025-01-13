<div class="group relative bg-white rounded-lg overflow-hidden border border-[var(--color-primary-200)] hover:border-[var(--color-primary-500)] transition-colors duration-300">
    <div class="p-4 sm:p-6">
        <!-- Product Image -->
        <div class="aspect-w-1 aspect-h-1">
            <img src="{{ Storage::url($product->featured_image) }}" 
                 alt="{{ $product->name }}" 
                 class="object-contain w-full h-full transform group-hover:scale-105 transition-transform duration-500">
        </div>

        <!-- Product Info -->
        <div class="space-y-2 mt-2 sm:mt-4">
            <h3 class="text-base sm:text-xl font-bold text-[var(--color-primary-700)]">{{ $product->name }}</h3>
            <div class="flex items-center gap-1 sm:gap-2 flex-wrap">
                @php
                    $locale = app()->getLocale();
                    $currencySymbol = $locale === 'zh' ? '¥' : '₫';
                    $price = $product->price;
                    $salePrice = $product->sale_price && $product->sale_price < $product->price ? $product->sale_price : null;
                @endphp

                @if($price)
                    <span class="text-[var(--color-primary-600)] text-sm sm:text-lg font-medium">
                        {{ number_format($salePrice ?: $price, 0, ',', '.') }}{{ $currencySymbol }}
                    </span>
                    @if($salePrice)
                        <span class="text-gray-400 line-through text-xs">
                            {{ number_format($price, 0, ',', '.') }}{{ $currencySymbol }}
                        </span>
                        <span class="bg-red-500 text-white text-xs px-1 sm:px-2 py-0.5 sm:py-1 rounded-full">
                            -{{ round(($price - $salePrice) / $price * 100) }}%
                        </span>
                    @endif
                @else
                    <span class="text-gray-400 italic text-sm sm:text-base">
                        {{ $locale === 'vi' ? 'Liên hệ' : '联系我们' }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Hover Overlay -->
    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all duration-500">
        <div class="absolute inset-0 flex items-center justify-center">
            <a href="{{ route(app()->getLocale() . '.products.show', $product->slug) }}" 
               class="bg-[var(--color-primary-500)] text-white px-4 sm:px-6 py-2 sm:py-2.5 rounded-md font-medium text-sm sm:text-base">
                {{ $locale === 'vi' ? 'Xem chi tiết' : '查看详情' }}
            </a>
        </div>
    </div>
</div>
