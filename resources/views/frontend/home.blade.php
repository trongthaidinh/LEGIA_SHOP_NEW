@extends('frontend.layouts.master')

@section('title', 'Trang chủ - ' . config('app.name'))

@section('content')
    <!-- Hero Slider -->
    <div class="relative bg-gray-900">
        <!-- Slider -->
        <div class="swiper hero-slider h-[506px]">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                    <div class="swiper-slide">
                        <img src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
            <!-- Add Navigation -->
            <div class="swiper-button-next custom-nav-btn !hidden md:!flex">
                <i class="fas fa-chevron-right"></i>
            </div>
            <div class="swiper-button-prev custom-nav-btn !hidden md:!flex">
                <i class="fas fa-chevron-left"></i>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination custom-pagination"></div>
        </div>
    </div>

        <!-- Introduction Section -->
        <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="prose lg:prose-lg">
                    <div class="flex flex-col items-center text-center mb-4">
                        <img src="{{ asset('images/title.png') }}" alt="{{ __('company_name') }}" class="mb-2 w-[200px]">
                        <h1 class="text-3xl font-bold text-[var(--color-primary-600)]">{{ __('company_name') }}</h2>
                    </div>
                    <p class="text-gray-700 mb-4 text-justify">
                        {{ __('company_intro') }}
                    </p>
                    <p class="text-gray-700 text-justify">
                        {{ __('product_intro') }}
                    </p>
                    <a href="{{ route(app()->getLocale() . '.products') }}" class="flex items-center justify-center gap-2 hover:gap-4 w-full inline-block mt-6 px-6 py-2 bg-[var(--color-primary-600)] text-white text-center font-semibold rounded-[20px] hover:bg-[var(--color-primary-700)] transition-all duration-300 ease-in-out">
                        {{ __('view_more') }}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="relative">
                    <img src="{{ asset('images/overview.jpg') }}" alt="Yến sào Legia'Nest" class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Yến Chưng Products Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-[var(--color-primary-600)]">{{ __('premium_birds_nest') }}</h2>
                <a href="{{ route(app()->getLocale() . '.products', ['type' => 'yen_chung']) }}" class="text-[var(--color-primary-600)] hover:text-[var(--color-primary-700)] font-medium flex items-center gap-2">
                    {{ __('view_more') }}
                    <i class="fas fa-chevron-right text-sm"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($yenChungProducts as $product)
                    @include('frontend.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

    <!-- Yến Tổ Products Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-[var(--color-primary-600)]">{{ __('premium_birds_nest') }}</h2>
                <a href="{{ route(app()->getLocale() . '.products', ['type' => 'yen_to']) }}" class="text-[var(--color-primary-600)] hover:text-[var(--color-primary-700)] font-medium flex items-center gap-2">
                    {{ __('view_more') }}
                    <i class="fas fa-chevron-right text-sm"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($yenToProducts as $product)
                    @include('frontend.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gift Set Products Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-[var(--color-primary-600)]">{{ __('premium_gift_set') }}</h2>
                <a href="{{ route(app()->getLocale() . '.products', ['type' => 'gift_set']) }}" class="text-[var(--color-primary-600)] hover:text-[var(--color-primary-700)] font-medium flex items-center gap-2">
                    {{ __('view_more') }}
                    <i class="fas fa-chevron-right text-sm"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($giftSetProducts as $product)
                    @include('frontend.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-[var(--color-primary-600)] mb-12">{{ __('why_choose_us') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-primary-600 mb-6">
                        <i class="fas fa-shipping-fast text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('nationwide_shipping') }}</h3>
                    <p class="text-gray-600">{{ __('free_shipping') }}</p>
                </div>
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-primary-600 mb-6">
                        <i class="fas fa-certificate text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('quality_products') }}</h3>
                    <p class="text-gray-600">{{ __('pure_product') }}</p>
                </div>
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-primary-600 mb-6">
                        <i class="fas fa-sync text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('easy_returns') }}</h3>
                    <p class="text-gray-600">{{ __('return_policy') }}</p>
                </div>
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-primary-600 mb-6">
                        <i class="fas fa-headset text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('support_247') }}</h3>
                    <p class="text-gray-600">{{ __('professional_support') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Posts -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-[var(--color-primary-600)] mb-12">{{ __('latest_news') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestPosts as $post)
                    <article class="group">
                        <div class="relative rounded-lg overflow-hidden mb-4">
                            <img src="{{ Storage::url($post->featured_image) }}" 
                                 alt="{{ $post->title }}"
                                 class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black to-transparent">
                                <span class="text-sm text-white">{{ $post->published_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-primary-600">
                            <a href="{{ route(app()->getLocale() . '.posts.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-600 line-clamp-2">{{ $post->excerpt }}</p>
                    </article>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route(app()->getLocale() . '.posts') }}" 
                   class="inline-flex items-center px-6 py-3 border border-primary-600 text-base font-medium rounded-md text-primary-600 hover:bg-primary-50">
                    {{ __('view_all_news') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-[var(--color-primary-600)] mb-12">{{ __('customer_reviews') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex flex-col items-center justify-center gap-4 mb-4">
                            <img src="{{ Storage::url($testimonial->customer_avatar) }}" 
                                 alt="{{ $testimonial->customer_name }}"
                                 class="w-[240px] h-[240px] rounded-full object-cover">
                            <div class="ml-4">
                                <h4 class="text-xl font-semibold text-gray-900">{{ $testimonial->customer_name }}</h4>
                                @if($testimonial->position)
                                    <p class="text-md text-gray-600">{{ $testimonial->position }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-center text-yellow-400 mb-4"> 
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $testimonial->rating ? '' : '-o' }}"></i>
                            @endfor
                        </div>
                        <p class="text-gray-600 text-justify">{{ $testimonial->content }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Certificates -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-[var(--color-primary-600)] text-left mb-12">{{ __('certificates') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($certificates as $certificate)
                    <div class="group relative h-[540px] bg-white rounded-lg shadow-lg overflow-hidden cursor-pointer">
                        <a href="{{ Storage::url($certificate->image) }}" 
                           data-fancybox="certificates-gallery"
                           data-caption="{{ $certificate->name }}"
                           class="absolute inset-0 flex items-center justify-center">
                            <img src="{{ Storage::url($certificate->image) }}" 
                                 alt="{{ $certificate->name }}"
                                 class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-500">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        .custom-nav-btn {
            width: 50px !important;
            height: 50px !important;
            background-color: rgba(255, 255, 255, 0.9) !important;
            border-radius: 50% !important;
            color: var(--color-primary-600) !important;
            transition: all 0.3s ease;
        }

        .custom-nav-btn::after {
            display: none !important;
        }

        .custom-nav-btn:hover {
            background-color: #279149 !important;
            color: white !important;
        }

        .custom-nav-btn i {
            font-size: 20px;
        }

        .custom-pagination {
            bottom: 20px !important;
        }

        .custom-pagination .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            background-color: rgba(255, 255, 255, 0.5);
            opacity: 1;
            transition: all 0.3s ease;
        }

        .custom-pagination .swiper-pagination-bullet-active {
            background-color: #279149;
            width: 30px;
            border-radius: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        new Swiper('.hero-slider', {
            loop: true,
            autoplay: {
                delay: 5000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        Fancybox.bind("[data-fancybox]", {
            Carousel: {
                infinite: false,
            },
            Thumbs: {
                type: "classic",
            },
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [
                        "zoomIn",
                        "zoomOut",
                        "toggle1to1",
                        "rotateCCW",
                        "rotateCW",
                        "flipX",
                        "flipY",
                    ],
                    right: ["slideshow", "thumbs", "close"],
                },
            },
        });
    </script>
@endpush
