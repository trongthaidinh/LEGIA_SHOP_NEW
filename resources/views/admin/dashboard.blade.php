@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Tổng quan -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-[var(--color-primary-600)]">Quản trị viên</h3>
                    <p class="text-2xl font-bold text-[var(--color-primary-900)]">{{ $totalStats['admins'] }}</p>
                </div>
                <div class="bg-[var(--color-primary-100)] rounded-full p-3">
                    <i class="fas fa-user-shield text-[var(--color-primary-600)] text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-[var(--color-primary-600)]">Sản phẩm</h3>
                    <p class="text-2xl font-bold text-[var(--color-primary-900)]">{{ $totalStats['products'] }}</p>
                </div>
                <div class="bg-[var(--color-primary-100)] rounded-full p-3">
                    <i class="fas fa-box text-[var(--color-primary-600)] text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-[var(--color-primary-600)]">Danh mục</h3>
                    <p class="text-2xl font-bold text-[var(--color-primary-900)]">{{ $totalStats['categories'] }}</p>
                </div>
                <div class="bg-[var(--color-primary-100)] rounded-full p-3">
                    <i class="fas fa-layer-group text-[var(--color-primary-600)] text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-[var(--color-primary-600)]">Đơn hàng</h3>
                    <p class="text-2xl font-bold text-[var(--color-primary-900)]">{{ $totalStats['orders'] }}</p>
                </div>
                <div class="bg-[var(--color-primary-100)] rounded-full p-3">
                    <i class="fas fa-shopping-cart text-[var(--color-primary-600)] text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Doanh thu theo tháng -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-[var(--color-primary-800)] mb-4">Doanh thu 6 tháng gần nhất</h3>
            <div class="h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Trạng thái đơn hàng -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-[var(--color-primary-800)] mb-4">Trạng thái đơn hàng</h3>
            <div class="h-64">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Top sản phẩm bán chạy -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-[var(--color-primary-800)] mb-4">Top sản phẩm bán chạy</h3>
            <ul class="divide-y divide-[var(--color-primary-100)]">
                @foreach($topProducts as $product)
                <li class="py-3 flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-md mr-4 object-cover">
                        <div>
                            <p class="text-sm font-medium text-[var(--color-primary-800)]">{{ $product->name }}</p>
                            <p class="text-xs text-[var(--color-primary-600)]">{{ $product->sales_count }} lượt bán</p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Danh mục sản phẩm -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-[var(--color-primary-800)] mb-4">Top danh mục</h3>
            <ul class="divide-y divide-[var(--color-primary-100)]">
                @foreach($categoryStats as $category)
                <li class="py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[var(--color-primary-800)]">{{ $category->name }}</p>
                        <p class="text-xs text-[var(--color-primary-600)]">{{ $category->products_count }} sản phẩm</p>
                    </div>
                    <span class="text-sm font-semibold text-[var(--color-primary-600)]">{{ round(($category->products_count / $totalStats['products']) * 100, 1) }}%</span>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Đơn hàng gần đây -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-[var(--color-primary-800)] mb-4">Đơn hàng mới</h3>
            <ul class="divide-y divide-[var(--color-primary-100)]">
                @foreach($recentOrders as $order)
                <li class="py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[var(--color-primary-800)]">Mã đơn: #{{ $order->id }}</p>
                        <p class="text-xs text-[var(--color-primary-600)]">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-sm font-semibold 
                        {{ $order->status == 'completed' ? 'text-[var(--color-primary-600)]' : 
                           ($order->status == 'pending' ? 'text-[var(--color-secondary-600)]' : 'text-[var(--color-secondary-800)]') }}">
                        {{ number_format($order->total_amount, 0, ',', '.') }}đ
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = 'var(--color-primary-700)';

    // Biểu đồ doanh thu
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: [
                @foreach($monthlyRevenue as $revenue)
                    "{{ $revenue->month }}/{{ $revenue->year }}",
                @endforeach
            ],
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: [
                    @foreach($monthlyRevenue as $revenue)
                        {{ $revenue->total_revenue }},
                    @endforeach
                ],
                borderColor: 'var(--color-primary-500)',
                backgroundColor: 'var(--color-primary-100)',
                tension: 0.4,
                borderWidth: 3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('vi-VN', { 
                                style: 'currency', 
                                currency: 'VND' 
                            }).format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', { 
                                style: 'currency', 
                                currency: 'VND' 
                            }).format(value);
                        }
                    }
                }
            }
        }
    });

    // Biểu đồ trạng thái đơn hàng
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(orderStatusCtx, {
        type: 'pie',
        data: {
            labels: [
                @foreach($orderStatus as $status)
                    "{{ $status->status }}",
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($orderStatus as $status)
                        {{ $status->count }},
                    @endforeach
                ],
                backgroundColor: [
                    '#22c55e',    // Success/Green for completed orders
                    '#f59e0b',    // Warning/Orange for pending orders
                    '#ef4444'     // Danger/Red for cancelled/failed orders
                ],
                borderColor: [
                    '#16a34a',    // Darker green
                    '#d97706',    // Darker orange
                    '#dc2626'     // Darker red
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                },
                datalabels: {
                    color: 'white',
                    formatter: function(value, context) {
                        let total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        let percentage = Math.round((value/total) * 100);
                        return percentage + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
});
</script>
@endpush
@endsection
