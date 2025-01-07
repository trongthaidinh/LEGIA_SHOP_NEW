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
                        <img src="{{ asset('images/title.png') }}" alt="Yến sào Legia'Nest" class="mb-2 w-[200px]">
                        <h2 class="text-3xl font-bold text-green-700">YẾN SÀO LEGIA'NEST</h2>
                    </div>
                    <p class="text-gray-700 mb-4 align-justify">
                        Chuyên phân phối <span class="font-semibold">tổ yến tưới, yến sào, yến chưng</span> nguyên chất 100%, 
                        cam kết <span class="text-red-600 font-bold">CHẤT LƯỢNG – KHÔNG PHA TRỘN</span>. Với mong muốn mang đến 
                        nguồn sản phẩm <span class="text-red-600 font-bold">NÂNG CAO SỨC KHỎE</span> cho người dùng, 
                        <span class="font-semibold">Legia'Nest</span> luôn đặt chất lượng sản phẩm lên hàng đầu, đặc biệt 
                        <span class="font-semibold">Yến sào Legia'Nest</span> đảm bảo giữ nguyên vị thuần tụy 100% từ tổ Yến tự nhiên.
                    </p>
                    <p class="text-gray-700 align-justify">
                        Mỗi sản phẩm yến sào mà chúng tôi cung cấp đều được chọn lọc kỹ lưỡng từ những nguồn nguyên liệu tốt nhất, 
                        đảm bảo an toàn và chất lượng. Yến sào không chỉ là một món ăn ngon mà còn là một nguồn dinh dụng phong phú, 
                        giúp tăng cường sức đề kháng, cải thiện sức khỏe tim mạch và hỗ trợ tiêu hóa.
                    </p>
                    <a href="{{ route('products') }}" class="flex items-center justify-center gap-2 hover:gap-4 w-full inline-block mt-6 px-6 py-2 bg-[var(--color-primary-600)] text-white text-center font-semibold rounded-[20px] hover:bg-[var(--color-primary-700)] transition-all duration-300 ease-in-out">
                        XEM THÊM
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="relative">
                    <img src="{{ asset('images/overview.jpg') }}" alt="Yến sào Legia'Nest" class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Danh mục sản phẩm</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($categories->take(4) as $category)
                    <a href="{{ route('products', ['category' => $category->slug]) }}" 
                       class="group relative rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="aspect-w-3 aspect-h-2">
                            <img src="{{ Storage::url($category->image) }}" 
                                 alt="{{ $category->name }}"
                                 class="object-cover transform group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="text-xl font-semibold text-white">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-200 mt-2">{{ $category->products_count }} sản phẩm</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Sản phẩm nổi bật</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts as $product)
                    <div class="group">
                        <div class="relative rounded-lg overflow-hidden">
                            <img src="{{ Storage::url($product->featured_image) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500">
                            @if($product->is_featured)
                                <div class="absolute top-4 left-4">
                                    <span class="bg-primary-600 text-white px-3 py-1 rounded-full text-sm">Hot</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity duration-300"></div>
                            <div class="absolute bottom-4 left-4 right-4 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                <button onclick="window.location.href='{{ route('cart.add', ['product_id' => $product->id]) }}'"
                                        class="w-full bg-white text-gray-900 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                                    Thêm vào giỏ hàng
                                </button>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <a href="{{ route('products.show', $product->slug) }}" class="hover:text-primary-600">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="mt-1 text-lg font-semibold text-primary-600">{{ $product->price_formatted }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('products') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                    Xem tất cả sản phẩm
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Tại sao chọn chúng tôi?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-primary-600 mb-6">
                        <i class="fas fa-shipping-fast text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Giao hàng toàn quốc</h3>
                    <p class="text-gray-600">Miễn phí giao hàng cho đơn hàng từ 500.000đ</p>
                </div>
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-primary-600 mb-6">
                        <i class="fas fa-certificate text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Sản phẩm chất lượng</h3>
                    <p class="text-gray-600">100% yến sào thiên nhiên nguyên chất</p>
                </div>
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-primary-600 mb-6">
                        <i class="fas fa-sync text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Đổi trả dễ dàng</h3>
                    <p class="text-gray-600">30 ngày đổi trả miễn phí</p>
                </div>
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-primary-600 mb-6">
                        <i class="fas fa-headset text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Hỗ trợ 24/7</h3>
                    <p class="text-gray-600">Tư vấn nhiệt tình, chuyên nghiệp</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Posts -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Tin tức mới nhất</h2>
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
                            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-600 line-clamp-2">{{ $post->excerpt }}</p>
                    </article>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('posts') }}" 
                   class="inline-flex items-center px-6 py-3 border border-primary-600 text-base font-medium rounded-md text-primary-600 hover:bg-primary-50">
                    Xem tất cả tin tức
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Khách hàng nói gì về chúng tôi?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex items-center mb-4">
                            <img src="{{ Storage::url($testimonial->customer_avatar) }}" 
                                 alt="{{ $testimonial->customer_name }}"
                                 class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $testimonial->customer_name }}</h4>
                                @if($testimonial->position)
                                    <p class="text-sm text-gray-600">{{ $testimonial->position }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex text-yellow-400 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $testimonial->rating ? '' : '-o' }}"></i>
                            @endfor
                        </div>
                        <p class="text-gray-600">{{ $testimonial->content }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Certificates -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Chứng nhận an toàn</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8">
                @foreach($certificates as $certificate)
                    <div class="group relative aspect-w-3 aspect-h-2">
                        <img src="{{ Storage::url($certificate->image) }}" 
                             alt="Certificate"
                             class="object-contain transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <style>
        /* Custom navigation buttons */
        .custom-nav-btn {
            width: 50px !important;
            height: 50px !important;
            background-color: rgba(255, 255, 255, 0.9) !important;
            border-radius: 50% !important;
            color: #279149 !important;
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

        /* Custom pagination */
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.hero-slider', {
                // Optional parameters
                loop: true,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                speed: 1000,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                
                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                
                // Pagination
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        });

        // Add to cart functionality
        function addToCart(productId) {
            fetch(`/cart/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                }
            });
        }
    </script>
@endpush
