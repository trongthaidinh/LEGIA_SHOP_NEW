@extends('layouts.admin')

@section('content')
<div class="flex flex-col">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Edit Menu</h2>
        <a href="{{ route(app()->getLocale() . '.admin.menus.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to List
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route(app()->getLocale() . '.admin.menus.update', $menu) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Name <span class="text-red-600">*</span>
                        </label>
                        <input type="text" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $menu->name) }}" 
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                            Type <span class="text-red-600">*</span>
                        </label>
                        <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('type') border-red-500 @enderror" 
                                id="type" 
                                name="type" 
                                required>
                            <option value="main" {{ old('type', $menu->type) == 'main' ? 'selected' : '' }}>Main Menu</option>
                            <option value="footer" {{ old('type', $menu->type) == 'footer' ? 'selected' : '' }}>Footer Menu</option>
                            <option value="sidebar" {{ old('type', $menu->type) == 'sidebar' ? 'selected' : '' }}>Sidebar Menu</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- add language by url --}}
                    <input type="hidden" name="language" value="{{ request()->segment(1) }}">

                    {{-- <div class="mb-6">
                    <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                        Language <span class="text-red-600">*</span>
                    </label>
                    <select class="form-select w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('language') border-red-500 @enderror" 
                            id="language" 
                            name="language" 
                            required>
                        <option value="vi" {{ old('language', $menu->language) == 'vi' ? 'selected' : '' }}>Vietnamese</option>
                        <option value="en" {{ old('language', $menu->language) == 'en' ? 'selected' : '' }}>English</option>
                    </select>
                    @error('language')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-600">Active</span>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end">
                    <button type="submit" 
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Update Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
