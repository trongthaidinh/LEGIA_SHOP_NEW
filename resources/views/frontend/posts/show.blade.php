@extends('frontend.layouts.master')

@section('title', $post->title . ' - ' . config('app.name'))

@section('content')
    <!-- Main Content Section -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Article -->
                <div class="lg:col-span-2">
                    <article class="bg-white rounded-2xl shadow-[var(--shadow-lg)] p-8 
                                  border border-[var(--color-primary-100)]">
                        <!-- Title and Date -->
                        <div class="mb-8 pb-8 border-b border-[var(--color-primary-100)]">
                            <h1 class="text-4xl font-bold text-[var(--color-primary-800)] mb-4">
                                {{ $post->title }}
                            </h1>
                            <div class="flex items-center text-[var(--color-primary-600)]">
                                <i class="far fa-calendar-alt mr-2"></i>
                                {{ $post->published_at->format('d/m/Y') }}
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="prose prose-lg max-w-none">
                            {!! $post->content !!}
                        </div>

                        <!-- Share Buttons -->
                        <div class="flex items-center gap-6 mt-8 pt-8 border-t border-[var(--color-primary-100)]">
                            <span class="text-[var(--color-primary-700)] font-medium">{{ __('share') }}:</span>
                            <div class="flex gap-6">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-700 transform hover:scale-110 transition-all duration-300">
                                    <i class="fab fa-facebook-square text-2xl"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" 
                                   target="_blank"
                                   class="text-blue-400 hover:text-blue-500 transform hover:scale-110 transition-all duration-300">
                                    <i class="fab fa-twitter-square text-2xl"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}" 
                                   target="_blank"
                                   class="text-blue-700 hover:text-blue-800 transform hover:scale-110 transition-all duration-300">
                                    <i class="fab fa-linkedin text-2xl"></i>
                                </a>
                            </div>
                        </div>
                    </article>

                    <!-- Related Posts with enhanced styling -->
                    @if($relatedPosts->count() > 0)
                        <div class="mt-12">
                            <h2 class="text-2xl font-bold text-[var(--color-primary-700)] mb-8">
                                {{ __('related_posts') }}
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                @foreach($relatedPosts as $relatedPost)
                                    <article class="bg-white rounded-xl shadow-[var(--shadow)] overflow-hidden group
                                                border border-[var(--color-primary-100)] hover:shadow-[var(--shadow-lg)]
                                                transition-all duration-300">
                                        <div class="relative h-48 overflow-hidden">
                                            <img src="{{ Storage::url($relatedPost->featured_image) }}" 
                                                 alt="tổ yến"
                                                 class="w-full h-full object-cover transform group-hover:scale-110 
                                                        transition-transform duration-500">
                                            <div class="absolute inset-0 bg-gradient-to-t 
                                                        from-[var(--color-primary-900)] to-transparent opacity-60"></div>
                                            <div class="absolute bottom-4 left-4">
                                                <span class="text-sm text-white bg-[var(--color-primary-600)]/80 
                                                           px-3 py-1 rounded-full backdrop-blur-sm">
                                                    {{ $relatedPost->published_at->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-6">
                                            <h3 class="text-xl font-semibold text-[var(--color-primary-800)] 
                                                       group-hover:text-[var(--color-primary-600)] transition-colors 
                                                       duration-300 line-clamp-2">
                                                <a href="{{ route(app()->getLocale() . '.posts.show', $relatedPost->slug) }}">
                                                    {{ $relatedPost->title }}
                                                </a>
                                            </h3>
                                            <p class="mt-2 text-gray-600 line-clamp-2">{{ $relatedPost->excerpt }}</p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-[var(--shadow)] p-6 
                                border border-[var(--color-primary-100)]">
                        <h3 class="text-xl font-bold text-[var(--color-primary-700)] mb-6">
                            {{ __('latest_news') }}
                        </h3>
                        <div class="space-y-6">
                            @foreach($relatedPosts as $latestPost)
                                <div class="flex gap-4 group">
                                    <img src="{{ Storage::url($latestPost->featured_image) }}" 
                                         alt="{{ $latestPost->title }}"
                                         class="w-20 h-20 rounded-lg object-cover flex-shrink-0 
                                                group-hover:opacity-80 transition-opacity duration-300">
                                    <div>
                                        <h4 class="font-medium text-[var(--color-primary-800)] 
                                                   group-hover:text-[var(--color-primary-600)] 
                                                   transition-colors duration-300 line-clamp-2">
                                            <a href="{{ route(app()->getLocale() . '.posts.show', $latestPost->slug) }}">
                                                {{ $latestPost->title }}
                                            </a>
                                        </h4>
                                        <span class="text-sm text-gray-500">
                                            {{ $latestPost->published_at->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .prose {
        @apply text-gray-800 leading-relaxed;
    }
    .prose h2 {
        @apply text-2xl font-bold text-[var(--color-primary-800)] mt-8 mb-4;
    }
    .prose h3 {
        @apply text-xl font-bold text-[var(--color-primary-700)] mt-6 mb-3;
    }
    .prose p {
        @apply mb-4 text-justify;
    }
    .prose ul {
        @apply list-disc list-inside mb-4 ml-4;
    }
    .prose ol {
        @apply list-decimal list-inside mb-4 ml-4;
    }
    .prose img {
        @apply rounded-xl my-6 max-w-full h-auto mx-auto shadow-[var(--shadow-lg)];
    }
    .prose a {
        @apply text-[var(--color-primary-600)] hover:text-[var(--color-primary-700)] underline;
    }
    .prose blockquote {
        @apply border-l-4 border-[var(--color-primary-500)] pl-4 italic my-4 
               text-gray-700 bg-[var(--color-primary-50)] py-3 rounded-r-lg;
    }
    .prose pre {
        @apply bg-gray-800 text-white p-4 rounded-lg overflow-x-auto my-4;
    }
    .prose code {
        @apply bg-[var(--color-primary-50)] text-[var(--color-primary-700)] px-1.5 py-0.5 rounded;
    }
    .prose table {
        @apply w-full border-collapse border border-[var(--color-primary-200)] my-4;
    }
    .prose th, .prose td {
        @apply border border-[var(--color-primary-200)] p-2;
    }
    .prose th {
        @apply bg-[var(--color-primary-50)];
    }

    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }

    .delay-200 {
        animation-delay: 200ms;
    }
</style>
@endpush 