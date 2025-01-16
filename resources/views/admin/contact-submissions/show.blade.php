@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Contact Submission Details') }}</h1>
        <div class="flex items-center space-x-4">
            <a href="{{ route(app()->getLocale() . '.admin.contact-submissions.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to List') }}
            </a>
            @if($submission->status !== 'replied')
                <form action="{{ route(app()->getLocale() . '.admin.contact-submissions.mark-replied', $submission) }}" method="POST" class="inline-block">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors duration-200">
                        <i class="fas fa-check mr-2"></i>{{ __('Mark as Replied') }}
                    </button>
                </form>
            @endif
            <form action="{{ route(app()->getLocale() . '.admin.contact-submissions.destroy', $submission) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors duration-200" onclick="return confirm('{{ __('Are you sure you want to delete this submission?') }}')">
                    <i class="fas fa-trash mr-2"></i>{{ __('Delete') }}
                </button>
            </form>
        </div>
    </div>

    <div class="bg-gray-50 rounded-lg p-6 space-y-6">
        <!-- Status Badge -->
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-gray-500">{{ __('Status') }}</span>
            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                {{ $submission->status === 'new' ? 'bg-yellow-100 text-yellow-800' : '' }}
                {{ $submission->status === 'read' ? 'bg-blue-100 text-blue-800' : '' }}
                {{ $submission->status === 'replied' ? 'bg-green-100 text-green-800' : '' }}">
                {{ ucfirst($submission->status) }}
            </span>
        </div>

        <!-- Submission Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500">{{ __('Name') }}</h3>
                <p class="mt-1 text-lg text-gray-900">{{ $submission->name }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">{{ __('Email') }}</h3>
                <p class="mt-1 text-lg text-gray-900">
                    <a href="mailto:{{ $submission->email }}" class="text-primary-600 hover:text-primary-900">
                        {{ $submission->email }}
                    </a>
                </p>
            </div>
        </div>

        <!-- Message -->
        <div>
            <h3 class="text-sm font-medium text-gray-500">{{ __('Message') }}</h3>
            <div class="mt-2 p-4 bg-white rounded-lg border border-gray-200">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $submission->message }}</p>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-gray-200">
            <div>
                <h3 class="text-sm font-medium text-gray-500">{{ __('Submission Date') }}</h3>
                <p class="mt-1 text-gray-900">{{ $submission->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">{{ __('IP Address') }}</h3>
                <p class="mt-1 text-gray-900">{{ $submission->ip_address ?? 'N/A' }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">{{ __('Language') }}</h3>
                <p class="mt-1 text-gray-900">{{ strtoupper($submission->locale) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection 