<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use App\Traits\HandleUploadImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class PostController extends Controller
{
    use HandleUploadImage;

    /**
     * Folder path for storing post images
     */
    const IMAGE_FOLDER = 'posts';

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

    public function store(PostRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            // Handle image upload
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $this->handleUploadImage(
                    $request->file('featured_image'),
                    self::IMAGE_FOLDER
                );
            }

            $validated['admin_id'] = auth()->id();
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], Post::class);
            $validated['language'] = request()->segment(1);

            // Remove unnecessary fields
            unset($validated['is_published']);

            Post::create($validated);

            DB::commit();
            return redirect()->route(request()->segment(1) . '.admin.posts.index')
                ->with('success', __('Post created successfully'));
        } catch (Exception $e) {
            DB::rollBack();
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

    public function update(PostRequest $request, Post $post)
    {
        try {
            if ($post->language !== request()->segment(1)) {
                return redirect()->route(request()->segment(1) . '.admin.posts.index')
                    ->with('error', __('Post not found in this language.'));
            }

            DB::beginTransaction();

            $validated = $request->validated();

            // Handle image upload
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $this->handleUploadImage(
                    $request->file('featured_image'),
                    self::IMAGE_FOLDER,
                    $post->featured_image
                );
            }

            $validated['slug'] = $this->generateUniqueSlug($validated['title'], Post::class, $post->id);
            $validated['language'] = request()->segment(1);

            // Remove unnecessary fields
            unset($validated['is_published']);
            
            $post->update($validated);

            DB::commit();
            return redirect()->route(request()->segment(1) . '.admin.posts.index')
                ->with('success', __('Post updated successfully'));
        } catch (Exception $e) {
            DB::rollBack();
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

            DB::beginTransaction();

            // Delete post image
            if ($post->featured_image) {
                $this->deleteImage($post->featured_image);
            }
            
            $post->delete();

            DB::commit();
            return redirect()->route(request()->segment(1) . '.admin.posts.index')
                ->with('success', __('Post deleted successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', __('Error deleting post: ') . $e->getMessage());
        }
    }
}