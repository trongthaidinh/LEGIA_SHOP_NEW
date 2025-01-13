<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Extensive logging for debugging
        \Log::info('Product Filter Request', [
            'full_request' => $request->all(),
            'categories' => $request->input('categories'),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'sort' => $request->input('sort'),
            'type' => $request->input('type'),
            'current_locale' => app()->getLocale()
        ]);

        // Start with a base query
        $query = Product::query()
            ->where('is_active', true)
            ->where('status', 'published')
            ->where('language', app()->getLocale())
            ->with('categories');

        // Handle product type filtering
        $type = $request->input('type');
        $typeMap = [
            'yen-to' => Product::TYPE_YEN_TO,
            'yen-chung' => Product::TYPE_YEN_CHUNG,
            'gift-set' => Product::TYPE_GIFT_SET
        ];

        if ($type && isset($typeMap[$type]) && $request->route()->getName() === app()->getLocale() . '.products.type') {
            $query->where('type', $typeMap[$type]);
        }

        // Detailed category filtering
        $categoryParam = $request->input('categories');
        $categoryIds = is_string($categoryParam) 
            ? array_map('intval', explode(',', $categoryParam)) 
            : [];

        // Debugging category filtering
        \Log::info('Category Filtering Debug', [
            'category_ids' => $categoryIds,
            'category_param' => $categoryParam
        ]);

        if (!empty($categoryIds)) {
            $query->whereHas('categories', function($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }

        // Precise price filtering
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Ensure price is converted to numeric and handle empty strings
        $minPrice = $minPrice !== null && $minPrice !== '' 
            ? (float)str_replace(',', '', $minPrice) 
            : null;
        $maxPrice = $maxPrice !== null && $maxPrice !== '' 
            ? (float)str_replace(',', '', $maxPrice) 
            : null;

        // Apply price filtering
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        // Detailed price filtering logging
        \Log::info('Price Filtering Debug', [
            'min_price_raw' => $request->input('min_price'),
            'max_price_raw' => $request->input('max_price'),
            'min_price_parsed' => $minPrice,
            'max_price_parsed' => $maxPrice
        ]);

        // Sorting
        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
        }

        // Extensive debugging output
        $debugInfo = [
            'total_products_before_filter' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'published_products' => Product::where('status', 'published')->count(),
            'language_products' => Product::where('language', app()->getLocale())->count(),
            'filter_categories' => $categoryIds,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'sql_query' => $query->toSql(),
            'sql_bindings' => $query->getBindings(),
        ];

        // Execute query and get results
        $products = $query->paginate(12)->withQueryString();

        // Add more debug info
        $debugInfo['total_filtered_products'] = $products->total();
        $debugInfo['current_page_products'] = $products->count();
        $debugInfo['filtered_product_prices'] = $products->pluck('price');

        // Debugging categories
        $categories = Category::active()
            ->where('language', app()->getLocale())
            ->withCount('products')
            ->get();
        
        $debugInfo['categories'] = $categories->map(function($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'products_count' => $category->products_count
            ];
        });

        // Debugging price range
        $priceRange = Product::active()
            ->where('language', app()->getLocale())
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();
        $debugInfo['price_range'] = $priceRange;

        // Log debugging information
        \Log::info('Product Filter Debug', $debugInfo);

        return view('frontend.products.index', compact('products', 'categories', 'priceRange'));
    }

    public function show($slug)
    {
        $product = Product::active()
            ->byLanguage(app()->getLocale())
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->byLanguage(app()->getLocale())
            ->whereHas('categories', function($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $reviews = ProductReview::where('product_id', $product->id)
            ->where('is_approved', true)
            ->latest()
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts', 'reviews'));
    }

    public function search(Request $request)
    {
        $query = Product::active()->byLanguage(app()->getLocale());

        if ($request->q) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        $products = $query->paginate(12);

        return view('frontend.products.search', compact('products'));
    }

    public function review(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $request->validate([
            'reviewer_name' => 'required|max:255',
            'reviewer_email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required'
        ]);

        ProductReview::create([
            'product_id' => $product->id,
            'reviewer_name' => $request->reviewer_name,
            'reviewer_email' => $request->reviewer_email,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', __('review_submitted'));
    }

    public function productsByType($type)
    {
        // Map URL type với type trong database
        $typeMap = [
            'yen-to' => Product::TYPE_YEN_TO,
            'yen-chung' => Product::TYPE_YEN_CHUNG,
            'gift-set' => Product::TYPE_GIFT_SET
        ];

        $dbType = $typeMap[$type] ?? null;
        
        if (!$dbType) {
            abort(404);
        }

        // Redirect to main products route with type parameter
        return redirect()->route(app()->getLocale() . '.products', 
            array_merge(request()->query(), ['type' => $type]));
    }
}
