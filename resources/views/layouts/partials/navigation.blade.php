@include('layouts.partials.mobile-nav')

<nav class="main-menu hidden lg:block">
    <div class="container mx-auto">
        <div class="menu-container">
            @foreach($mainMenus as $menu)
                <div class="menu-item">
                    <a href="@if($menu->children->count()) javascript:void(0) @else {{ $menu->url }} @endif" 
                       @if($menu->children->count()) class="has-submenu" @endif>
                        {{ mb_strtoupper($menu->name, 'UTF-8') }}
                    </a>
                    @if($menu->children->count())
                        <div class="submenu">
                            @foreach($menu->children as $child)
                                <div class="submenu-item">
                                    <a href="@if($child->children->count()) javascript:void(0) @else {{ $child->url }} @endif"
                                       @if($child->children->count()) class="has-submenu" @endif>
                                        {{ mb_convert_case($child->name, MB_CASE_TITLE, 'UTF-8') }}
                                    </a>
                                    @if($child->children->count())
                                        <div class="submenu-level-2">
                                            @foreach($child->children as $grandchild)
                                                <a href="{{ $grandchild->url }}">{{ mb_convert_case($grandchild->name, MB_CASE_TITLE, 'UTF-8') }}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            <div class="menu-item">
                <a href="javascript:void(0)" class="has-submenu">
                    TRUYỀN THÔNG
                </a>
                <div class="submenu">
                    <a href="https://www.facebook.com/caodangytedaklak">Facebook</a>
                    <a href="#">Zalo</a>
                </div>
            </div>
        </div>
    </div>
</nav>
