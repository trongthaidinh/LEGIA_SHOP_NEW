<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        $pages = StaticPage::where('locale', $locale)
            ->orderBy('title')
            ->paginate(10);

        return view('admin.static-pages.index', compact('pages', 'locale'));
    }

    public function create()
    {
        return view('admin.static-pages.create');
    }

    public function store(Request $request)
    {
        $request['locale'] = app()->getLocale();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'content' => 'required|string',
            'locale' => 'required|string|in:vi,zh',
            'is_active' => 'boolean',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255'
        ]);
        StaticPage::createOrUpdatePage($validated);

        return redirect()
            ->route(app()->getLocale() . '.admin.static-pages.index')
            ->with('success', __('Static page created successfully'));
    }

    public function edit(StaticPage $staticPage)
    {
        if (request()->ajax()) {
            return response()->json($staticPage);
        }
        return view('admin.static-pages.edit', compact('staticPage'));
    }

    public function update(Request $request, StaticPage $staticPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'content' => 'required|string',
            'locale' => 'required|string|in:vi,zh',
            'is_active' => 'boolean',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255'
        ]);

        $staticPage->update($validated);

        return redirect()
            ->route(app()->getLocale() . '.admin.static-pages.index')
            ->with('success', __('Static page updated successfully'));
    }

    public function destroy(StaticPage $staticPage)
    {
        $staticPage->delete();

        return redirect()
            ->route(app()->getLocale() . '.admin.static-pages.index')
            ->with('success', __('Static page deleted successfully'));
    }

    public function toggleStatus(StaticPage $staticPage)
    {
        $staticPage->update(['is_active' => !$staticPage->is_active]);

        return response()->json([
            'message' => __('Static page status updated successfully'),
            'is_active' => $staticPage->is_active
        ]);
    }
}
