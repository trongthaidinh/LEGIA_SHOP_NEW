<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Post;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Certificate;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $categories = Category::active()->withCount('products')->get();
        
        // Fetch products by type
        $yenChungProducts = Product::active()
            ->where('type', Product::TYPE_YEN_CHUNG)
            ->latest()
            ->take(4)
            ->get();
            
        $yenToProducts = Product::active()
            ->where('type', Product::TYPE_YEN_TO)
            ->latest()
            ->take(4)
            ->get();
            
        $giftSetProducts = Product::active()
            ->where('type', Product::TYPE_GIFT_SET)
            ->latest()
            ->take(4)
            ->get();
            
        $latestPosts = Post::published()->latest()->take(3)->get();
        $testimonials = Testimonial::active()->ordered()->take(6)->get();
        $certificates = Certificate::active()->ordered()->get();

        return view('frontend.home', compact(
            'sliders',
            'categories',
            'yenChungProducts',
            'yenToProducts',
            'giftSetProducts',
            'latestPosts',
            'testimonials',
            'certificates'
        ));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}
