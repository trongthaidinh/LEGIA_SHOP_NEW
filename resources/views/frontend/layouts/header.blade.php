<header class="bg-[var(--color-primary-600)]">
    <div class="flex gap-4 items-center max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Logo -->
    <div class="flex items-center justify-center">
        <a href="{{ route('home') }}" class="block">
            <img src="{{ asset('images/logo.png') }}" alt="LeGia'Nest" class="h-[84px]">
        </a>
    </div>

    <!-- Right Content -->
    <div class="flex-1">
        <!-- Top Bar -->
        <div class="flex items-center gap-8 p-4 pb-2">
            <!-- Search Form -->
            <div class="w-[400px]">
                <form action="{{ route('products.search') }}" method="GET" class="relative">
                    <input type="text" 
                           name="q"
                           placeholder="Tìm kiếm..." 
                           class="w-full px-4 py-2 pr-10 rounded-full bg-white text-gray-900 focus:outline-none">
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <i class="fas fa-search text-gray-600"></i>
                    </button>
                </form>
            </div>

            <!-- Right Menu -->
            <div class="flex items-center gap-8">
                <!-- Language Switcher -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('language.switch', 'vn') }}" class="flex items-center">
                        <img src="{{ asset('images/flags/vn.png') }}" alt="VN" class="w-6 rounded-full object-cover">
                        <span class="text-[var(--color-secondary-300)] ml-1">VN</span>
                    </a>
                    <a href="{{ route('language.switch', 'cn') }}" class="flex items-center">
                        <img src="{{ asset('images/flags/cn.png') }}" alt="中文" class="w-6 rounded-full object-cover">
                        <span class="text-[var(--color-secondary-300)] ml-1">中文</span>
                    </a>
                </div>

                <!-- Hotline -->
                <a href="tel:0772332255" class="flex items-center text-white transition-colors">
                    <i class="fas fa-phone-alt text-lg bg-yellow-500 rounded-full p-3 hover:bg-yellow-400"></i>
                    <div class="ml-2 text-yellow-400">
                        <div class="text-sm font-medium">Hotline</div>
                        <div class="font-medium">0772332255</div>
                    </div>
                </a>

                <!-- Cart -->
                <a href="{{ route('cart') }}" class="flex items-center text-white transition-colors">
                    <i class="fas fa-shopping-cart text-lg bg-yellow-500 rounded-full p-3 hover:bg-yellow-400"></i>
                    <div class="ml-2 text-yellow-400">
                        <div class="text-sm font-medium">Giỏ hàng</div>
                        <div class="font-medium">{{ Cart::getTotalQuantity() }} sản phẩm</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Navigation -->
        <nav >
            <div class="px-4 text-[18px]">
                <ul class="flex gap-16 p-4">
                    <li>
                        <a href="{{ route('home') }}" 
                           class="text-[var(--color-secondary-500)] hover:text-yellow-300 transition-colors uppercase font-medium {{ request()->routeIs('home') ? 'text-yellow-300' : '' }}">
                            TRANG CHỦ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" 
                           class="text-[var(--color-secondary-500)] hover:text-yellow-400 transition-colors uppercase font-medium {{ request()->routeIs('about') ? 'text-yellow-400' : '' }}">
                            GIỚI THIỆU
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products') }}" 
                           class="text-[var(--color-secondary-500)] hover:text-yellow-400 transition-colors uppercase font-medium {{ request()->routeIs('products*') ? 'text-yellow-400' : '' }}">
                            SẢN PHẨM
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('posts') }}" 
                           class="text-[var(--color-secondary-500)] hover:text-yellow-400 transition-colors uppercase font-medium {{ request()->routeIs('posts*') ? 'text-yellow-400' : '' }}">
                            BÀI VIẾT
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" 
                           class="text-[var(--color-secondary-500)] hover:text-yellow-400 transition-colors uppercase font-medium {{ request()->routeIs('contact') ? 'text-yellow-400' : '' }}">
                            LIÊN HỆ
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
        </div>
</header>
