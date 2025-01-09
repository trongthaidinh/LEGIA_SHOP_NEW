<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root to Vietnamese version
Route::get('/', function () {
    return redirect('/vi');
});

// Vietnamese Frontend Routes
Route::prefix('vi')->group(function () {
    // Auth Routes
    Route::middleware('guest')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])->name('vi.register');
        Route::post('register', [RegisteredUserController::class, 'store']);
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('vi.login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('vi.password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('vi.password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('vi.password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('vi.password.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('verify-email', EmailVerificationPromptController::class)->name('vi.verification.notice');
        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('vi.verification.verify');
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('vi.verification.send');
        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('vi.password.confirm');
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
        Route::put('password', [PasswordController::class, 'update'])->name('vi.password.update');
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('vi.logout');
    });

    // Home
    Route::get('/', [HomeController::class, 'index'])->name('vi.home');
    Route::get('/about', [HomeController::class, 'about'])->name('vi.about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('vi.contact');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('vi.products');
    Route::get('/products/search', [ProductController::class, 'search'])->name('vi.products.search');
    Route::get('/products/{slug}', [ProductController::class, 'show'])->name('vi.products.show');
    Route::post('/products/{slug}/review', [ProductController::class, 'review'])->name('vi.products.review');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('vi.cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('vi.cart.add');
    Route::post('/cart/update/{rowId}', [CartController::class, 'update'])->name('vi.cart.update');
    Route::delete('/cart/{rowId}', [CartController::class, 'remove'])->name('vi.cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('vi.cart.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('vi.checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('vi.checkout.process');
    Route::get('/checkout/success/{orderId}', [CheckoutController::class, 'success'])->name('vi.checkout.success');

    // Posts
    Route::get('/posts', [PostController::class, 'index'])->name('vi.posts');
    Route::get('/posts/search', [PostController::class, 'search'])->name('vi.posts.search');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('vi.posts.show');

    // Language Route
    Route::get('language/{lang}', [LanguageController::class, 'switchLang'])->name('vi.language.switch');

    // Test Language Route
    Route::get('/test-lang', function() {
        return [
            'current_locale' => app()->getLocale(),
            'session_locale' => session('locale'),
            'translations' => [
                'welcome' => __('Welcome'),
                'products' => __('Products'),
                'cart' => __('Cart')
            ]
        ];
    })->name('vi.test-lang');

    // Admin Routes
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('categories', CategoryController::class)->names([
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy'
        ]);

        Route::resource('products', ProductController::class)->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy'
        ]);

        Route::resource('orders', OrderController::class)->names([
            'index' => 'admin.orders.index',
            'show' => 'admin.orders.show',
            'update' => 'admin.orders.update'
        ]);
    });
});

// Chinese Frontend Routes
Route::prefix('zh')->group(function () {
    // Auth Routes
    Route::middleware('guest')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])->name('zh.register');
        Route::post('register', [RegisteredUserController::class, 'store']);
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('zh.login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('zh.password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('zh.password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('zh.password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('zh.password.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('verify-email', EmailVerificationPromptController::class)->name('zh.verification.notice');
        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('zh.verification.verify');
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('zh.verification.send');
        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('zh.password.confirm');
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
        Route::put('password', [PasswordController::class, 'update'])->name('zh.password.update');
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('zh.logout');
    });

    // Home
    Route::get('/', [HomeController::class, 'index'])->name('zh.home');
    Route::get('/about', [HomeController::class, 'about'])->name('zh.about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('zh.contact');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('zh.products');
    Route::get('/products/search', [ProductController::class, 'search'])->name('zh.products.search');
    Route::get('/products/{slug}', [ProductController::class, 'show'])->name('zh.products.show');
    Route::post('/products/{slug}/review', [ProductController::class, 'review'])->name('zh.products.review');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('zh.cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('zh.cart.add');
    Route::post('/cart/update/{rowId}', [CartController::class, 'update'])->name('zh.cart.update');
    Route::delete('/cart/{rowId}', [CartController::class, 'remove'])->name('zh.cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('zh.cart.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('zh.checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('zh.checkout.process');
    Route::get('/checkout/success/{orderId}', [CheckoutController::class, 'success'])->name('zh.checkout.success');

    // Posts
    Route::get('/posts', [PostController::class, 'index'])->name('zh.posts');
    Route::get('/posts/search', [PostController::class, 'search'])->name('zh.posts.search');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('zh.posts.show');

    // Language Route
    Route::get('language/{lang}', [LanguageController::class, 'switchLang'])->name('zh.language.switch');

    // Test Language Route
    Route::get('/test-lang', function() {
        return [
            'current_locale' => app()->getLocale(),
            'session_locale' => session('locale'),
            'translations' => [
                'welcome' => __('Welcome'),
                'products' => __('Products'),
                'cart' => __('Cart')
            ]
        ];
    })->name('zh.test-lang');

    // Admin Routes
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('categories', CategoryController::class)->names([
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy'
        ]);

        Route::resource('products', ProductController::class)->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy'
        ]);

        Route::resource('orders', OrderController::class)->names([
            'index' => 'admin.orders.index',
            'show' => 'admin.orders.show',
            'update' => 'admin.orders.update'
        ]);
    });
});

// Auth Routes (chung cho cả hai ngôn ngữ)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
