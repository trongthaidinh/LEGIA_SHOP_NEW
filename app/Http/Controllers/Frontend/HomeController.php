<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Post;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Certificate;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    public function index()
    {
        $currentLocale = App::getLocale();
        
        $sliders = Slider::active()
            ->byLanguage($currentLocale)
            ->ordered()
            ->get();
        
        // Fetch products by type
        $yenChungProducts = Product::active()
            ->byLanguage($currentLocale)
            ->where('type', Product::TYPE_YEN_CHUNG)
            ->latest()
            ->take(4)
            ->get();
            
        $yenToProducts = Product::active()
            ->byLanguage($currentLocale)
            ->where('type', Product::TYPE_YEN_TO)
            ->latest()
            ->take(4)
            ->get();
            
        $giftSetProducts = Product::active()
            ->byLanguage($currentLocale)
            ->where('type', Product::TYPE_GIFT_SET)
            ->latest()
            ->take(4)
            ->get();
            
        $latestPosts = Post::published()
            ->byLanguage($currentLocale)
            ->latest()
            ->take(3)
            ->get();
            
        $testimonials = Testimonial::active()
            ->byLanguage($currentLocale)
            ->ordered()
            ->take(6)
            ->get();
            
        $certificates = Certificate::active()
            ->byLanguage($currentLocale)
            ->ordered()
            ->get();

        return view('frontend.home', compact(
            'sliders',
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
