<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Đăng nhập') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-primary-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <img 
                    class="h-40 w-auto object-contain" 
                    src="{{ asset('images/nest-logo.png') }}" 
                    alt="{{ config('app.name', 'Đăng nhập') }}"
                >
            </div>

            @if (session('status'))
                <div class="bg-primary-50 text-primary-700 p-3 rounded-md mb-4 text-center">
                    {{ session('status') }}
                </div>
            @endif

        </div>

        <form method="POST" action="{{ route(app()->getLocale() . '.login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-primary-700 mb-2">
                    Địa chỉ email
                </label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username" 
                    class="w-full px-3 py-2 border border-primary-300 rounded-md shadow-sm 
                           focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500
                           @error('email') border-red-500 @enderror"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-primary-700 mb-2">
                    Mật khẩu
                </label>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password" 
                    class="w-full px-3 py-2 border border-primary-300 rounded-md shadow-sm 
                           focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500
                           @error('password') border-red-500 @enderror"
                >
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me and Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        name="remember" 
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                    >
                    <label for="remember_me" class="ml-2 block text-sm text-primary-700">
                        Ghi nhớ đăng nhập
                    </label>
                </div>

                @if (Route::has(app()->getLocale() . '.password.request'))
                    <div class="text-sm">
                        <a 
                            href="{{ route(app()->getLocale() . '.password.request') }}" 
                            class="font-medium text-primary-600 hover:text-primary-500"
                        >
                            Quên mật khẩu?
                        </a>
                    </div>
                @endif
            </div>

            <div>
                <button 
                    type="submit" 
                    class="w-full flex justify-center py-2 px-4 
                           border border-transparent rounded-md shadow-sm 
                           text-sm font-medium text-white 
                           bg-primary-500 hover:bg-primary-600 
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                    Đăng nhập
                </button>
            </div>
        </form>
    </div>
</body>
</html>
