<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $language = request()->segment(2); // Get language from URL (vi or zh)
        $categories = Category::with('parent')
            ->where('language', $language)
            ->latest()
            ->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $language = request()->segment(2);
        $categories = Category::where('parent_id', null)
            ->where('language', $language)
            ->get();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['language'] = request()->segment(2);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.' . $data['language'] . '.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $language = request()->segment(2);
        $categories = Category::where('parent_id', null)
            ->where('id', '!=', $category->id)
            ->where('language', $language)
            ->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['language'] = request()->segment(2);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.' . $data['language'] . '.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        $category->delete();

        $language = request()->segment(2);
        return redirect()->route('admin.' . $language . '.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
} 