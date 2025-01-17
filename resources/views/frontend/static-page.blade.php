@extends('frontend.layouts.master')

@section('title', $title . ' - ' . config('app.name'))

@section('meta_description', $metaDescription)
@section('meta_keywords', $metaKeywords)

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-7xl mx-auto">
        <article class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-8 md:p-12">
                <header class="mb-8 pb-4 border-b border-[var(--color-primary-100)]">
                    <h1 class="text-3xl font-bold text-[var(--color-primary-600)] leading-tight">
                        {{ $page->title }}
                    </h1>
                </header>
                
                <div class="prose prose-lg max-w-none text-gray-800 space-y-5">
                    {!! $page->content !!}
                </div>

                @if(!empty($metaDescription))
                <footer class="mt-8 pt-6 border-t border-[var(--color-secondary-100)] text-sm text-[var(--color-secondary-900)] italic">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[var(--color-secondary-500)]" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        {{ $metaDescription }}
                    </div>
                </footer>
                @endif
            </div>
        </article>
    </div>
</div>
@endsection

@push('styles')
<style>
    .prose a {
        @apply text-[var(--color-primary-500)] hover:text-[var(--color-primary-700)] transition-colors font-medium;
    }
    .prose strong {
        @apply text-[var(--color-primary-800)] font-semibold;
    }
    .prose h2, .prose h3 {
        @apply text-[var(--color-primary-600)] font-bold mt-6 mb-4;
    }
    .prose blockquote {
        @apply border-l-4 border-[var(--color-secondary-500)] pl-4 italic text-gray-600 bg-[var(--color-secondary-50)] py-2 rounded;
    }
    .prose ul, .prose ol {
        @apply pl-6 list-outside;
    }
    .prose li {
        @apply mb-2 pl-2;
    }
</style>
@endpush
