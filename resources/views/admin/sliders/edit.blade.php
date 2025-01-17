                <!-- Time Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="starts_at" class="block text-sm font-medium text-gray-700">Thời gian bắt đầu</label>
                        <input type="datetime-local" 
                               name="starts_at" 
                               id="starts_at" 
                               value="{{ old('starts_at', $slider->starts_at ? $slider->starts_at->format('Y-m-d\TH:i') : '') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                    </div>
                    <div>
                        <label for="ends_at" class="block text-sm font-medium text-gray-700">Thời gian kết thúc</label>
                        <input type="datetime-local" 
                               name="ends_at" 
                               id="ends_at" 
                               value="{{ old('ends_at', $slider->ends_at ? $slider->ends_at->format('Y-m-d\TH:i') : '') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                    </div>
                </div>

                <!-- Is Active -->
                <div>
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               value="1"
                               {{ old('is_active', $slider->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-[var(--color-primary-600)] focus:ring-[var(--color-primary-500)] border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Hiển thị slider
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-[var(--color-primary-600)] text-white hover:bg-[var(--color-primary-700)] rounded-md">
                    <i class="fas fa-save mr-2"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 