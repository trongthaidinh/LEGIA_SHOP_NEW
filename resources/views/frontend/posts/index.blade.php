@extends('frontend.layouts.master')

@section('title', __('posts') . ' - ' . config('app.name'))

@section('content')
    <div class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Post Categories Sidebar -->
                <div class="lg:col-span-1 order-first lg:order-first">
                    <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">
                        <h3 class="text-2xl font-bold text-[var(--color-primary-800)] mb-6 pb-3 border-b border-gray-200">
                            {{ __('post_categories') }}
                        </h3>
                        <ul class="space-y-2">
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route(app()->getLocale() . '.posts', ['category' => $category->slug]) }}" 
                                       class="flex items-center 
                                              text-gray-700 
                                              hover:text-[var(--color-primary-900)] 
                                              transition-colors 
                                              group
                                              px-3 py-2 
                                              rounded-lg
                                              {{ request('category') === $category->slug ? 'bg-[var(--color-primary-50)] text-[var(--color-primary-700)]' : '' }}">
                                        <span class="w-2 h-2 rounded-full mr-3 
                                                    {{ request('category') === $category->slug 
                                                       ? 'bg-[var(--color-primary-600)]' 
                                                       : 'bg-gray-300' }}"></span>
                                        <span class="{{ request('category') === $category->slug ? 'font-semibold' : 'font-medium' }}">
                                            {{ $category->name }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-2 order-last lg:order-none space-y-12">
                    <!-- Page Header -->
                    <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                        <h1 class="text-4xl font-bold text-[var(--color-primary-800)] mb-4">
                            {{ __('posts') }}
                        </h1>
                        @if(request('category'))
                            <p class="text-gray-600 flex items-center">
                                <i class="fas fa-filter mr-2 text-[var(--color-primary-500)]"></i>
                                {{ __('Showing posts in category') }}: 
                                <span class="font-semibold ml-2 text-[var(--color-primary-700)]">
                                    {{ request('category') }}
                                </span>
                            </p>
                        @endif
                    </div>

                    <!-- Featured Posts -->
                    @if($featuredPosts->count() > 0)
                        <div class="mb-12">
                            <h2 class="text-3xl font-bold text-[var(--color-primary-800)] mb-6">
                                {{ __('featured_posts') }}
                            </h2>
                            <div class="grid md:grid-cols-3 gap-6">
                                @foreach($featuredPosts as $featuredPost)
                                    <div class="bg-white rounded-2xl shadow-md overflow-hidden 
                                                transform transition-all duration-300 
                                                hover:-translate-y-2 hover:shadow-lg">
                                        <a href="{{ route(app()->getLocale() . '.posts.show', $featuredPost->slug) }}">
                                            <div class="aspect-w-16 aspect-h-9">
                                                <img src="{{ Storage::url($featuredPost->featured_image) }}" 
                                                     alt="{{ $featuredPost->title }}" 
                                                     class="w-full h-full object-cover 
                                                            transition-transform duration-300 
                                                            group-hover:scale-105">
                                            </div>
                                            <div class="p-5">
                                                <h3 class="text-lg font-bold text-[var(--color-primary-700)] mb-2 line-clamp-2">
                                                    {{ $featuredPost->title }}
                                                </h3>
                                                <div class="text-sm text-gray-500 flex items-center">
                                                    <i class="far fa-calendar-alt mr-2"></i>
                                                    {{ $featuredPost->published_at->format('d/m/Y') }}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- All Posts Grid -->
                    <div>
                        <div class="grid md:grid-cols-2 gap-8">
                            @foreach($posts as $post)
                                <div class="bg-white rounded-2xl shadow-md overflow-hidden 
                                            transition-all duration-300 
                                            hover:shadow-xl 
                                            hover:-translate-y-2 
                                            group">
                                    <a href="{{ route(app()->getLocale() . '.posts.show', $post->slug) }}">
                                        <div class="aspect-w-16 aspect-h-9">
                                            <img src="{{ Storage::url($post->featured_image) }}" 
                                                 alt="{{ $post->title }}" 
                                                 class="w-full h-full object-cover 
                                                        group-hover:scale-105 
                                                        transition-transform">
                                        </div>
                                    </a>
                                    <div class="p-6">
                                        <h3 class="text-xl font-semibold mb-2 text-[var(--color-primary-700)] 
                                                   hover:text-[var(--color-primary-900)] 
                                                   transition-colors">
                                            <a href="{{ route(app()->getLocale() . '.posts.show', $post->slug) }}">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 mb-4 line-clamp-3">
                                            {{ Str::limit($post->excerpt, 150) }}
                                        </p>
                                        <div class="flex items-center text-gray-500 text-sm">
                                            <i class="far fa-calendar-alt mr-2"></i>
                                            {{ $post->published_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12 flex justify-center">
                            {{ $posts->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
