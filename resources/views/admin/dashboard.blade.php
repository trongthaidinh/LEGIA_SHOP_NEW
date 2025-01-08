@extends('layouts.admin')

@section('title', 'Bảng điều khiển')

@section('header_title', 'Bảng điều khiển')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Bảng điều khiển</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-primary">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng lượt truy cập</p>
                    {{-- <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_visits']) }}</p> --}}
                    {{-- <p class="text-xs text-gray-500 mt-1">+{{ number_format($todayVisits) }} hôm nay</p> --}}
                </div>
                <div class="bg-primary/10 p-3 rounded-full">
                    <i class="fas fa-chart-line text-primary text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-emerald-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Người dùng</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['users']) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Tổng số người dùng</p>
                </div>
                <div class="bg-emerald-50 p-3 rounded-full">
                    <i class="fas fa-users text-emerald-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Bài viết</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['posts']) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Tổng số bài viết</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-full">
                    <i class="fas fa-newspaper text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Danh mục</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['categories']) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Tổng số danh mục</p>
                </div>
                <div class="bg-amber-50 p-3 rounded-full">
                    <i class="fas fa-folder text-amber-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Thống kê lượt truy cập</h2>
                    <div class="h-[300px]">
                        <canvas id="visitorChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Thống kê bài viết</h2>
                    <div class="h-[300px]">
                        <canvas id="postsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Hoạt động gần đây</h2>
                        <div class="bg-primary/10 p-2 rounded-full">
                            <i class="fas fa-clock text-primary"></i>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fas fa-newspaper text-blue-500"></i>
                            <h3 class="text-sm font-semibold text-gray-600">Bài viết mới</h3>
                        </div>
                        
                    </div>

                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fas fa-users text-emerald-500"></i>
                            <h3 class="text-sm font-semibold text-gray-600">Người dùng mới</h3>
                        </div>
                        <div class="space-y-3">
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

</script>
@endpush

