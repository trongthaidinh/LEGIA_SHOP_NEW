<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\ProductController;
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
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\StaticPageController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\StaticPageController as AdminStaticPageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
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
    Route::get('/posts', [PostController::class, 'index'])->name('vi.posts.index');
    Route::get('/contact', [HomeController::class, 'contact'])->name('vi.contact');
    Route::post('/contact', [HomeController::class, 'submitContact'])->name('vi.contact.submit');

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('vi.products');
        Route::get('/search', [ProductController::class, 'search'])->name('vi.products.search');
        
        Route::get('/{type}', [ProductController::class, 'productsByType'])
            ->name('vi.products.type')
            ->where('type', 'yen-to|yen-chung|gift-set');
        
        Route::prefix('{slug}')->group(function () {
            Route::get('/', [ProductController::class, 'show'])->name('vi.products.show');
            Route::post('/review', [ProductController::class, 'review'])->name('vi.products.review');
        });
    });

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('vi.cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('vi.cart.add');
    Route::post('/cart/update/{rowId}', [CartController::class, 'update'])->name('vi.cart.update');
    Route::delete('/cart/{rowId}', [CartController::class, 'remove'])->name('vi.cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('vi.cart.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('vi.checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('vi.checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('vi.checkout.success');

    // Posts
    Route::get('/posts', [PostController::class, 'index'])->name('vi.posts');
    Route::get('/posts/search', [PostController::class, 'search'])->name('vi.posts.search');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('vi.posts.show');

    // Language Route
    Route::get('language/{lang}', [LanguageController::class, 'switchLang'])->name('vi.language.switch');

    Route::get('/payment/bank', [PaymentController::class, 'bank'])->name('vi.payment.bank');

    // Static Pages Route
    Route::get('/{slug}', [StaticPageController::class, 'show'])
        ->where('slug', '^(?!admin|api).*$')
        ->name('vi.static.page');
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
    Route::get('/posts', [PostController::class, 'index'])->name('zh.posts.index');
    Route::get('/contact', [HomeController::class, 'contact'])->name('zh.contact');
    Route::post('/contact', [HomeController::class, 'submitContact'])->name('zh.contact.submit');

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('zh.products');
        Route::get('/search', [ProductController::class, 'search'])->name('zh.products.search');
        
        Route::get('/{type}', [ProductController::class, 'productsByType'])
            ->name('zh.products.type')
            ->where('type', 'yen-to|yen-chung|gift-set');
        
        Route::prefix('{slug}')->group(function () {
            Route::get('/', [ProductController::class, 'show'])->name('zh.products.show');
            Route::post('/review', [ProductController::class, 'review'])->name('zh.products.review');
        });
    });

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('zh.cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('zh.cart.add');
    Route::post('/cart/update/{rowId}', [CartController::class, 'update'])->name('zh.cart.update');
    Route::delete('/cart/{rowId}', [CartController::class, 'remove'])->name('zh.cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('zh.cart.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('zh.checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('zh.checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('zh.checkout.success');

    // Posts
    Route::get('/posts', [PostController::class, 'index'])->name('zh.posts');
    Route::get('/posts/search', [PostController::class, 'search'])->name('zh.posts.search');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('zh.posts.show');

    // Language Route
    Route::get('language/{lang}', [LanguageController::class, 'switchLang'])->name('zh.language.switch');

    Route::get('/payment/bank', [PaymentController::class, 'bank'])->name('zh.payment.bank');

    // Static Pages Route
    Route::get('/{slug}', [StaticPageController::class, 'show'])
        ->where('slug', '^(?!admin|api).*$')
        ->name('zh.static.page');
});

// Auth Routes (chung cho cả hai ngôn ngữ)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Vietnamese Admin Routes
Route::prefix('vi/admin')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('vi.admin.dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('vi.admin.dashboard');
    Route::resource('categories', CategoryController::class)->names('vi.admin.categories');
    Route::resource('products', AdminProductController::class)->names('vi.admin.products');
    Route::resource('testimonials', TestimonialController::class)->names('vi.admin.testimonials');
    Route::resource('certificates', CertificateController::class)->names('vi.admin.certificates');
    Route::post('certificates/order', [CertificateController::class, 'updateOrder'])->name('vi.admin.certificates.order');
    Route::patch('certificates/{certificate}/toggle', [CertificateController::class, 'toggleStatus'])->name('vi.admin.certificates.toggle');
    Route::resource('orders', OrderController::class)->except(['edit', 'update'])->names('vi.admin.orders');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('vi.admin.orders.update-status');
    Route::post('orders/{order}/process', [OrderController::class, 'process'])->name('vi.admin.orders.process');
    Route::resource('post-categories', PostCategoryController::class)->names('vi.admin.post-categories');
    Route::resource('posts', AdminPostController::class)->names('vi.admin.posts');
    Route::get('product-reviews', [ProductReviewController::class, 'index'])->name('vi.admin.product-reviews.index');
    Route::get('product-reviews/{productReview}', [ProductReviewController::class, 'show'])->name('vi.admin.product-reviews.show');
    Route::patch('product-reviews/{productReview}/approve', [ProductReviewController::class, 'approve'])->name('vi.admin.product-reviews.approve');
    Route::patch('product-reviews/{productReview}/reject', [ProductReviewController::class, 'reject'])->name('vi.admin.product-reviews.reject');
    Route::delete('product-reviews/{productReview}', [ProductReviewController::class, 'destroy'])->name('vi.admin.product-reviews.destroy');

    // Images Management
    Route::resource('images', ImageController::class)->names('vi.admin.images');
    Route::post('images/order', [ImageController::class, 'updateOrder'])->name('vi.admin.images.order');
    Route::patch('images/{image}/toggle', [ImageController::class, 'toggleStatus'])->name('vi.admin.images.toggle');
    Route::post('images/upload', [ImageController::class, 'upload'])->name('vi.admin.images.upload');

    // Videos Management
    Route::resource('videos', VideoController::class)->names('vi.admin.videos');
    Route::post('videos/order', [VideoController::class, 'updateOrder'])->name('vi.admin.videos.order');
    Route::patch('videos/{video}/toggle', [VideoController::class, 'toggleStatus'])->name('vi.admin.videos.toggle');

    Route::get('contact-submissions', [ContactSubmissionController::class, 'index'])->name('vi.admin.contact-submissions.index');
    Route::get('contact-submissions/{submission}', [ContactSubmissionController::class, 'show'])->name('vi.admin.contact-submissions.show');
    Route::patch('contact-submissions/{submission}/mark-replied', [ContactSubmissionController::class, 'markAsReplied'])->name('vi.admin.contact-submissions.mark-replied');
    Route::delete('contact-submissions/{submission}', [ContactSubmissionController::class, 'destroy'])->name('vi.admin.contact-submissions.destroy');

    Route::resource('static-pages', AdminStaticPageController::class)->names('vi.admin.static-pages');
    Route::patch('static-pages/{staticPage}/toggle', [AdminStaticPageController::class, 'toggleStatus'])->name('vi.admin.static-pages.toggle');

    Route::resource('managers', ManagerController::class)->names('vi.admin.managers');
    Route::resource('menus', MenuController::class)->names('vi.admin.menus');
    
    // Menu Items Management
    Route::prefix('menu-items')->name('vi.admin.menu-items.')->group(function () {
        Route::post('/', [MenuController::class, 'storeItem'])->name('store');
        Route::get('/{menuItem}/edit', [MenuController::class, 'editItem'])->name('edit');
        Route::put('/{menuItem}', [MenuController::class, 'updateItem'])->name('update');
        Route::delete('/{menuItem}', [MenuController::class, 'destroyItem'])->name('destroy');
        Route::post('/reorder', [MenuController::class, 'reorderItems'])->name('reorder');
    });

    Route::get('settings', [SettingController::class, 'index'])->name('vi.admin.settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('vi.admin.settings.update');

    Route::resource('sliders', SliderController::class)->names('vi.admin.sliders');
    Route::post('sliders/order', [SliderController::class, 'updateOrder'])->name('vi.admin.sliders.order');
    Route::patch('sliders/{slider}/toggle', [SliderController::class, 'toggleStatus'])->name('vi.admin.sliders.toggle');
});

// Chinese Admin Routes  
Route::prefix('zh/admin')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('zh.admin.dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('zh.admin.dashboard');
    Route::resource('categories', CategoryController::class)->names('zh.admin.categories');
    Route::resource('products', AdminProductController::class)->names('zh.admin.products');
    Route::resource('testimonials', TestimonialController::class)->names('zh.admin.testimonials');
    Route::resource('certificates', CertificateController::class)->names('zh.admin.certificates');
    Route::post('certificates/order', [CertificateController::class, 'updateOrder'])->name('zh.admin.certificates.order');
    Route::patch('certificates/{certificate}/toggle', [CertificateController::class, 'toggleStatus'])->name('zh.admin.certificates.toggle');
    Route::resource('orders', OrderController::class)->except(['edit', 'update'])->names('zh.admin.orders');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('zh.admin.orders.update-status');
    Route::post('orders/{order}/process', [OrderController::class, 'process'])->name('zh.admin.orders.process');
    Route::resource('post-categories', PostCategoryController::class)->names('zh.admin.post-categories');
    Route::resource('posts', AdminPostController::class)->names('zh.admin.posts');
    Route::get('product-reviews', [ProductReviewController::class, 'index'])->name('zh.admin.product-reviews.index');
    Route::get('product-reviews/{productReview}', [ProductReviewController::class, 'show'])->name('zh.admin.product-reviews.show');
    Route::patch('product-reviews/{productReview}/approve', [ProductReviewController::class, 'approve'])->name('zh.admin.product-reviews.approve');
    Route::patch('product-reviews/{productReview}/reject', [ProductReviewController::class, 'reject'])->name('zh.admin.product-reviews.reject');
    Route::delete('product-reviews/{productReview}', [ProductReviewController::class, 'destroy'])->name('zh.admin.product-reviews.destroy');

    // Images Management
    Route::resource('images', ImageController::class)->names('zh.admin.images');
    Route::post('images/order', [ImageController::class, 'updateOrder'])->name('zh.admin.images.order');
    Route::patch('images/{image}/toggle', [ImageController::class, 'toggleStatus'])->name('zh.admin.images.toggle');
    Route::post('images/upload', [ImageController::class, 'upload'])->name('zh.admin.images.upload');

    // Videos Management
    Route::resource('videos', VideoController::class)->names('zh.admin.videos');
    Route::post('videos/order', [VideoController::class, 'updateOrder'])->name('zh.admin.videos.order');
    Route::patch('videos/{video}/toggle', [VideoController::class, 'toggleStatus'])->name('zh.admin.videos.toggle');

    Route::get('contact-submissions', [ContactSubmissionController::class, 'index'])->name('zh.admin.contact-submissions.index');
    Route::get('contact-submissions/{submission}', [ContactSubmissionController::class, 'show'])->name('zh.admin.contact-submissions.show');
    Route::patch('contact-submissions/{submission}/mark-replied', [ContactSubmissionController::class, 'markAsReplied'])->name('zh.admin.contact-submissions.mark-replied');
    Route::delete('contact-submissions/{submission}', [ContactSubmissionController::class, 'destroy'])->name('zh.admin.contact-submissions.destroy');

    Route::resource('static-pages', AdminStaticPageController::class)->names('zh.admin.static-pages');
    Route::patch('static-pages/{staticPage}/toggle', [AdminStaticPageController::class, 'toggleStatus'])->name('zh.admin.static-pages.toggle');

    Route::resource('managers', ManagerController::class)->names('zh.admin.managers');
    Route::resource('menus', MenuController::class)->names('zh.admin.menus');
    
    // Menu Items Management
    Route::prefix('menu-items')->name('zh.admin.menu-items.')->group(function () {
        Route::post('/', [MenuController::class, 'storeItem'])->name('store');
        Route::get('/{menuItem}/edit', [MenuController::class, 'editItem'])->name('edit');
        Route::put('/{menuItem}', [MenuController::class, 'updateItem'])->name('update');
        Route::delete('/{menuItem}', [MenuController::class, 'destroyItem'])->name('destroy');
        Route::post('/reorder', [MenuController::class, 'reorderItems'])->name('reorder');
    });

    Route::get('settings', [SettingController::class, 'index'])->name('zh.admin.settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('zh.admin.settings.update');

    Route::resource('sliders', SliderController::class)->names('zh.admin.sliders');
    Route::post('sliders/order', [SliderController::class, 'updateOrder'])->name('zh.admin.sliders.order');
    Route::patch('sliders/{slider}/toggle', [SliderController::class, 'toggleStatus'])->name('zh.admin.sliders.toggle');
});

require __DIR__ . '/auth.php';
