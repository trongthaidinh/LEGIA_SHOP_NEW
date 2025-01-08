<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Thống kê cơ bản
        $stats = [
            'users' => Admin::count(),
            'posts' => Post::count(),
            'categories' => Category::count(),
        ];

        // Lượt truy cập hôm nay
        // $todayVisits = visits('App\Models\Post')->period('day')->count();

        // // Dữ liệu cho biểu đồ lượt truy cập
        // $visitData = collect(range(6, 0))->map(function($day) {
        //     $date = Carbon::now()->subDays($day);
        //     return [
        //         'date' => $date->format('d/m'),
        //         'visits' => visits('App\Models\Post')->period('day', $date)->count()
        //     ];
        // });

        // $chartData = [
        //     'labels' => $visitData->pluck('date'),
        //     'visits' => $visitData->pluck('visits'),
        // ];

        // // Dữ liệu cho biểu đồ bài viết
        // $postsData = collect(range(6, 0))->map(function($day) {
        //     $date = Carbon::now()->subDays($day);
        //     return [
        //         'date' => $date->format('d/m'),
        //         'posts' => Post::whereDate('created_at', $date)->count()
        //     ];
        // });

        // $postsChartData = [
        //     'labels' => $postsData->pluck('date'),
        //     'posts' => $postsData->pluck('posts'),
        // ];

        // // Bài viết gần đây
        // $recentPosts = Post::with('category')
        //     ->latest()
        //     ->take(5)
        //     ->get();

        // // Người dùng mới
        // $recentUsers = User::latest()
        //     ->take(5)
        //     ->get();

        return view('admin.dashboard', compact('stats'));
    }
}