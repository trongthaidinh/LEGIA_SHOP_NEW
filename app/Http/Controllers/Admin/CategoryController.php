<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Traits\HandleUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    use HandleUploadImage;

    /**
     * Folder path for storing category images
     */
    const IMAGE_FOLDER = 'categories';

    /**
     * Display a listing of categories.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $language = request()->segment(1);
            $query = Category::with('parent')
                ->withCount('products')
                ->where('language', $language)
                ->latest();

            // Search functionality
            if ($search = $request->input('search')) {
                $query->where('name', 'like', "%{$search}%");
            }

            // Filter by status
            if ($status = $request->input('status')) {
                $query->where('status', $status);
            }

            $categories = $query->paginate(10);

            return view('admin.categories.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error in CategoryController@index: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching categories.');
        }
    }

    /**
     * Show the form for creating a new category.
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
            
            return view('admin.categories.create', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error in CategoryController@create: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the create form.');
        }
    }

    /**
     * Store a newly created category in storage.
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            
            // Handle boolean fields
            $validated = array_merge($validated, [
                'slug' => $this->generateUniqueSlug($request->name, Category::class),
                'is_featured' => $request->boolean('is_featured'),
                'is_active' => true,
                'language' => request()->segment(1)
            ]);

            // Handle image upload
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $this->handleUploadImage(
                    $request->file('featured_image'),
                    self::IMAGE_FOLDER
                );
            }

            Category::create($validated);
            
            DB::commit();
            return redirect()->route($validated['language'] . '.admin.categories.index')
                ->with('success', 'Category created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in CategoryController@store: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An error occurred while creating the category: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param Category $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        try {
            $language = request()->segment(1);
            $categories = Category::select('id', 'name')
                ->where('language', $language)
                ->where('id', '!=', $category->id)
                ->orderBy('name')
                ->get();
            
            return view('admin.categories.edit', compact('category', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error in CategoryController@edit: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the edit form.');
        }
    }

    /**
     * Update the specified category in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            
            // Handle boolean fields
            $validated = array_merge($validated, [
                'slug' => $this->generateUniqueSlug($request->name, Category::class, $category->id),
                'is_featured' => $request->boolean('is_featured'),
                'language' => request()->segment(1)
            ]);

            // Handle image upload
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $this->handleUploadImage(
                    $request->file('featured_image'),
                    self::IMAGE_FOLDER,
                    $category->featured_image
                );
            }

            $category->update($validated);

            DB::commit();
            return redirect()->route($validated['language'] . '.admin.categories.index')
                ->with('success', 'Category updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in CategoryController@update: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An error occurred while updating the category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        try {
            DB::beginTransaction();

            // Check if category has children
            if ($category->children()->exists()) {
                throw new \Exception('Cannot delete category with sub-categories.');
            }

            // Check if category has products
            if ($category->products()->exists()) {
                throw new \Exception('Cannot delete category with products.');
            }

            // Delete category image
            if ($category->featured_image) {
                $this->deleteImage($category->featured_image);
            }
            
            $category->delete();

            DB::commit();
            $language = request()->segment(1);
            return redirect()->route($language . '.admin.categories.index')
                ->with('success', 'Category deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in CategoryController@destroy: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the category: ' . $e->getMessage());
        }
    }
} 