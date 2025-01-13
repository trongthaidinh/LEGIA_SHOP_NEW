@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-video mr-2"></i> Chỉnh sửa video
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.videos.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route(app()->getLocale() . '.admin.videos.update', $video) }}" 
                  method="POST" 
                  class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Current Video Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Video hiện tại
                    </label>
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe src="{{ $video->embed_url }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                class="rounded-lg">
                        </iframe>
                    </div>
                </div>

                <!-- Youtube URL -->
                <div>
                    <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-2">
                        URL Youtube
                    </label>
                    <div class="mt-1">
                        <input type="url" 
                               name="youtube_url" 
                               id="youtube_url"
                               value="{{ old('youtube_url', $video->youtube_url) }}"
                               placeholder="https://www.youtube.com/watch?v=..."
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    @error('youtube_url')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">
                        Hỗ trợ các định dạng URL: youtube.com/watch, youtu.be, youtube.com/embed
                    </p>
                </div>

                <!-- New Video Preview -->
                <div id="videoPreview" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Xem trước video mới
                    </label>
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe id="previewFrame" 
                                src="" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                class="rounded-lg">
                        </iframe>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active"
                               value="1"
                               {{ old('is_active', $video->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Kích hoạt
                        </label>
                    </div>
                    @error('is_active')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                        Thứ tự
                    </label>
                    <div class="mt-1">
                        <input type="number" 
                               name="order" 
                               id="order"
                               value="{{ old('order', $video->order) }}"
                               min="0"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    @error('order')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition">
                        <i class="fas fa-save mr-2"></i> Cập nhật video
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    function getYoutubeId(url) {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[2].length === 11) ? match[2] : null;
    }

    $('#youtube_url').on('input', function() {
        const url = $(this).val();
        const videoId = getYoutubeId(url);
        
        if (videoId) {
            const embedUrl = `https://www.youtube.com/embed/${videoId}`;
            $('#previewFrame').attr('src', embedUrl);
            $('#videoPreview').removeClass('hidden');
        } else {
            $('#videoPreview').addClass('hidden');
            $('#previewFrame').attr('src', '');
        }
    });
});
</script>
@endpush
@endsection 