<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Path for storing product images
     */
    const IMAGE_PATH = 'image/product';

    /**
     * Display a listing of products.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $query = Product::with('category')->latest();

            // Search functionality
            if ($search = $request->input('search')) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            }

            // Filter by type
            if ($type = $request->input('type')) {
                $query->where('type', $type);
            }

            // Filter by status
            if ($status = $request->input('status')) {
                $query->where('status', $status);
            }

            $products = $query->paginate(10);

            return view('admin.products.index', compact('products'));
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
            $categories = Category::select('id', 'name')->orderBy('name')->get();
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $this->validateProduct($request);
            
            // Handle boolean fields
            $validated = array_merge($validated, [
                'slug' => $this->generateUniqueSlug($request->name),
                'is_featured' => $request->boolean('is_featured'),
                'is_active' => true
            ]);

            // Handle image upload
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $this->handleImageUpload(
                    $request->file('featured_image'),
                    $validated['slug']
                );
            }

            Product::create($validated);

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ProductController@store: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An error occurred while creating the product: ' . $e->getMessage());
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
            $categories = Category::select('id', 'name')->orderBy('name')->get();
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
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();

            $validated = $this->validateProduct($request, $product->id);
            
            // Handle boolean fields
            $validated = array_merge($validated, [
                'slug' => $this->generateUniqueSlug($request->name, $product->id),
                'is_featured' => $request->boolean('is_featured')
            ]);

            // Handle image upload
            if ($request->hasFile('featured_image')) {
                // Delete old image
                $this->deleteImage($product->featured_image);
                
                // Upload new image
                $validated['featured_image'] = $this->handleImageUpload(
                    $request->file('featured_image'),
                    $validated['slug']
                );
            }

            $product->update($validated);

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ProductController@update: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An error occurred while updating the product: ' . $e->getMessage());
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
            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ProductController@destroy: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the product.');
        }
    }

    /**
     * Validate product data.
     *
     * @param Request $request
     * @param int|null $productId
     * @return array
     */
    private function validateProduct(Request $request, ?int $productId = null): array
    {
        $rules = [
            'name' => 'required|max:255',
            'type' => 'required|in:' . implode(',', array_keys(Product::getTypes())),
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'content' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $value >= $request->input('price')) {
                        $fail('The sale price must be less than the regular price.');
                    }
                },
            ],
            'stock' => 'required|integer|min:0',
            'sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products')->ignore($productId),
            ],
            'featured_image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'status' => 'required|in:draft,published'
        ];

        return $request->validate($rules);
    }

    /**
     * Generate unique slug for product.
     *
     * @param string $name
     * @param int|null $excludeId
     * @return string
     */
    private function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $count = 1;

        $query = Product::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = Str::slug($name) . '-' . $count++;
            $query = Product::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    /**
     * Handle image upload.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $slug
     * @return string
     */
    private function handleImageUpload($image, string $slug): string
    {
        // Create a unique filename using the slug and timestamp
        $filename = $slug . '-' . time() . '.' . $image->getClientOriginalExtension();
        
        // Store the image in the specified path
        $path = $image->storeAs(self::IMAGE_PATH, $filename, 'public');
        
        return $path;
    }

    /**
     * Delete image from storage.
     *
     * @param string|null $path
     * @return void
     */
    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
