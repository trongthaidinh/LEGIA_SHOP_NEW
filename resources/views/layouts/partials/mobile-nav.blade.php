<div class="mobile-nav-bar fixed top-0 left-0 right-0 bg-white shadow-md lg:hidden z-[1000]">
    <div class="container mx-auto px-4 h-[var(--mobile-header-height)] flex items-center justify-between">
        <button onclick="toggleMobileMenu()" class="text-primary hover:text-primary-dark focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition-all duration-300">
            <svg class="h-6 w-6 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="menuIcon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div class="flex-1 flex justify-center">
            <a href="/" class="block transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            </a>
        </div>

        <button onclick="toggleMobileSearch()" class="text-primary hover:text-primary-dark focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition-all duration-300">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>
    </div>

    <div id="mobile-search" class="hidden bg-white px-4 py-3 border-t border-gray-100 shadow-inner transform transition-transform duration-300 -translate-y-full">
        <form action="{{ route('posts.search') }}" method="GET" class="relative">
            <input type="text" name="query" placeholder="Tìm kiếm ..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-primary hover:text-primary-dark transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </form>
    </div>
</div>

<div id="mobile-menu" class="fixed inset-0 transition-all duration-300 ease-in-out opacity-0 pointer-events-none lg:hidden z-[1001]">
    <div class="absolute inset-0 bg-black/50 transition-opacity duration-300 ease-in-out opacity-0" id="menu-overlay"></div>
    
    <div class="absolute top-0 left-0 w-4/5 max-w-sm h-full bg-white transform -translate-x-full transition-transform duration-300 ease-out" id="menu-content">
        <div class="h-full overflow-y-auto">
            <div class="px-4 py-3 bg-primary text-white flex items-center justify-between">
                <h2 class="text-xl font-bold">Menu</h2>
                <button onclick="toggleMobileMenu()" class="p-2 hover:bg-primary-dark rounded-full transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <nav class="py-2">
                @foreach($mainMenus as $menu)
                    <div x-data="{ open: false, submenu: null }">
                        @if($menu->children->count())
                            <button @click="open = !open" 
                                    class="w-full text-left flex justify-between items-center hover:text-primary py-3 px-4 border-b border-gray-100">
                                {{ mb_strtoupper($menu->name, 'UTF-8') }}
                                <svg :class="{'rotate-180': open}" class="h-4 w-4 transform transition-transform duration-200" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 class="pl-4 border-l-2 border-primary/20">
                                @foreach($menu->children as $child)
                                    <div class="relative">
                                        @if($child->children->count())
                                            <div class="flex items-center justify-between hover:text-primary py-2 pr-4"
                                                 @click="submenu === '{{ $child->id }}' ? submenu = null : submenu = '{{ $child->id }}'">
                                                <span>{{ mb_convert_case($child->name, MB_CASE_TITLE, 'UTF-8') }}</span>
                                                <i class="fas fa-chevron-down text-xs ml-2 transition-transform duration-200"
                                                   :class="{'rotate-180': submenu === '{{ $child->id }}'}"></i>
                                            </div>
                                            <div x-show="submenu === '{{ $child->id }}'"
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                                 x-transition:leave="transition ease-in duration-150"
                                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                                 class="pl-4 border-l-2 border-primary/10">
                                                @foreach($child->children as $grandchild)
                                                    <a href="{{ $grandchild->url }}" 
                                                       class="block py-2 text-sm hover:text-primary">
                                                        <i class="fas fa-circle-dot text-[6px] mr-2 align-middle opacity-50"></i>
                                                        {{ mb_convert_case($grandchild->name, MB_CASE_TITLE, 'UTF-8') }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <a href="{{ $child->url }}" class="block py-2 hover:text-primary">
                                                {{ mb_convert_case($child->name, MB_CASE_TITLE, 'UTF-8') }}
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <a href="{{ $menu->url }}" class="block hover:text-primary py-3 px-4 border-b border-gray-100">
                                {{ mb_strtoupper($menu->name, 'UTF-8') }}
                            </a>
                        @endif
                    </div>
                @endforeach

                <button class="mobile-submenu-button w-full text-left flex justify-between items-center hover:text-primary py-3 px-4 border-b border-gray-100">
                    TRUYỀN THÔNG
                    <svg class="h-4 w-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="mobile-submenu hidden pl-4 mt-2 border-l-2 border-primary/20">
                    <a href="https://www.facebook.com/truongcdytedaklak" target="_blank" class="block py-2 hover:text-primary">
                        Facebook
                    </a>
                    <a href="#" target="_blank" class="block py-2 hover:text-primary">
                        Zalo
                    </a>
                </div>
            </nav>
        </div>
    </div>
</div>

<style>
    #mobile-menu.active {
        opacity: 1;
        pointer-events: auto;
    }
    
    #mobile-menu.active #menu-overlay {
        opacity: 1;
    }
    
    #mobile-menu.active #menu-content {
        transform: translateX(0);
    }
    
    #menuIcon.active {
        transform: rotate(90deg);
    }
    
    #mobile-search.active {
        display: block;
        transform: translateY(0);
    }
    
    #menu-content::-webkit-scrollbar {
        width: 4px;
    }
    
    #menu-content::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    #menu-content::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 2px;
    }
    
    #menu-content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menuIcon');
        menu.classList.toggle('active');
        menuIcon.classList.toggle('active');
        
        const search = document.getElementById('mobile-search');
        if (search.classList.contains('active')) {
            search.classList.remove('active');
        }
    }
    
    function toggleMobileSearch() {
        const search = document.getElementById('mobile-search');
        search.classList.toggle('active');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const submenuButtons = document.querySelectorAll('.mobile-submenu-button');
        
        submenuButtons.forEach(button => {
            button.addEventListener('click', function() {
                const submenu = this.nextElementSibling;
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                
                this.setAttribute('aria-expanded', !isExpanded);
                
                if (isExpanded) {
                    submenu.style.maxHeight = '0px';
                    setTimeout(() => {
                        submenu.classList.add('hidden');
                    }, 200);
                } else {
                    submenu.classList.remove('hidden');
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                }
            });
        });

        const overlay = document.getElementById('menu-overlay');
        if (overlay) {
            overlay.addEventListener('click', toggleMobileMenu);
        }
    });
</script>
