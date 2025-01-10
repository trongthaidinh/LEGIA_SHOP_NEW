<footer class="bg-[var(--color-primary-600)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-12 gap-8">
            <!-- Logo and Description -->
            <div class="col-span-4">
                <div class="flex flex-col">
                    <div class="flex items-center mb-6">
                        <img src="{{ asset('images/logo.png') }}" alt="LeGia'Nest" class="h-20">
                    </div>

                    <div class="flex items-center gap-2 text-[var(--color-secondary-500)] mb-2">
                        <i class="fas fa-user-friends"></i>
                        <span class="text-white">{{ __('today_visits') }}: <span class="text-[var(--color-secondary-500)]">11</span></span>
                    </div>

                    <div class="flex items-center gap-2 text-[var(--color-secondary-500)] mb-6">
                        <i class="fas fa-chart-line"></i>
                        <span class="text-white">{{ __('total_visits') }}: <span class="text-[var(--color-secondary-500)]">52226</span></span>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-[var(--color-secondary-500)] w-5"></i>
                            <span class="text-white">{{ __('company_address') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-phone text-[var(--color-secondary-500)] w-5"></i>
                            <span class="text-white">{{ __('company_phone') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-envelope text-[var(--color-secondary-500)] w-5"></i>
                            <span class="text-white">{{ __('company_email') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Policies -->
            <div class="col-span-3">
                <h3 class="text-[var(--color-secondary-500)] text-lg font-semibold mb-6">{{ __('policies') }}</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                            {{ __('general_policies') }}
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                            {{ __('privacy_policy') }}
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                            {{ __('warranty_policy') }}
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                            {{ __('return_policy') }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Customer Support -->
            <div class="col-span-3">
                <h3 class="text-[var(--color-secondary-500)] text-lg font-semibold mb-6">{{ __('customer_support') }}</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                            {{ __('order_payment_policy') }}
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                            {{ __('shipping_policy') }}
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                            {{ __('faq') }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Connect with us -->
            <div class="col-span-2">
                <h3 class="text-[var(--color-secondary-500)] text-lg font-semibold mb-6">{{ __('connect_with_us') }}</h3>
                <div class="flex gap-4">
                    <a href="#" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                        <i class="fab fa-facebook-f text-2xl"></i>
                    </a>
                    <a href="#" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                        <i class="fab fa-instagram text-2xl"></i>
                    </a>
                    <a href="#" class="text-white hover:text-[var(--color-secondary-300)] transition-colors">
                        <i class="fab fa-youtube text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="bg-[var(--color-secondary-500)] py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-white">&copy; {{ date('Y') }} {{ __('copyright_text') }}</p>
        </div>
    </div>
</footer>
