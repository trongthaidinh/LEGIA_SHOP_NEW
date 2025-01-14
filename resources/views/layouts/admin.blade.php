<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ __('Admin Panel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar-container" class="w-64 fixed top-0 left-0 h-screen transition-transform duration-300 ease-in-out">
            <div id="sidebar" class="w-64 bg-white text-gray-800 shadow-lg border-r border-gray-200 flex flex-col h-full overflow-y-auto">
                <div class="bg-[var(--color-primary-500)] px-6 py-4 border-b border-gray-200 flex items-center justify-center sticky top-0 z-10">
                    <a href="{{ route(request()->segment(1) . '.admin.dashboard') }}" class="flex items-center">
                        @php
                            $logoPath = '/images/logo.png';
                            $fallbackLogo = asset('images/logo.png');
                        @endphp
                        <img 
                            src="{{ file_exists(storage_path('app/public/images/logo.png')) ? asset($logoPath) : $fallbackLogo }}" 
                            alt="{{ config('app.name', 'Laravel') }} Logo" 
                            class="h-20 w-auto object-contain"
                        >
                    </a>
                </div>
                
                <nav class="flex-grow">
                    @php
                        $menuItems = [
                            ['route' => 'dashboard', 'icon' => 'tachometer-alt', 'label' => 'Dashboard'],
                            ['route' => 'categories.index', 'icon' => 'list', 'label' => 'Categories'],
                            ['route' => 'products.index', 'icon' => 'box', 'label' => 'Products'],
                            ['route' => 'orders.index', 'icon' => 'shopping-cart', 'label' => 'Orders'],
                            ['route' => 'post-categories.index', 'icon' => 'folder', 'label' => 'Post Categories'],
                            ['route' => 'posts.index', 'icon' => 'newspaper', 'label' => 'Posts'],
                            ['route' => 'product-reviews.index', 'icon' => 'star', 'label' => 'Product Reviews'],
                            ['route' => 'images.index', 'icon' => 'images', 'label' => 'Images'],
                            ['route' => 'videos.index', 'icon' => 'video', 'label' => 'Videos'],
                            ['route' => '#', 'icon' => 'cog', 'label' => 'Settings']
                        ];
                    @endphp
                    @foreach($menuItems as $item)
                        <a href="{{ $item['route'] === '#' ? '#' : route(request()->segment(1) . '.admin.' . $item['route']) }}" 
                           class="flex items-center px-6 py-3 text-gray-600 hover:bg-primary-50 hover:text-primary-500 transition-colors duration-200 group">
                            <i class="fas fa-{{ $item['icon'] }} w-5 text-primary-400 group-hover:text-primary-500"></i>
                            <span class="ml-3">{{ __($item['label']) }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        <!-- Content -->
        <div class="ml-64 flex-1 flex flex-col h-screen">
            <!-- Top Navbar -->
            <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-10">
                <div class="px-8 py-3">
                    <div class="flex justify-between items-center">
                        <button type="button" class="text-[var(--color-primary-600)] hover:text-[var(--color-primary-700)] focus:outline-none transition-colors duration-200" aria-label="{{ __('Toggle navigation') }}" id="sidebarToggle">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Language Switcher -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center px-3 py-2 border border-[var(--color-primary-300)] rounded-md text-sm font-medium text-[var(--color-primary-700)] bg-white hover:bg-[var(--color-primary-50)] focus:outline-none transition-colors duration-200">
                                    @if(app()->getLocale() == 'vi')
                                        <i class="fas fa-flag mr-2 text-[var(--color-primary-500)]"></i> Tiếng Việt
                                    @else
                                        <i class="fas fa-flag mr-2 text-[var(--color-primary-500)]"></i> Tiếng Trung
                                    @endif
                                </button>
                            </div>

                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-[var(--color-primary-700)] hover:text-[var(--color-primary-900)] focus:outline-none transition-colors duration-200">
                                    <i class="fas fa-user-circle text-xl mr-2 text-[var(--color-primary-500)]"></i>
                                    <span>Xin chào, {{ Auth::user()->name ?? 'Quản trị viên' }}</span>
                                </button>
                                <div 
                                    x-show="open" 
                                    @click.away="open = false" 
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-[var(--color-primary-300)] ring-opacity-20"
                                >
                                    <div class="py-1">
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] transition-colors duration-200">
                                            <i class="fas fa-user mr-2 text-[var(--color-primary-500)]"></i> Hồ sơ của tôi
                                        </a>
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] transition-colors duration-200">
                                            <i class="fas fa-cog mr-2 text-[var(--color-primary-500)]"></i> Cài đặt tài khoản
                                        </a>
                                        <div class="border-t border-[var(--color-primary-100)]"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] transition-colors duration-200">
                                                <i class="fas fa-sign-out-alt mr-2 text-[var(--color-primary-500)]"></i> Đăng xuất
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="flex-grow overflow-y-auto p-6 bg-gray-50">
                    @yield('content')
            </main>
        </div>

    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarContainer = document.getElementById('sidebar-container');
            const contentContainer = document.querySelector('.ml-64');

            let isSidebarVisible = true;

            sidebarToggle.addEventListener('click', function() {
                if (isSidebarVisible) {
                    // Hide sidebar
                    sidebarContainer.classList.add('-translate-x-full');
                    contentContainer.classList.remove('ml-64');
                    contentContainer.classList.add('ml-0');
                } else {
                    // Show sidebar
                    sidebarContainer.classList.remove('-translate-x-full');
                    contentContainer.classList.remove('ml-0');
                    contentContainer.classList.add('ml-64');
                }

                // Toggle sidebar state
                isSidebarVisible = !isSidebarVisible;
            });

            // Optional: Close sidebar on smaller screens
            function handleResize() {
                if (window.innerWidth < 768) {
                    sidebarContainer.classList.add('-translate-x-full');
                    contentContainer.classList.remove('ml-64');
                    contentContainer.classList.add('ml-0');
                    isSidebarVisible = false;
                } else {
                    sidebarContainer.classList.remove('-translate-x-full');
                    contentContainer.classList.remove('ml-0');
                    contentContainer.classList.add('ml-64');
                    isSidebarVisible = true;
                }
            }

            // Initial check and add resize listener
            handleResize();
            window.addEventListener('resize', handleResize);
        });
    </script>
    <style>
        #sidebar-container {
            transition: transform 0.3s ease-in-out;
        }

        #sidebar-container.sidebar-collapsed {
            transform: translateX(-100%);
        }
    </style>
    <script>
        // Optional: Add smooth scrolling to sidebar
        document.getElementById('sidebar').addEventListener('wheel', function(e) {
            e.stopPropagation();
        }, { passive: false });
    </script>
</body>
</html>
