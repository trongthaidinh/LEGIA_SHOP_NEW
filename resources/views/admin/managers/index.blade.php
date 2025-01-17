@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-[var(--color-primary-500)] px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-users-cog mr-2"></i> Quản lý tài khoản quản trị
                </h3>
                <div>
                    <a href="{{ route(app()->getLocale() . '.admin.managers.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-[var(--color-primary-700)] hover:bg-[var(--color-primary-50)] rounded-md">
                        <i class="fas fa-plus mr-2"></i> Thêm quản trị viên
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Tên</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Vai trò</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-[var(--color-primary-600)] uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-[var(--color-primary-100)]">
                    @foreach($managers as $manager)
                    <tr class="hover:bg-[var(--color-primary-50)]">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-[var(--color-primary-900)]">{{ $manager->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-[var(--color-primary-600)]">{{ $manager->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($manager->is_super_admin)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Super Admin
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Quản trị viên
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route(app()->getLocale() . '.admin.managers.edit', $manager) }}" 
                               class="text-[var(--color-primary-600)] hover:text-[var(--color-primary-900)] mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(!$manager->is_super_admin)
                            <form action="{{ route(app()->getLocale() . '.admin.managers.destroy', $manager) }}" 
                                  method="POST" 
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa quản trị viên này?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4">
            {{ $managers->links() }}
        </div>
    </div>
</div>
@endsection 