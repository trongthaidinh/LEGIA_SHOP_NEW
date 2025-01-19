@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-comment mr-2"></i> Bình luận
                </h3>
               
                <div class="flex space-x-2">
                    <a href="{{ route(app()->getLocale() . '.admin.testimonials.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                        Tất cả 
                        <span class="ml-2 px-2 py-0.5 text-xs bg-[var(--color-primary-100)] text-[var(--color-primary-700)] rounded-full">
                            {{ $testimonials->total() }}
                        </span>
                    </a>
                    <button type="button" id="filterPublished"
                            class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                        Đã xuất bản 
                        <span class="ml-2 px-2 py-0.5 text-xs bg-[var(--color-primary-100)] text-[var(--color-primary-700)] rounded-full">
                            {{ $testimonials->where('status', 'published')->count() }}
                        </span>
                    </button>
                    <button type="button" id="filterDraft"
                            class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors duration-200">
                        Nháp 
                        <span class="ml-2 px-2 py-0.5 text-xs bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)] rounded-full">
                            {{ $testimonials->where('status', 'draft')->count() }}
                        </span>
                    </button>
                    <!--add button -->
                    <a href="{{ route(app()->getLocale() . '.admin.testimonials.create') }}" class="bg-[var(--color-primary-500)] text-[var(--color-primary-100)] font-medium py-2 px-4 rounded-lg inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i> Thêm bình luận
                    </a>

                </div>
            </div>
        </div>

        <div>
            @if(session('success'))
                <div class="mb-4 bg-[var(--color-primary-50)] text-[var(--color-primary-700)] p-4 rounded-md flex items-center justify-between" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-[var(--color-primary-500)]"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="text-[var(--color-primary-600)] hover:text-[var(--color-primary-800)]" data-dismiss="alert">
                        <span class="text-2xl">&times;</span>
                    </button>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[var(--color-primary-100)]">
                    <thead class="bg-[var(--color-primary-50)]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Khách hàng</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Nội dung</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Đánh giá</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[var(--color-primary-100)]">
                        @forelse($testimonials as $testimonial)
                            <tr data-testimonial-id="{{ $testimonial->id }}" class="hover:bg-[var(--color-primary-50)] transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($testimonial->customer_avatar)
                                            <img src="{{ Storage::url($testimonial->customer_avatar) }}" alt="{{ $testimonial->customer_name }}" class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-[var(--color-primary-100)] flex items-center justify-center">
                                                <i class="fas fa-user text-[var(--color-primary-500)]"></i>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-[var(--color-primary-900)]">{{ $testimonial->customer_name }}</div>
                                            @if($testimonial->customer_position)
                                                <div class="text-sm text-[var(--color-primary-500)]">{{ $testimonial->customer_position }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-[var(--color-primary-900)] line-clamp-2">{{ $testimonial->content }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $testimonial->status === 'published' ? 'bg-[var(--color-primary-100)] text-[var(--color-primary-700)]' : 'bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)]' }}">
                                        {{ ucfirst($testimonial->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-3">
                                        <button type="button" onclick="showTestimonialDetails('{{ $testimonial->id }}')" 
                                                class="inline-flex items-center p-1.5 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] hover:bg-[var(--color-primary-200)] rounded-md transition-colors duration-200">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <!--edit button-->
                                        <a href="{{ route(app()->getLocale() . '.admin.testimonials.edit', $testimonial) }}" class="inline-flex items-center p-1.5 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] hover:bg-[var(--color-primary-200)] rounded-md transition-colors duration-200">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route(app()->getLocale() . '.admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center p-1.5 bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)] hover:bg-[var(--color-secondary-200)] rounded-md transition-colors duration-200" 
                                                    onclick="return confirm('{{ __('Are you sure you want to delete this testimonial?') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-[var(--color-primary-500)]">
                                    {{ __('No testimonials found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($testimonials->hasPages())
            <div class="px-6 py-4 border-t border-[var(--color-primary-100)]">
                {{ $testimonials->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Testimonial Details Modal -->
<div id="testimonialModal" class="fixed inset-0 bg-[var(--color-primary-900)] bg-opacity-50 hidden overflow-y-auto h-full w-full" style="z-index: 100;">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-[var(--color-primary-900)]">{{ __('Testimonial Details') }}</h3>
            <button onclick="closeTestimonialModal()" class="text-[var(--color-primary-400)] hover:text-[var(--color-primary-600)]">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="testimonialDetails" class="space-y-4">
            <div class="flex items-center">
                <img id="modalCustomerAvatar" class="h-16 w-16 rounded-full object-cover" alt="">
                <div class="ml-4">
                    <div id="modalCustomerName" class="font-medium text-[var(--color-primary-900)]"></div>
                    <div id="modalCustomerPosition" class="text-sm text-[var(--color-primary-500)]"></div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Content') }}</label>
                <p id="modalContent" class="mt-1 text-sm text-[var(--color-primary-900)]"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Rating') }}</label>
                <div id="modalRating" class="flex items-center text-yellow-400 mt-1"></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-[var(--color-primary-700)]">{{ __('Status') }}</label>
                <span id="modalStatus" class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full"></span>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showTestimonialDetails(testimonialId) {
    // Find the testimonial data from the table
    const row = document.querySelector(`tr[data-testimonial-id="${testimonialId}"]`);
    const customerName = row.querySelector('.text-sm.font-medium').textContent;
    const customerPosition = row.querySelector('.text-sm.text-[var(--color-primary-500)]')?.textContent || '';
    const content = row.querySelector('td:nth-child(2) .text-sm').textContent;
    const rating = row.querySelector('td:nth-child(3) .flex').innerHTML;
    const status = row.querySelector('td:nth-child(4) span').textContent;
    const statusClass = row.querySelector('td:nth-child(4) span').className;
    const avatarSrc = row.querySelector('img')?.src || '';

    // Update modal content
    document.getElementById('modalCustomerName').textContent = customerName;
    document.getElementById('modalCustomerPosition').textContent = customerPosition;
    document.getElementById('modalContent').textContent = content;
    document.getElementById('modalRating').innerHTML = rating;
    document.getElementById('modalStatus').textContent = status;
    document.getElementById('modalStatus').className = statusClass;
    
    const avatarImg = document.getElementById('modalCustomerAvatar');
    if (avatarSrc) {
        avatarImg.src = avatarSrc;
        avatarImg.style.display = 'block';
    } else {
        avatarImg.style.display = 'none';
    }

    // Show modal
    document.getElementById('testimonialModal').classList.remove('hidden');
}

function closeTestimonialModal() {
    document.getElementById('testimonialModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('testimonialModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTestimonialModal();
    }
});

// Filtering logic
document.getElementById('filterPublished').addEventListener('click', function() {
    window.location.href = "{{ route(app()->getLocale() . '.admin.testimonials.index') }}?status=published";
});

document.getElementById('filterDraft').addEventListener('click', function() {
    window.location.href = "{{ route(app()->getLocale() . '.admin.testimonials.index') }}?status=draft";
});
</script>
@endpush