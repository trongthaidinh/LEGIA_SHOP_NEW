@extends('frontend.layouts.master')

@section('title', __('Contact Us') . ' - ' . config('app.name'))

@section('content')
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
        {{-- Contact Information Section --}} 
        <div class="bg-white p-8 rounded-xl shadow-lg">
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl mb-4">
                    {{ __('Get in Touch') }}
                </h2>
                <p class="text-lg text-gray-600">
                    {{ __('We would love to hear from you. Send us a message and we\'ll respond as soon as possible.') }}
                </p>
            </div>

            <form action="{{ route(app()->getLocale() . '.contact.submit') }}" method="POST" class="space-y-6">
                @csrf
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">{{ __('Oops! Something went wrong.') }}</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">{{ __('Success!') }}</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Full Name') }}
                    </label>
                    <input type="text" id="name" name="name" required 
                           class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm 
                                  focus:ring-[var(--color-primary-500)] focus:border-[var(--color-primary-500)] transition duration-300 
                                  hover:border-[var(--color-primary-400)]">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Email Address') }}
                    </label>
                    <input type="email" id="email" name="email" required 
                           class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm 
                                  focus:ring-[var(--color-primary-500)] focus:border-[var(--color-primary-500)] transition duration-300 
                                  hover:border-[var(--color-primary-400)]">
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Your Message') }}
                    </label>
                    <textarea id="message" name="message" rows="5" required 
                              class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm 
                                     focus:ring-[var(--color-primary-500)] focus:border-[var(--color-primary-500)] transition duration-300 
                                     hover:border-[var(--color-primary-400)]"></textarea>
                </div>

                <div>
                    <button type="submit" 
                            class="w-full bg-[var(--color-primary-600)] hover:bg-[var(--color-primary-500)] text-white py-3 px-6 rounded-md 
                                   focus:outline-none focus:ring-2 focus:ring-[var(--color-primary-500)] focus:ring-offset-2 
                                   transition duration-300 ease-in-out transform hover:-translate-y-1 shadow-lg">
                        {{ __('Send Message') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Contact Details and Map Section --}}
        <div class="space-y-8">
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ __('Contact Details') }}</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">{{ __('Address') }}</p>
                            <p class="text-gray-600">{{ __('Your Company Address, City, Country') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">{{ __('Phone') }}</p>
                            <p class="text-gray-600">(+84) 772 332 255</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">{{ __('Email') }}</p>
                            <p class="text-gray-600">lxchinh@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                <div class="aspect-w-16 aspect-h-9">
                    <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3892.1975734353023!2d108.062342!3d12.700524!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3171f7e82916a097%3A0xf624f682171e01ef!2zNjIgTmd1eeG7hW4gSOG7r3UgVGjhu40sIFTDom4gQW4sIEJ1w7RuIE1hIFRodeG7mXQsIMSQ4bqvayBM4bqvaywgVmlldG5hbQ!5e0!3m2!1sen!2sus!4v1736622554726!5m2!1sen!2sus" 
                        class="w-full h-full object-cover"
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
