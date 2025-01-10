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

        return view('admin.dashboard', compact('stats'));
    }
}