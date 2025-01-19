<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        //filter by language
        $menus = Menu::where('language', app()->getLocale())->latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'language' => 'required|string|max:5',
        ]);

        // Handle is_active field
        $validated['is_active'] = $request->has('is_active');

        Menu::create($validated);

        return redirect()->route(app()->getLocale() . '.admin.menus.index')
            ->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'language' => 'required|string|max:5',
        ]);

        // Handle is_active field
        $validated['is_active'] = $request->has('is_active');

        $menu->update($validated);

        return redirect()->route(app()->getLocale() . '.admin.menus.index')
            ->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route(app()->getLocale() . '.admin.menus.index')
            ->with('success', 'Menu deleted successfully.');
    }
} 