<header class="bg-white hidden lg:block">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="/" class="flex items-center">
            <img src="{{ asset('images/logo_long.png') }}" alt="Logo" class="h-20">
        </a>
        <div class="relative">
            <form action="{{ route('posts.search') }}" method="GET">
                <input type="text" name="query" placeholder="Tìm kiếm ..." 
                       class="w-[300px] px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:border-green-500">
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</header>
