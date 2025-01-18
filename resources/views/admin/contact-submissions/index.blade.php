@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Liên hệ</h1>
        
        <!-- Status Filter -->
        <div class="flex items-center space-x-4">
            <form action="{{ route(app()->getLocale() . '.admin.contact-submissions.index') }}" method="GET" class="flex items-center space-x-4">
                <label for="status" class="text-sm font-medium text-gray-700">Trạng thái:</label>
                <select name="status" id="status" class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200" onchange="this.form.submit()">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Tất cả</option>
                    <option value="new" {{ $status === 'new' ? 'selected' : '' }}>Mới</option>
                    <option value="read" {{ $status === 'read' ? 'selected' : '' }}>Đã đọc</option>
                    <option value="replied" {{ $status === 'replied' ? 'selected' : '' }}>Đã trả lời</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Contact Submissions List -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nội dung</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($submissions as $submission)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $submission->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $submission->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 line-clamp-2">{{ $submission->message }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $submission->status === 'new' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $submission->status === 'read' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $submission->status === 'replied' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ ucfirst($submission->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $submission->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route(app()->getLocale() . '.admin.contact-submissions.show', $submission) }}" class="text-primary-600 hover:text-primary-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($submission->status !== 'replied')
                                    <form action="{{ route(app()->getLocale() . '.admin.contact-submissions.mark-replied', $submission) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-900" title="{{ __('Mark as Replied') }}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route(app()->getLocale() . '.admin.contact-submissions.destroy', $submission) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure you want to delete this submission?') }}')" title="{{ __('Delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            {{ __('No contact submissions found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $submissions->links() }}
    </div>
</div>
@endsection 