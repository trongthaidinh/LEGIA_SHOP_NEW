@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-images mr-2"></i> Thêm hình ảnh mới
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.images.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route(app()->getLocale() . '.admin.images.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Chọn hình ảnh
                    </label>
                    <div id="dropZone" class="mt-1 flex flex-col justify-center items-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative hover:border-blue-500 transition-colors cursor-pointer min-h-[200px]">
                        <!-- Preview container -->
                        <div id="previewContainer" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 w-full hidden">
                        </div>

                        <!-- Upload prompt -->
                        <div id="uploadPrompt" class="text-center">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                            <div class="flex items-center justify-center text-sm text-gray-600">
                                <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Tải lên hình ảnh</span>
                                    <input id="images" 
                                           name="images[]" 
                                           type="file" 
                                           class="sr-only"
                                           multiple
                                           accept="image/*">
                                </label>
                                <p class="pl-1">hoặc kéo thả vào đây</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                PNG, JPG, GIF tối đa 2MB
                            </p>
                        </div>
                    </div>
                    @error('images')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Visibility -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Phạm vi
                    </label>
                    <select name="visibility" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="public">Công khai</option>
                        <option value="private">Riêng tư</option>
                    </select>
                    @error('visibility')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition">
                        <i class="fas fa-save mr-2"></i> Lưu hình ảnh
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    console.log('Document ready');
    
    const dropZone = $('#dropZone');
    const previewContainer = $('#previewContainer');
    const uploadPrompt = $('#uploadPrompt');
    const fileInput = $('#images');
    let selectedFiles = new Set();

    console.log('Elements initialized:', {
        dropZone: dropZone.length,
        previewContainer: previewContainer.length,
        uploadPrompt: uploadPrompt.length,
        fileInput: fileInput.length
    });

    function showPreview(files) {
        console.log('showPreview called with files:', files);
        if (!files || files.length === 0) {
            console.log('No files provided');
            return;
        }

        console.log('Processing', files.length, 'files');
        
        previewContainer.empty();
        selectedFiles.clear();

        Array.from(files).forEach((file, index) => {
            console.log(`Processing file ${index + 1}:`, file.name);
            
            if (file && file.type.startsWith('image/')) {
                console.log('Valid image file:', file.name);
                selectedFiles.add(file);
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    console.log('File read successfully:', file.name);
                    
                    const previewCard = $(`
                        <div class="relative group bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="aspect-w-1 aspect-h-1">
                                <img src="${e.target.result}" class="object-cover w-full h-full rounded-lg" alt="${file.name}">
                            </div>
                            <button type="button" class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="p-2 text-center">
                                <p class="text-sm font-medium text-gray-900 truncate" title="${file.name}">${file.name}</p>
                                <p class="text-xs text-gray-500">${(file.size / (1024 * 1024)).toFixed(2)} MB</p>
                            </div>
                        </div>
                    `);

                    previewCard.find('button').on('click', function() {
                        console.log('Removing file:', file.name);
                        selectedFiles.delete(file);
                        previewCard.remove();
                        
                        if (selectedFiles.size === 0) {
                            console.log('No files remaining, showing upload prompt');
                            previewContainer.addClass('hidden');
                            uploadPrompt.removeClass('hidden');
                        }
                        updateFileInput();
                    });

                    previewContainer.append(previewCard);
                    console.log('Preview card added for:', file.name);
                };
                
                reader.onerror = function(error) {
                    console.error('Error reading file:', file.name, error);
                };
                
                console.log('Starting to read file:', file.name);
                reader.readAsDataURL(file);
            } else {
                console.warn('Skipping invalid file:', file.name, file.type);
            }
        });

        if (selectedFiles.size > 0) {
            console.log('Showing preview container with', selectedFiles.size, 'files');
            previewContainer.removeClass('hidden');
            uploadPrompt.addClass('hidden');
        } else {
            console.log('No valid images to preview');
            previewContainer.addClass('hidden');
            uploadPrompt.removeClass('hidden');
        }

        updateFileInput();
    }

    function updateFileInput() {
        console.log('Updating file input');
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => {
            console.log('Adding file to DataTransfer:', file.name);
            dataTransfer.items.add(file);
        });
        
        const input = fileInput[0];
        input.files = dataTransfer.files;
        
        console.log('File input updated:', {
            numberOfFiles: input.files.length,
            files: Array.from(input.files).map(f => f.name)
        });
    }

    // Handle file input change
    fileInput.on('change', function(e) {
        console.log('File input change event triggered');
        console.log('Files selected:', this.files);
        console.log('Number of files:', this.files.length);
        showPreview(this.files);
    });

    // Handle drag and drop
    dropZone.on('dragenter dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Drag enter/over event');
        $(this).addClass('border-blue-500');
    });
    
    dropZone.on('dragleave drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Drag leave/drop event');
        $(this).removeClass('border-blue-500');
    });
    
    dropZone.on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Drop event triggered');
        
        const dt = e.originalEvent.dataTransfer;
        const files = dt.files;
        
        console.log('Files dropped:', files);
        console.log('Number of files dropped:', files.length);
        
        showPreview(files);
    });

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.on(eventName, function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
        $(document).on(eventName, function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
    });
});
</script>
@endpush
@endsection 