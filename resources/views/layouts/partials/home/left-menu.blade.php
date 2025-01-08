<nav class="bg-primary-dark sticky top-0 h-full hidden lg:block">
    <ul class="">
        @foreach($mainMenus->filter(function($menu) { return strtolower($menu->name) !== 'trang chủ'; }) as $menu)
            <li x-data="{ open: true }">
                <div class="w-full flex items-center justify-between p-2 text-white bg-primary hover:bg-white/10 transition-all">
                    @if($menu->children->count())
                        <span class="px-4 py-1 font-bold cursor-pointer" @click="open = !open">{{ mb_strtoupper($menu->name, 'UTF-8') }}</span>
                        <button @click="open = !open" class="focus:outline-none">
                            <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    @else
                        <a href="{{ $menu->url }}" class="px-4 py-1 font-bold">{{ mb_strtoupper($menu->name, 'UTF-8') }}</a>
                    @endif
                </div>

                @if($menu->children->count())
                    <ul x-show="open" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                        class="space-y-1">
                        @foreach($menu->children as $child)
                            <li class="relative group">
                                <div class="flex items-center justify-between hover:bg-white/10 transition-all">
                                    <a href="{{ $child->url }}" 
                                       class="block w-full px-6 py-3 text-white text-sm hover:bg-white/10 transition-all">
                                        {{ mb_convert_case($child->name, MB_CASE_TITLE, 'UTF-8') }}
                                        @if($child->children->count())
                                            <i class="fas fa-chevron-left text-xs absolute right-4 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                                        @endif
                                    </a>
                                </div>
                                @if($child->children->count())
                                    <div class="absolute left-full top-0 invisible group-hover:visible opacity-0 group-hover:opacity-100 
                                                transition-all duration-200 transform translate-x-1 group-hover:translate-x-0">
                                        <div class="h-full">
                                            <ul class="min-w-[280px] bg-primary shadow-lg">
                                                @foreach($child->children as $grandchild)
                                                    <li>
                                                        <a href="{{ $grandchild->url }}" 
                                                           class="block px-4 py-3 text-white hover:bg-white/10 text-sm transition-all">
                                                            <i class="fas fa-circle-dot text-[6px] mr-2 align-middle"></i>
                                                            {{ mb_convert_case($grandchild->name, MB_CASE_TITLE, 'UTF-8') }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
