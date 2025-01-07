<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published();

        // Filter by category
        if ($request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->latest()->paginate(9);
        $categories = PostCategory::active()->withCount('posts')->get();
        $featuredPosts = Post::published()->featured()->latest()->take(3)->get();

        return view('frontend.posts.index', compact('posts', 'categories', 'featuredPosts'));
    }

    public function show($slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPosts = Post::published()
            ->where('post_category_id', $post->post_category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.posts.show', compact('post', 'relatedPosts'));
    }

    public function search(Request $request)
    {
        $query = Post::published();

        if ($request->q) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('content', 'like', '%' . $request->q . '%');
            });
        }

        $posts = $query->latest()->paginate(9);

        return view('frontend.posts.search', compact('posts'));
    }
}
