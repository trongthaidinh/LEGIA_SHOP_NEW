<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable',
            'content' => 'nullable',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|unique:products,sku',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable',
            'content' => 'nullable',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($product->featured_image) {
                Storage::disk('public')->delete($product->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->featured_image) {
            Storage::disk('public')->delete($product->featured_image);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
