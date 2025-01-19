@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-images mr-2"></i> Quản lý Slider
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.sliders.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md">
                        <i class="fas fa-plus mr-2"></i> Thêm slider mới
                    </a>
                </div>
            </div>
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

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[var(--color-primary-100)]">
                <thead class="bg-[var(--color-primary-50)]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Hình ảnh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Tiêu đề</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Thời gian</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-[var(--color-primary-100)]" id="sortable-sliders">
                    @foreach($sliders as $slider)
                    <tr class="hover:bg-[var(--color-primary-50)]" data-id="{{ $slider->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/' . $slider->image) }}" 
                                 alt="{{ $slider->title }}" 
                                 class="h-20 w-auto object-contain">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-[var(--color-primary-900)]">{{ $slider->title }}</div>
                            <div class="text-sm text-[var(--color-primary-600)]">{{ Str::limit($slider->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $slider->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $slider->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}
                                </span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $slider->status === 'published' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $slider->status === 'published' ? 'Đã xuất bản' : 'Bản nháp' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-[var(--color-primary-600)]">
                                @if($slider->starts_at)
                                    <div>Bắt đầu: {{ $slider->starts_at->format('d/m/Y H:i') }}</div>
                                @endif
                                @if($slider->ends_at)
                                    <div>Kết thúc: {{ $slider->ends_at->format('d/m/Y H:i') }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex space-x-1 justify-end">
                                <form action="{{ route(app()->getLocale() . '.admin.sliders.toggle', $slider) }}" 
                                      method="POST" 
                                      class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center p-1.5 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] hover:bg-[var(--color-primary-200)] rounded-md transition-colors duration-200"
                                            title="{{ $slider->is_active ? 'Ẩn slider' : 'Hiển thị slider' }}">
                                        <i class="fas {{ $slider->is_active ? 'fa-eye-slash' : 'fa-eye' }} text-sm"></i>
                                    </button>
                                </form>
                                <a href="{{ route(app()->getLocale() . '.admin.sliders.edit', $slider) }}" 
                                   class="inline-flex items-center p-1.5 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] hover:bg-[var(--color-primary-200)] rounded-md transition-colors duration-200"
                                   title="Chỉnh sửa slider">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form action="{{ route(app()->getLocale() . '.admin.sliders.destroy', $slider) }}" 
                                      method="POST" 
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center p-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition-colors duration-200"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa slider này?')"
                                            title="Xóa slider">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4">
            {{ $sliders->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    new Sortable(document.getElementById('sortable-sliders'), {
        animation: 150,
        onEnd: function (evt) {
            const orders = Array.from(evt.to.children).map(tr => tr.dataset.id);
            fetch('{{ route(app()->getLocale() . ".admin.sliders.order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ orders })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Đã xảy ra lỗi khi cập nhật thứ tự');
                }
            });
        }
    });
</script>
@endpush