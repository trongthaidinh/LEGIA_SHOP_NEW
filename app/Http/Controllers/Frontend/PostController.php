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
        $query = Post::published()->byLanguage(app()->getLocale());

        // Filter by category
        if ($request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category)
                  ->where('language', app()->getLocale());
            });
        }

        $posts = $query->latest()->paginate(9);
        $categories = PostCategory::active()->byLanguage()->get();
        $featuredPosts = Post::published()
            ->byLanguage(app()->getLocale())
            ->featured()
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.posts.index', compact('posts', 'categories', 'featuredPosts', 'request'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->byLanguage(app()->getLocale())
            ->firstOrFail();

        $relatedPosts = Post::where('id', '!=', $post->id)
            ->where('status', 'published')
            ->byLanguage(app()->getLocale())
            ->latest()
            ->take(4)
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
