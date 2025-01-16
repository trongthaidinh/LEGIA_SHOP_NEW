@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Testimonials') }}</h1>
        <a href="{{ route(app()->getLocale() . '.admin.testimonials.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>{{ __('Add New') }}
        </a>
    </div>

    <!-- Language Filter -->
    <div class="mb-6">
        <form action="{{ route(app()->getLocale() . '.admin.testimonials.index') }}" method="GET" class="flex items-center space-x-4">
            <label for="language" class="text-sm font-medium text-gray-700">{{ __('Language') }}:</label>
            <select name="language" id="language" class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200" onchange="this.form.submit()">
                <option value="vi" {{ $language === 'vi' ? 'selected' : '' }}>{{ __('Vietnamese') }}</option>
                <option value="zh" {{ $language === 'zh' ? 'selected' : '' }}>{{ __('Chinese') }}</option>
            </select>
        </form>
    </div>

    <!-- Testimonials List -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Content') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rating') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($testimonials as $testimonial)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($testimonial->customer_avatar)
                                    <img src="{{ Storage::url($testimonial->customer_avatar) }}" alt="{{ $testimonial->customer_name }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                        <i class="fas fa-user text-primary-500"></i>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $testimonial->customer_name }}</div>
                                    @if($testimonial->customer_position)
                                        <div class="text-sm text-gray-500">{{ $testimonial->customer_position }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 line-clamp-2">{{ $testimonial->content }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $testimonial->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($testimonial->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route(app()->getLocale() . '.admin.testimonials.edit', $testimonial) }}" class="text-primary-600 hover:text-primary-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route(app()->getLocale() . '.admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure you want to delete this testimonial?') }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            {{ __('No testimonials found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $testimonials->links() }}
    </div>
</div>
@endsection 