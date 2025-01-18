@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Bình luận</h1>
        
    </div>

   

    <!-- Testimonials List -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nội dung</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đánh giá</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($testimonials as $testimonial)
                    <tr data-testimonial-id="{{ $testimonial->id }}">
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
                                <button type="button" onclick="showTestimonialDetails('{{ $testimonial->id }}')" class="text-primary-600 hover:text-primary-900">
                                    <i class="fas fa-eye"></i>
                                </button>
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

<!-- Testimonial Details Modal -->
<div id="testimonialModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full" style="z-index: 100;">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Testimonial Details') }}</h3>
            <button onclick="closeTestimonialModal()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="testimonialDetails" class="space-y-4">
            <div class="flex items-center">
                <img id="modalCustomerAvatar" class="h-16 w-16 rounded-full object-cover" alt="">
                <div class="ml-4">
                    <div id="modalCustomerName" class="font-medium text-gray-900"></div>
                    <div id="modalCustomerPosition" class="text-sm text-gray-500"></div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('Content') }}</label>
                <p id="modalContent" class="mt-1 text-sm text-gray-900"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('Rating') }}</label>
                <div id="modalRating" class="flex items-center text-yellow-400 mt-1"></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
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
    const customerPosition = row.querySelector('.text-sm.text-gray-500')?.textContent || '';
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
</script>
@endpush 