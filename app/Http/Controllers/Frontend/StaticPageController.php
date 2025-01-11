<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaticPageController extends Controller
{
    public function show(string $slug): View
    {
        try {
            // Find the static page by slug and current locale
            $page = StaticPage::findBySlug($slug);

            // Render the static page view
            return view('frontend.static-page', [
                'page' => $page,
                'title' => $page->title,
                'metaDescription' => $page->meta_description,
                'metaKeywords' => $page->meta_keywords
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Redirect to 404 or home page if page not found
            return abort(404);
        }
    }

    // Optional: Method to create/update static pages (could be used in admin panel)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|unique:static_pages,slug',
            'locale' => 'nullable|string|in:vi,en,zh',
            'is_active' => 'nullable|boolean',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255'
        ]);

        $page = StaticPage::createOrUpdatePage($validatedData);

        return response()->json([
            'message' => 'Static page created/updated successfully',
            'page' => $page
        ], 201);
    }
}
