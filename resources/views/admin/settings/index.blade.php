@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <h3 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-cogs mr-2"></i> Cài đặt hệ thống
            </h3>
        </div>

        @if(session('success'))
        <div class="p-4">
            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route(app()->getLocale() . '.admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="space-y-8">
                @foreach($settings as $group => $groupSettings)
                <div class="bg-gray-50 rounded-lg p-6">
                    <h4 class="text-lg font-medium text-[var(--color-primary-700)] mb-4 capitalize">
                        {{ $group }}
                    </h4>
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($groupSettings as $setting)
                            <div>
                                <label for="settings_{{ $setting->id }}" class="block text-sm font-medium text-gray-700">
                                    {{ $setting->label }}
                                    @if($setting->description)
                                        <span class="text-sm text-gray-500">({{ $setting->description }})</span>
                                    @endif
                                </label>

                                @switch($setting->type)
                                    @case('textarea')
                                        <textarea 
                                            name="settings[{{ $setting->id }}]" 
                                            id="settings_{{ $setting->id }}"
                                            rows="3"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]"
                                        >{{ old("settings.{$setting->id}", $setting->value) }}</textarea>
                                        @break

                                    @case('image')
                                        <div class="mt-1 flex items-center">
                                            @if($setting->value)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $setting->value) }}" 
                                                         alt="{{ $setting->label }}" 
                                                         class="h-20 w-auto object-contain">
                                                </div>
                                            @endif
                                            <input 
                                                type="file" 
                                                name="settings[{{ $setting->id }}]" 
                                                id="settings_{{ $setting->id }}"
                                                accept="image/*"
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[var(--color-primary-50)] file:text-[var(--color-primary-700)] hover:file:bg-[var(--color-primary-100)]"
                                            >
                                        </div>
                                        @break

                                    @case('boolean')
                                        <div class="mt-1">
                                            <label class="inline-flex items-center">
                                                <input 
                                                    type="checkbox" 
                                                    name="settings[{{ $setting->id }}]" 
                                                    value="1"
                                                    {{ old("settings.{$setting->id}", $setting->value) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-[var(--color-primary-600)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]"
                                                >
                                                <span class="ml-2 text-sm text-gray-600">Kích hoạt</span>
                                            </label>
                                        </div>
                                        @break

                                    @default
                                        <input 
                                            type="text" 
                                            name="settings[{{ $setting->id }}]" 
                                            id="settings_{{ $setting->id }}"
                                            value="{{ old("settings.{$setting->id}", $setting->value) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]"
                                        >
                                @endswitch

                                @error("settings.{$setting->id}")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-600)] text-white hover:bg-[var(--color-primary-700)] rounded-md">
                    <i class="fas fa-save mr-2"></i> Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 