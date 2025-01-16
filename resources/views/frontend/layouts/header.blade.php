<header class="bg-[var(--color-primary-600)] relative sticky top-0 z-50 w-full transition-transform duration-300 ease-in-out transform translate-y-0">
    <!-- Desktop Header -->
    <div class="hidden lg:flex gap-4 items-center max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Logo -->
        <div class="flex items-center justify-center">
            <a href="{{ route(app()->getLocale() . '.home') }}" class="block">
                <img src="{{ asset('images/logo.png') }}" alt="{{ __('company_name') }}" class="h-[84px]">
            </a>
        </div>

        <!-- Right Content -->
        <div class="flex-1">
            <!-- Top Bar -->
            <div class="flex items-center gap-8 p-4 pb-2">
                <!-- Search Form -->
                <div class="w-[400px]">
                    <form action="{{ route(app()->getLocale() . '.products.search') }}" method="GET" class="relative">
                        <input type="text"  
                               name="q"
                               placeholder="{{ __('search_placeholder') }}" 
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
                        <a href="/vi" class="flex items-center">
                            <img src="{{ asset('images/flags/vn.png') }}" alt="VN" class="w-6 rounded-full object-cover">
                            <span class="text-[var(--color-secondary-300)] ml-1">VN</span>
                        </a>
                        <a href="/zh" class="flex items-center">
                            <img src="{{ asset('images/flags/cn.png') }}" alt="中文" class="w-6 rounded-full object-cover">
                            <span class="text-[var(--color-secondary-300)] ml-1">中文</span>
                        </a>
                    </div>
                    
                    <!-- Hotline -->
                    <a href="tel:0772332255" class="flex items-center text-white transition-colors">
                        <div class="w-10 h-10 flex items-center justify-center bg-yellow-500 rounded-full hover:bg-yellow-400">
                            <i class="fas fa-phone text-lg"></i>
                        </div>
                        <div class="ml-2 text-yellow-400">
                            <div class="text-sm font-medium">{{ __('hotline') }}</div>
                            <div class="font-medium">0772332255</div>
                        </div>
                    </a>

                    <!-- Cart -->
                    <a href="{{ route(app()->getLocale() . '.cart') }}" class="flex items-center text-white transition-colors">
                        <div class="w-10 h-10 flex items-center justify-center bg-yellow-500 rounded-full hover:bg-yellow-400">
                            <i class="fas fa-shopping-cart text-lg"></i>
                        </div>
                        <div class="ml-2 text-yellow-400">
                            <div class="text-sm font-medium">{{ __('shopping_cart') }}</div>
                            <div class="font-medium cart-count">0 {{ __('items') }}</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Navigation -->
            <nav>
                <div class="px-4 text-[18px]">
                    <ul class="flex gap-16 p-4">
                        @foreach($menuItems as $item)
                            <li class="relative group">
                                <a href="{{ $item->url }}" 
                                   class="menu-item-hover text-[var(--color-secondary-300)] hover:text-[var(--color-secondary-400)] transition-colors uppercase font-medium {{ request()->is(trim($item->url, '/')) ? 'text-[var(--color-secondary-400)]' : '' }}"
                                   @if($item->target) target="{{ $item->target }}" @endif>
                                    {{ $item->title }}
                                    @if($item->children->count() > 0)
                                        <i class="fas fa-chevron-down ml-1 text-xs transition-transform duration-300 group-hover:rotate-180"></i>
                                    @endif
                                </a>

                                @if($item->children->count() > 0)
                                    <div class="absolute left-0 top-full pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                        <ul class="dropdown-menu rounded-lg py-2 min-w-[200px] dropdown-animation">
                                            @foreach($item->children as $child)
                                                <li>
                                                    <a href="{{ $child->url }}" 
                                                       class="submenu-item block px-4 py-2 transition-all duration-300"
                                                       @if($child->target) target="{{ $child->target }}" @endif>
                                                        {{ $child->title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <!-- Mobile Header -->
    <div class="lg:hidden">
        <div class="flex justify-between items-center p-4">
            <!-- Mobile Logo -->
            <a href="{{ route(app()->getLocale() . '.home') }}" class="block">
                <img src="{{ asset('images/logo.png') }}" alt="{{ __('company_name') }}" class="h-12">
            </a>

            <!-- Mobile Action Buttons -->
            <div class="flex items-center space-x-4">
                <!-- Mobile Search Toggle -->
                <button id="mobile-search-toggle" class="text-white">
                    <i class="fas fa-search text-xl"></i>
                </button>

                <!-- Mobile Cart -->
                <a href="{{ route(app()->getLocale() . '.cart') }}" class="text-white relative">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span class="absolute -top-2 -right-2 bg-yellow-500 text-xs text-white rounded-full w-4 h-4 flex items-center justify-center cart-count">0</span>
                </a>

                <!-- Mobile Menu Toggle -->
                <button id="mobile-menu-toggle" class="text-white">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Search Dropdown -->
        <div id="mobile-search-dropdown" class="hidden absolute top-full left-0 w-full bg-white p-4 z-50 shadow-lg">
            <form action="{{ route(app()->getLocale() . '.products.search') }}" method="GET" class="relative">
                <input type="text" 
                       name="q"
                       placeholder="{{ __('search_placeholder') }}" 
                       class="w-full px-4 py-2 pr-10 rounded-full bg-gray-100 text-gray-900 focus:outline-none">
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-search text-gray-600"></i>
                </button>
            </form>
        </div>
    </div>
</header>

<!-- Mobile Menu Sidebar - Moved outside header -->
<div id="mobile-menu-sidebar" class="fixed inset-0 bg-[var(--color-primary-600)] transform translate-x-full transition-transform duration-300 z-[200] overflow-y-auto">
    <div class="relative h-full">
        <!-- Close Button -->
        <button id="mobile-menu-close" class="absolute top-4 right-4 text-white z-10">
            <i class="fas fa-times text-2xl"></i>
        </button>

        <div class="p-6 h-full flex flex-col">
            <!-- Language Switcher -->
            <div class="flex justify-center items-center gap-4 mb-6">
                <a href="/vi" class="flex items-center">
                    <img src="{{ asset('images/flags/vn.png') }}" alt="VN" class="w-6 rounded-full object-cover">
                    <span class="text-[var(--color-secondary-300)] ml-1">VN</span>
                </a>
                <a href="/zh" class="flex items-center">
                    <img src="{{ asset('images/flags/cn.png') }}" alt="中文" class="w-6 rounded-full object-cover">
                    <span class="text-[var(--color-secondary-300)] ml-1">中文</span>
                </a>
            </div>

            <!-- Mobile Menu Items -->
            <nav class="flex-grow overflow-y-auto">
                @foreach($menuItems as $item)
                    <div class="mobile-menu-group mb-2">
                        <div class="flex justify-between items-center text-white py-3 border-b border-[var(--color-primary-500)]">
                            <a href="{{ $item->url }}" class="text-lg">{{ $item->title }}</a>
                            @if($item->children->count() > 0)
                                <button class="mobile-submenu-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            @endif
                        </div>

                        @if($item->children->count() > 0)
                            <div class="mobile-submenu hidden">
                                @foreach($item->children as $child)
                                    <a href="{{ $child->url }}" class="block text-[var(--color-secondary-300)] py-2 pl-4">
                                        {{ $child->title }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </nav>

            <!-- Contact & Hotline -->
            <div class="mt-6 text-center">
                <a href="tel:0772332255" class="inline-block bg-yellow-500 text-white px-6 py-3 rounded-full">
                    <i class="fas fa-phone mr-2"></i> 0772332255
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateCartCount() {
        const currentLang = '{{ app()->getLocale() }}';
        const carts = JSON.parse(localStorage.getItem('carts')) || {};
        const currentCart = carts[currentLang] || {};
        
        const itemCount = Object.values(currentCart).reduce((total, item) => total + (item.quantity || 1), 0);
        
        // Update desktop cart count
        const desktopCartCount = document.querySelector('.cart-count');
        if (desktopCartCount) {
            desktopCartCount.textContent = `${itemCount} {{ __('items') }}`;
        }
        
        // Update mobile cart count
        const mobileCartCount = document.querySelector('.mobile-menu-sidebar .cart-count, .mobile-header .cart-count');
        if (mobileCartCount) {
            mobileCartCount.textContent = itemCount;
        }
    }

    // Thêm event listener để cập nhật số lượng giỏ hàng
    document.addEventListener('DOMContentLoaded', updateCartCount);
    
    // Lắng nghe sự kiện thay đổi localStorage
    window.addEventListener('storage', function(event) {
        if (event.key === 'carts') {
            updateCartCount();
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Search Toggle
    const mobileSearchToggle = document.getElementById('mobile-search-toggle');
    const mobileSearchDropdown = document.getElementById('mobile-search-dropdown');
    
    mobileSearchToggle.addEventListener('click', function() {
        mobileSearchDropdown.classList.toggle('hidden');
    });

    // Mobile Menu Toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuSidebar = document.getElementById('mobile-menu-sidebar');
    
    mobileMenuToggle.addEventListener('click', function() {
        mobileMenuSidebar.classList.remove('translate-x-full');
    });

    mobileMenuClose.addEventListener('click', function() {
        mobileMenuSidebar.classList.add('translate-x-full');
    });

    // Mobile Submenu Toggle
    const mobileSubmenuToggles = document.querySelectorAll('.mobile-submenu-toggle');
    
    mobileSubmenuToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const submenu = this.closest('.mobile-menu-group').querySelector('.mobile-submenu');
            const icon = this.querySelector('i');
            
            submenu.classList.toggle('hidden');
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let lastScrollTop = 0;
        const header = document.querySelector('header');
        const headerHeight = header.offsetHeight;

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > headerHeight) {
                // Cuộn xuống: ẩn header
                header.classList.add('-translate-y-full');
                header.classList.remove('translate-y-0');
            } else if (scrollTop < lastScrollTop) {
                // Cuộn lên: hiện header
                header.classList.remove('-translate-y-full');
                header.classList.add('translate-y-0');
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // For Mobile or negative scrolling
        });
    });
</script>
@endpush

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scaleIn {
    from {
        transform: scale(0.95);
    }
    to {
        transform: scale(1);
    }
}

.dropdown-animation {
    animation: fadeInUp 0.3s ease-out, scaleIn 0.2s ease-out;
}

.menu-item-hover {
    position: relative;
}

.menu-item-hover::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -2px;
    left: 0;
    background-color: var(--color-secondary-400);
    transition: width 0.3s ease;
}

.menu-item-hover:hover::after {
    width: 100%;
}

.submenu-item {
    position: relative;
    transition: all 0.3s ease;
}

.submenu-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 3px;
    height: 0;
    background-color: var(--color-secondary-400);
    transition: all 0.3s ease;
    transform: translateY(-50%);
}

.submenu-item:hover::before {
    height: 80%;
}

.submenu-item:hover {
    padding-left: 1.5rem !important;
    background-color: var(--color-primary-50) !important;
    color: var(--color-primary-700) !important;
}

.dropdown-menu {
    background: linear-gradient(to bottom, var(--color-primary-600), var(--color-primary-700));
    border: 1px solid var(--color-primary-400);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.dropdown-menu .submenu-item {
    color: var(--color-secondary-300);
    border-left: 3px solid transparent;
}

.dropdown-menu .submenu-item:hover {
    color: var(--color-secondary-500) !important;
    background-color: var(--color-primary-500) !important;
}
</style>
