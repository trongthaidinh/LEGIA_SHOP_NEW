<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Traits\HandleUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use HandleUploadImage;

    /**
     * Folder path for storing product images
     */
    const IMAGE_FOLDER = 'products';

    /**
     * Display a listing of products.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $language = request()->segment(1);
            $query = Product::with('category')
                ->where('language', $language)
                ->latest();

            // Search functionality
            if ($search = $request->input('search')) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            }

            // Filter by category
            if ($category = $request->input('category')) {
                $query->where('category_id', $category);
            }
            // Filter by is_active
            if ($is_active = $request->input('is_active')) {
                $query->where('is_active', $is_active);
            }
            $categories = Category::where('language', $language)->get();

            $products = $query->paginate(10);

            return view('admin.products.index', compact('products', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error in ProductController@index: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching products.');
        }
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try {
            $language = request()->segment(1);
            $categories = Category::select('id', 'name')
                ->where('language', $language)
                ->orderBy('name')
                ->get();
            $types = Product::getTypes();
            
            return view('admin.products.create', compact('categories', 'types'));
        } catch (\Exception $e) {
            Log::error('Error in ProductController@create: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the create form.');
        }
    }

    /**
     * Store a newly created product in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            
            // Handle boolean fields
            $validated = array_merge($validated, [
                'slug' => $this->generateUniqueSlug($request->name, Product::class),
                'is_featured' => $request->boolean('is_featured'),
                'is_active' => true,
                'language' => request()->segment(1),
                'gallery' => $request->gallery ?? null
            ]);

            // Handle image upload
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $this->handleUploadImage(
                    $request->file('featured_image'),
                    self::IMAGE_FOLDER
                );
            }

            Product::create($validated);

            DB::commit();
            return redirect()->route($validated['language'] . '.admin.products.index')
                ->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ProductController@store: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Error creating product: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param Product $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        try {
            $language = request()->segment(1);
            $categories = Category::select('id', 'name')
                ->where('language', $language)
                ->orderBy('name')
                ->get();
            $types = Product::getTypes();
            
            return view('admin.products.edit', compact('product', 'categories', 'types'));
        } catch (\Exception $e) {
            Log::error('Error in ProductController@edit: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the edit form.');
        }
    }

    /**
     * Update the specified product in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            
            // Handle boolean fields
            $validated = array_merge($validated, [
                'slug' => $this->generateUniqueSlug($request->name, Product::class, $product->id),
                'is_featured' => $request->boolean('is_featured'),
                'language' => request()->segment(1),
                'gallery' => $request->gallery ?? $product->gallery
            ]);

            // Handle image upload
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $this->handleUploadImage(
                    $request->file('featured_image'),
                    self::IMAGE_FOLDER,
                    $product->featured_image
                );
            }

            $product->update($validated);

            DB::commit();
            return redirect()->route($validated['language'] . '.admin.products.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ProductController@update: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified product from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            // Delete product image
            if ($product->featured_image) {
                $this->deleteImage($product->featured_image);
            }
            
            $product->delete();

            DB::commit();
            $language = request()->segment(1);
            return redirect()->route($language . '.admin.products.index')
                ->with('success', 'Product deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ProductController@destroy: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the product.');
        }
    }
}
