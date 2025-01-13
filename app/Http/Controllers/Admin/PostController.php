<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;

class PostController extends Controller
{
    public function index()
    {
        try {
            $posts = Post::with('category')
                ->where('language', request()->segment(1))
                ->latest()
                ->paginate(10);
            $categories = PostCategory::where('is_active', true)->get();
            return view('admin.posts.index', compact('posts', 'categories'));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', __('Error loading posts: ') . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $categories = PostCategory::where('is_active', true)->get();
            return view('admin.posts.create', compact('categories'));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', __('Error loading categories: ') . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'post_category_id' => 'required|exists:post_categories,id',
                'content' => 'required',
                'excerpt' => 'nullable',
                'featured_image' => 'nullable|image|max:2048',
                'status' => 'required|in:draft,published',
                'is_featured' => 'boolean',
                'published_at' => 'nullable|date',
            ]);

            if ($request->hasFile('featured_image')) {
                try {
                    $path = $request->file('featured_image')->store('images/posts', 'public');
                    $validated['featured_image'] = $path;
                } catch (Exception $e) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', __('Error uploading image: ') . $e->getMessage());
                }
            }

            $validated['admin_id'] = auth()->user()->id;
            $validated['slug'] = Str::slug($validated['title']);
            $validated['language'] = request()->segment(1);
            $validated['is_featured'] = $request->has('is_featured');

            Post::create($validated);

            return redirect()->route(request()->segment(1) . '.admin.posts.index')
                ->with('success', __('Post created successfully'));
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('Error creating post: ') . $e->getMessage());
        }
    }

    public function edit(Post $post)
    {
        try {
            if ($post->language !== request()->segment(1)) {
                return redirect()->route(request()->segment(1) . '.admin.posts.index')
                    ->with('error', __('Post not found in this language.'));
            }

            $categories = PostCategory::where('is_active', true)->get();
            return view('admin.posts.edit', compact('post', 'categories'));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', __('Error loading post: ') . $e->getMessage());
        }
    }

    public function update(Request $request, Post $post)
    {
        try {
            if ($post->language !== request()->segment(1)) {
                return redirect()->route(request()->segment(1) . '.admin.posts.index')
                    ->with('error', __('Post not found in this language.'));
            }

            $validated = $request->validate([
                'title' => 'required|max:255',
                'post_category_id' => 'required|exists:post_categories,id',
                'content' => 'required',
                'excerpt' => 'nullable',
                'featured_image' => 'nullable|image|max:2048',
                'status' => 'required|in:draft,published',
                'is_featured' => 'boolean',
                'published_at' => 'nullable|date',
            ]);

            if ($request->hasFile('featured_image')) {
                try {
                    if ($post->featured_image) {
                        Storage::disk('public')->delete($post->featured_image);
                    }
                    $path = $request->file('featured_image')->store('images/posts', 'public');
                    $validated['featured_image'] = $path;
                } catch (Exception $e) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', __('Error uploading image: ') . $e->getMessage());
                }
            }

            $validated['slug'] = Str::slug($validated['title']);
            $validated['language'] = request()->segment(1);
            $validated['is_featured'] = $request->has('is_featured');
            
            $post->update($validated);

            return redirect()->route(request()->segment(1) . '.admin.posts.index')
                ->with('success', __('Post updated successfully'));
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('Error updating post: ') . $e->getMessage());
        }
    }

    public function destroy(Post $post)
    {
        try {
            if ($post->language !== request()->segment(1)) {
                return redirect()->route(request()->segment(1) . '.admin.posts.index')
                    ->with('error', __('Post not found in this language.'));
            }

            if ($post->featured_image) {
                try {
                    Storage::disk('public')->delete($post->featured_image);
                } catch (Exception $e) {
                    // Continue with deletion even if image deletion fails
                    report($e);
                }
            }
            
            $post->delete();

            return redirect()->route(request()->segment(1) . '.admin.posts.index')
                ->with('success', __('Post deleted successfully'));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', __('Error deleting post: ') . $e->getMessage());
        }
    }
}