<div class="bg-primary-dark px-6 py-8 h-full">
    <h2 class="text-xl font-bold mb-6 text-white border-b border-white/30 pb-2">THÔNG TIN TUYỂN SINH</h2>
    <div class="space-y-6">
        @forelse($recruitmentPosts as $post)
        <div class="group">
            <a href="{{ route('posts.show', $post->slug) }}" class="block transition duration-300 bg-white/10 rounded-lg p-4 hover:bg-white/20">
                @if($post->coverImage)
                    <img src="{{ $post->coverImage->full_url }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-50 object-cover rounded-lg mb-4">
                @else
                    <div class="w-full h-50 bg-white/5 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                
                <h3 class="text-white text-md font-semibold group-hover:text-white/90 line-clamp-2 mb-2">{{ $post->title }}</h3>
                
                <p class="text-white/70 text-xs line-clamp-3 mb-3">
                    {{ Str::limit($post->summary ?? $post->content, 150) }}
                </p>

                <div class="flex items-center text-white/50 text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ \Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}
                </div>
            </a>
        </div>
        @empty
        <div class="text-white/70 text-center py-4">
            Chưa có thông tin tuyển sinh
        </div>
        @endforelse
    </div>
</div>
