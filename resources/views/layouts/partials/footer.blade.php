<footer class="bg-primary-dark text-white border-t border-white/30">
    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
            <div class="space-y-6">
                <div class="flex items-center space-x-3 overflow-hidden">
                    <img src="{{ asset('images/logo-trang.png') }}" alt="Logo" class="h-[100px]">
                </div>
                <ul class="space-y-3 text-white/90">
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>32 Đường Y Ngông, Tân Tiến, TP. Buôn Ma Thuột, Đắk Lắk</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>026 2386 0618</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>caodangytedk@gmail.com</span>
                    </li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-6">LIÊN KẾT NHANH</h3>
                <ul class="space-y-3 text-white/90">
                    <li>
                        <a href="/huong-nghiep" class="hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span>Đăng ký hướng nghiệp</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dang-ky-tuyen-sinh-truc-tuyen" class="hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span>Đăng ký tuyển sinh</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.' . app()->getLocale() . '.dashboard') }}" class="hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span>{{ __('Admin Panel') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="/login" class="hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span>Sinh viên</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-6">THỐNG KÊ TRUY CẬP</h3>
                <ul class="space-y-3 text-white/90">
                    <li class="flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Hôm nay
                        </span>
                        <span>{{ \App\Models\Visit::getTodayVisits() }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Tháng này
                        </span>
                        <span>{{ \App\Models\Visit::getMonthVisits() }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Tổng lượt truy cập
                        </span>
                        <span>{{ \App\Models\Visit::getTotalVisits() }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="border-t border-white/10">
        <div class="container mx-auto py-4">
            <p class="text-center text-sm text-white/70">
                {{ date('Y') }} Trường Cao Đẳng Y Tế Đắk Lắk. All rights reserved.
            </p>
        </div>
    </div>
</footer>
