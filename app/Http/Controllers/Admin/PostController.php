<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = PostCategory::where('is_active', true)->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'post_category_id' => 'required|exists:post_categories,id',
            'content' => 'required',
            'excerpt' => 'nullable',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        }

        $validated['admin_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        Post::create($validated);

        return redirect()->route(app()->getLocale() . '.admin.posts.index')
            ->with('success', __('Post created successfully'));
    }

    public function edit(Post $post)
    {
        $categories = PostCategory::where('is_active', true)->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'post_category_id' => 'required|exists:post_categories,id',
            'content' => 'required',
            'excerpt' => 'nullable',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        }

        $validated['slug'] = Str::slug($validated['title']);
        $post->update($validated);

        return redirect()->route(app()->getLocale() . '.admin.posts.index')
            ->with('success', __('Post updated successfully'));
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        $post->delete();

        return redirect()->route(app()->getLocale() . '.admin.posts.index')
            ->with('success', __('Post deleted successfully'));
    }
}