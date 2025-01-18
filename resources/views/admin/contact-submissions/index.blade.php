@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-envelope mr-2"></i> Liên hệ
                </h3>
                
                <!-- Status Filter -->
                <div class="flex items-center space-x-4">
                    <form action="{{ route(app()->getLocale() . '.admin.contact-submissions.index') }}" method="GET" class="flex items-center space-x-4">
                        <label for="status" class="text-sm font-medium text-white">Trạng thái:</label>
                        <select name="status" id="status" 
                                class="rounded-md border-[var(--color-primary-300)] shadow-sm focus:border-[var(--color-primary-500)] focus:ring focus:ring-[var(--color-primary-200)] bg-white text-[var(--color-primary-900)]" 
                                onchange="this.form.submit()">
                            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Tất cả</option>
                            <option value="new" {{ $status === 'new' ? 'selected' : '' }}>Mới</option>
                            <option value="read" {{ $status === 'read' ? 'selected' : '' }}>Đã đọc</option>
                            <option value="replied" {{ $status === 'replied' ? 'selected' : '' }}>Đã trả lời</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div>
            <!-- Contact Submissions List -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[var(--color-primary-100)]">
                    <thead class="bg-[var(--color-primary-50)]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Tên</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Nội dung</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Ngày</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[var(--color-primary-100)]">
                        @forelse($submissions as $submission)
                            <tr class="hover:bg-[var(--color-primary-50)] transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-[var(--color-primary-900)]">{{ $submission->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-[var(--color-primary-700)]">{{ $submission->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-[var(--color-primary-700)] line-clamp-2">{{ $submission->message }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $submission->status === 'new' ? 'bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)]' : '' }}
                                        {{ $submission->status === 'read' ? 'bg-[var(--color-primary-100)] text-[var(--color-primary-700)]' : '' }}
                                        {{ $submission->status === 'replied' ? 'bg-[var(--color-primary-100)] text-[var(--color-primary-700)]' : '' }}">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--color-primary-600)]">
                                    {{ $submission->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route(app()->getLocale() . '.admin.contact-submissions.show', $submission) }}" 
                                           class="inline-flex items-center p-1.5 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] hover:bg-[var(--color-primary-200)] rounded-md transition-colors duration-200">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($submission->status !== 'replied')
                                            <form action="{{ route(app()->getLocale() . '.admin.contact-submissions.mark-replied', $submission) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="inline-flex items-center p-1.5 bg-[var(--color-primary-100)] text-[var(--color-primary-700)] hover:bg-[var(--color-primary-200)] rounded-md transition-colors duration-200" 
                                                        title="{{ __('Mark as Replied') }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route(app()->getLocale() . '.admin.contact-submissions.destroy', $submission) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center p-1.5 bg-[var(--color-secondary-100)] text-[var(--color-secondary-700)] hover:bg-[var(--color-secondary-200)] rounded-md transition-colors duration-200" 
                                                    onclick="return confirm('{{ __('Are you sure you want to delete this submission?') }}')" 
                                                    title="{{ __('Delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-[var(--color-primary-500)]">
                                    {{ __('Không có lời nhắn liên hệ nào.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($submissions->hasPages())
            <div class="px-6 py-4 border-t border-[var(--color-primary-100)]">
                {{ $submissions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection