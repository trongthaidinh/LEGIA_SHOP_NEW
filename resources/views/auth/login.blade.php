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
<body class="login-body">
    <div class="login-container">
        <div class="login-logo">
            <img src="{{ asset('images/nest-logo.png') }}" alt="{{ config('app.name', 'Đăng nhập') }}">
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="login-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route(app()->getLocale() . '.login') }}" class="login-form">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Địa chỉ email</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username" 
                    class="form-control @error('email') is-invalid @enderror"
                >
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Mật khẩu</label>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password" 
                    class="form-control @error('password') is-invalid @enderror"
                >
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="remember-forgot">
                <label for="remember_me" class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Ghi nhớ đăng nhập</span>
                </label>

                @if (Route::has(app()->getLocale() . '.password.request'))
                    <a href="{{ route(app()->getLocale() . '.password.request') }}" class="forgot-password">
                        Quên mật khẩu?
                    </a>
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="login-button">
                    Đăng nhập
                </button>
            </div>
        </form>
    </div>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Figtree', sans-serif;
            background-color: var(--color-primary-100);
        }

        .login-body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: var(--spacing-lg);
            background-color: white;
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .login-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: var(--spacing-lg);
        }

        .login-logo img {
            max-width: 200px;
            height: auto;
            object-fit: contain;
        }

        .login-status {
            background-color: var(--color-primary-50);
            color: var(--color-primary-700);
            padding: var(--spacing-sm);
            border-radius: var(--radius-md);
            margin-bottom: var(--spacing-md);
            text-align: center;
        }

        .login-form .form-group {
            margin-bottom: var(--spacing-md);
        }

        .form-label {
            display: block;
            margin-bottom: var(--spacing-xs);
            font-size: var(--text-sm);
            color: var(--color-primary-700);
        }

        .form-control {
            width: 100%;
            padding: var(--spacing-sm);
            border: 1px solid var(--color-primary-300);
            border-radius: var(--radius-md);
            font-size: var(--text-base);
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-primary-500);
        }

        .form-control.is-invalid {
            border-color: red;
        }

        .error-message {
            color: red;
            font-size: var(--text-sm);
            margin-top: var(--spacing-xs);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-md);
        }

        .remember-me {
            display: flex;
            align-items: center;
            font-size: var(--text-sm);
        }

        .remember-me input {
            margin-right: var(--spacing-xs);
        }

        .forgot-password {
            color: var(--color-primary-600);
            text-decoration: none;
            font-size: var(--text-sm);
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: var(--spacing-sm);
            background-color: var(--color-primary-500);
            color: white;
            border: none;
            border-radius: var(--radius-md);
            font-size: var(--text-base);
            font-weight: var(--font-semibold);
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: var(--color-primary-600);
        }
    </style>
</body>
</html>
