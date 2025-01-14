<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $totalStats = [
            'admins' => Admin::count(),
            'products' => Product::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
        ];

        // Doanh thu theo tháng (6 tháng gần nhất)
        $monthlyRevenue = Order::where('status', 'completed')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();

        // Top sản phẩm bán chạy
        $topProducts = Product::select('products.*')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->select('products.*', DB::raw('COUNT(order_items.id) as sales_count'))
            ->groupBy('products.id')
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();

        // Trạng thái đơn hàng
        $orderStatus = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Danh mục sản phẩm
        $categoryStats = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit(5)
            ->get();

        // Đơn hàng gần đây
        $recentOrders = Order::latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStats', 
            'monthlyRevenue', 
            'topProducts', 
            'orderStatus', 
            'categoryStats', 
            'recentOrders'
        ));
    }
}