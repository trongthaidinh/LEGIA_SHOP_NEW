@php
    $visitStats = App\Models\WebsiteVisit::getVisitStats();
@endphp
<footer class="bg-[var(--color-primary-600)] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <!-- Logo and Company Info -->
            <div class="md:col-span-3 lg:col-span-1 flex flex-col items-center md:items-start">
                <div class="mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="yến sào" class="h-16 mx-auto md:mx-0">
                </div>
                
                <div class="text-center md:text-left space-y-3">
                    <p class="text-sm flex items-center justify-center md:justify-start gap-2">
                        <i class="fas fa-map-marker-alt text-[var(--color-secondary-500)] w-5"></i>
                        {{ __('company_address') }}
                    </p>
                    <p class="text-sm flex items-center justify-center md:justify-start gap-2">
                        <i class="fas fa-phone text-[var(--color-secondary-500)] w-5"></i>
                        {{ __('company_phone') }}
                    </p>
                    <p class="text-sm flex items-center justify-center md:justify-start gap-2">
                        <i class="fas fa-envelope text-[var(--color-secondary-500)] w-5"></i>
                        {{ __('company_email') }}
                    </p>
                </div>
                
                <div class="mt-6 flex justify-center md:justify-start space-x-4">
                    <a href="https://www.facebook.com/profile.php?id=100064173304425" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                    <a href="#" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                        <i class="fab fa-youtube text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Policies -->
            <div class="text-center md:text-left">
                <h3 class="text-[var(--color-secondary-500)] text-lg font-semibold mb-6">{{ __('policies') }}</h3>
                <div class="space-y-3">
                    <a href="{{ route(app()->getLocale() . '.static.page', 'chinh-sach-chung') }}" class="block text-sm hover:text-[var(--color-secondary-500)] transition-colors">
                        {{ __('general_policies') }}
                    </a>
                    <a href="{{ route(app()->getLocale() . '.static.page', 'chinh-sach-bao-mat') }}" class="block text-sm hover:text-[var(--color-secondary-500)] transition-colors">
                        {{ __('privacy_policy') }}
                    </a>
                    <a href="{{ route(app()->getLocale() . '.static.page', 'chinh-sach-bao-hanh') }}" class="block text-sm hover:text-[var(--color-secondary-500)] transition-colors">
                        {{ __('warranty_policy') }}
                    </a>
                    <a href="{{ route(app()->getLocale() . '.static.page', 'chinh-sach-doi-tra') }}" class="block text-sm hover:text-[var(--color-secondary-500)] transition-colors">
                        {{ __('return_policy') }}
                    </a>
                </div>
            </div>

            <!-- Customer Support -->
            <div class="text-center md:text-left">
                <h3 class="text-[var(--color-secondary-500)] text-lg font-semibold mb-6">{{ __('customer_support') }}</h3>
                <div class="space-y-3">
                    <a href="{{ route(app()->getLocale() . '.static.page', 'chinh-sach-dat-hang-thanh-toan') }}" class="block text-sm hover:text-[var(--color-secondary-500)] transition-colors">
                        {{ __('order_payment_policy') }}
                    </a>
                    <a href="{{ route(app()->getLocale() . '.static.page', 'chinh-sach-van-chuyen') }}" class="block text-sm hover:text-[var(--color-secondary-500)] transition-colors">
                        {{ __('shipping_policy') }}
                    </a>
                    <a href="{{ route(app()->getLocale() . '.static.page', 'cau-hoi-thuong-gap') }}" class="block text-sm hover:text-[var(--color-secondary-500)] transition-colors">
                        {{ __('faq') }}
                    </a>
                </div>
            </div>

            <!-- Visitor Stats -->
            <div class="text-center md:text-left">
                <h3 class="text-[var(--color-secondary-500)] text-lg font-semibold mb-6">{{ __('website_stats') }}</h3>
                <div class="space-y-3">
                    <div class="flex justify-center sm:justify-start items-center gap-2 text-[var(--color-secondary-500)] mb-2">
                        <i class="fas fa-user-friends"></i>
                        <span class="text-white">{{ __('today_visits') }}: <span class="text-[var(--color-secondary-500)]">{{ $visitStats['today_visits'] }}</span></span>
                    </div>

                    <div class="flex justify-center sm:justify-start items-center gap-2 text-[var(--color-secondary-500)] mb-6">
                        <i class="fas fa-chart-line"></i>
                        <span class="text-white">{{ __('total_visits') }}: <span class="text-[var(--color-secondary-500)]">{{ $visitStats['total_visits'] }}</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="bg-[var(--color-secondary-500)] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm">
                &copy; {{ date('Y') }} {{ __('company_name') }}. {{ __('all_rights_reserved') }} 
                | <a href="https://www.takatech.com.vn/" target="_blank" class="hover:underline">{{ __('design_by') }} Takatech</a>
            </p>
        </div>
    </div>
</footer>
