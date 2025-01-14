<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use App\Traits\HandleUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostCategoryController extends Controller
{
    use HandleUploadImage;

    /**
     * Folder path for storing post category images
     */
    const IMAGE_FOLDER = 'post-categories';

    public function index()
    {
        try {
            $language = request()->segment(1);
            $categories = PostCategory::where('language', $language)
                ->latest()
                ->paginate(10);

            return view('admin.post-categories.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error in PostCategoryController@index: ' . $e->getMessage());
            return back()->with('error', __('Error loading categories.'));
        }
    }

    public function create()
    {
        try {
            $language = request()->segment(1);
            $categories = PostCategory::where('language', $language)
                ->where('parent_id', null)
                ->orWhere('parent_id', 0)
                ->get();

            return view('admin.post-categories.create', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error in PostCategoryController@create: ' . $e->getMessage());
            return back()->with('error', __('Error loading parent categories.'));
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|max:255',
                'description' => 'nullable',
                'is_active' => 'boolean',
                'featured_image' => 'nullable|image|max:2048',
            ]);

            $validated['slug'] = $this->generateUniqueSlug($validated['name'], PostCategory::class);
            $validated['is_active'] = $request->has('is_active');
            $validated['language'] = request()->segment(1);

            // Handle image upload
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $this->handleUploadImage(
                    $request->file('featured_image'),
                    self::IMAGE_FOLDER
                );
            }

            PostCategory::create($validated);

            DB::commit();
            return redirect()->route(request()->segment(1) . '.admin.post-categories.index')
                ->with('success', __('Post category created successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in PostCategoryController@store: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', __('Error creating category: ') . $e->getMessage());
        }
    }

    public function edit(PostCategory $postCategory)
    {
        try {
            if ($postCategory->language !== request()->segment(1)) {
                return redirect()->route(request()->segment(1) . '.admin.post-categories.index')
                    ->with('error', __('Category not found in this language.'));
            }

            return view('admin.post-categories.edit', compact('postCategory'));
        } catch (\Exception $e) {
            Log::error('Error in PostCategoryController@edit: ' . $e->getMessage());
            return back()->with('error', __('Error loading category.'));
        }
    }

    public function update(Request $request, PostCategory $postCategory)
    {
        try {
            if ($postCategory->language !== request()->segment(1)) {
                return redirect()->route(request()->segment(1) . '.admin.post-categories.index')
                    ->with('error', __('Category not found in this language.'));
            }

            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|max:255',
                'description' => 'nullable',
                'is_active' => 'boolean',
                'featured_image' => 'nullable|image|max:2048',
            ]);

            $validated['slug'] = $this->generateUniqueSlug($validated['name'], PostCategory::class, $postCategory->id);
            $validated['is_active'] = $request->has('is_active');
            $validated['language'] = request()->segment(1);

            // Handle image upload
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $this->handleUploadImage(
                    $request->file('featured_image'),
                    self::IMAGE_FOLDER,
                    $postCategory->featured_image
                );
            }

            $postCategory->update($validated);

            DB::commit();
            return redirect()->route(request()->segment(1) . '.admin.post-categories.index')
                ->with('success', __('Post category updated successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in PostCategoryController@update: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', __('Error updating category: ') . $e->getMessage());
        }
    }

    public function destroy(PostCategory $postCategory)
    {
        try {
            if ($postCategory->language !== request()->segment(1)) {
                return redirect()->route(request()->segment(1) . '.admin.post-categories.index')
                    ->with('error', __('Category not found in this language.'));
            }

            DB::beginTransaction();

            if ($postCategory->posts()->count() > 0) {
                throw new \Exception(__('Cannot delete category with associated posts.'));
            }

            // Delete category image
            if ($postCategory->featured_image) {
                $this->deleteImage($postCategory->featured_image);
            }

            $postCategory->delete();

            DB::commit();
            return redirect()->route(request()->segment(1) . '.admin.post-categories.index')
                ->with('success', __('Post category deleted successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in PostCategoryController@destroy: ' . $e->getMessage());
            return back()->with('error', __('Error deleting category: ') . $e->getMessage());
        }
    }
} 