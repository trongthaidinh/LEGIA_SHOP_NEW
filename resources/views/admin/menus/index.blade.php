@extends('layouts.admin')

@section('content')
<div class="flex flex-col">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Menus</h2>
        <a href="{{ route(app()->getLocale() . '.admin.menus.create') }}" 
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Menu
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($menus as $menu)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $menu->name }}</h3>
                            <div class="mt-1 flex items-center space-x-2">
                                <span class="text-sm text-gray-500 capitalize">{{ $menu->type }}</span>
                                <span class="text-gray-300">•</span>
                                <span class="text-sm text-gray-500 uppercase">{{ $menu->language }}</span>
                            </div>
                        </div>
                        <span class="inline-flex px-2 text-xs leading-5 font-semibold rounded-full {{ $menu->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $menu->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="text-sm text-gray-500 mb-2">Menu Items:</div>
                        <div class="space-y-1">
                            @forelse($menu->items()->parents()->ordered()->take(3)->get() as $item)
                                <div class="flex items-center space-x-2">
                                    @if($item->icon_class)
                                        <i class="{{ $item->icon_class }} text-gray-400"></i>
                                    @endif
                                    <span class="text-sm">{{ $item->title }}</span>
                                    @if($item->children_count > 0)
                                        <span class="text-xs text-gray-400">({{ $item->children_count }} sub-items)</span>
                                    @endif
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No items yet</p>
                            @endforelse
                            @if($menu->items()->parents()->count() > 3)
                                <div class="text-sm text-gray-400">
                                    And {{ $menu->items()->parents()->count() - 3 }} more items...
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end space-x-2">
                        <a href="{{ route(app()->getLocale() . '.admin.menus.edit', $menu) }}" 
                           class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 rounded-md p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form action="{{ route(app()->getLocale() . '.admin.menus.destroy', $menu) }}" 
                              method="POST" 
                              class="inline-block" 
                              onsubmit="return confirm('Are you sure you want to delete this menu?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 rounded-md p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No menus</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new menu.</p>
                    <div class="mt-6">
                        <a href="{{ route(app()->getLocale() . '.admin.menus.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add New Menu
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $menus->links() }}
    </div>
</div>
@endsection 