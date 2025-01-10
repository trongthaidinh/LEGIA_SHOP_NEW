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
        <div id="sidebar" class="w-64 bg-gray-800 text-white transition-all duration-300">
            <div class="px-6 py-4 bg-gray-900">
                <a href="{{ route(request()->segment(1) . '.admin.dashboard') }}" class="text-xl font-bold text-white hover:text-gray-200">
                    {{ config('app.name', 'Laravel') }} {{ __('Admin Panel') }}
                </a>
            </div>
            
            <nav class="mt-4">
                <a href="{{ route(request()->segment(1) . '.admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="ml-3">{{ __('Dashboard') }}</span>
                </a>
                <a href="{{ route(request()->segment(1) . '.admin.categories.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-list w-5"></i>
                    <span class="ml-3">{{ __('Categories') }}</span>
                </a>
                <a href="{{ route(request()->segment(1) . '.admin.products.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-box w-5"></i>
                    <span class="ml-3">{{ __('Products') }}</span>
                </a>
                <a href="{{ route(request()->segment(1) . '.admin.orders.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-shopping-cart w-5"></i>
                    <span class="ml-3">{{ __('Orders') }}</span>
                </a>
                <a href="{{ route(request()->segment(1) . '.admin.post-categories.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-folder w-5"></i>
                    <span class="ml-3">{{ __('Post Categories') }}</span>
                </a>
                <a href="{{ route(request()->segment(1) . '.admin.posts.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-newspaper w-5"></i>
                    <span class="ml-3">{{ __('Posts') }}</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-cog w-5"></i>
                    <span class="ml-3">{{ __('Settings') }}</span>
                </a>
            </nav>
        </div>

        <!-- Content -->
        <div class="flex-1">
            <!-- Top Navbar -->
            <nav class="bg-white shadow">
                <div class="px-4 py-2">
                    <div class="flex justify-between items-center">
                        <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none" aria-label="{{ __('Toggle navigation') }}" id="sidebarToggle">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Language Switcher -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                    @if(app()->getLocale() == 'vi')
                                        <i class="fas fa-flag mr-2"></i> {{ __('Vietnamese') }}
                                    @else
                                        <i class="fas fa-flag mr-2"></i> {{ __('Chinese') }}
                                    @endif
                                </button>
                              
                            </div>

                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none">
                                    <i class="fas fa-user-circle text-xl mr-2"></i>
                                    <span>{{ __('Welcome') }}, {{ Auth::user()->name ?? 'Admin' }}</span>
                                </button>
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                    <div class="py-1">
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-user mr-2"></i> {{ __('My Profile') }}
                                        </a>
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-cog mr-2"></i> {{ __('Account Settings') }}
                                        </a>
                                        <div class="border-t border-gray-100"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Sign Out') }}
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
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Toggle sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('hidden');
        });
    </script>
</body>
</html>
