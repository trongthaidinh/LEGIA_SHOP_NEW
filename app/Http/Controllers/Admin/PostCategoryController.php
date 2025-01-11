<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::latest()
            ->paginate(10);

        return view('admin.post-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.post-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        PostCategory::create($validated);

        return redirect()->route(request()->segment(1) . '.admin.post-categories.index')
            ->with('success', __('Post category created successfully.'));
    }

    public function edit(PostCategory $postCategory)
    {
        return view('admin.post-categories.edit', compact('postCategory'));
    }

    public function update(Request $request, PostCategory $postCategory)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $postCategory->update($validated);

        return redirect()->route(request()->segment(1) . '.admin.post-categories.index')
            ->with('success', __('Post category updated successfully.'));
    }

    public function destroy(Request $request, PostCategory $postCategory)
    {
        if ($postCategory->posts()->count() > 0) {
            return redirect()->route(request()->segment(1) . '.admin.post-categories.index')
                ->with('error', __('Cannot delete category with associated posts.'));
        }

        $postCategory->delete();

        return redirect()->route(request()->segment(1) . '.admin.post-categories.index')
            ->with('success', __('Post category deleted successfully.'));
    }
} 