<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
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
            'type' => 'required|string|in:main,footer,sidebar',
            'language' => 'required|string|in:vi,zh',
            'is_active' => 'boolean'
        ]);

        Menu::create($validated);

        return redirect()
            ->route(app()->getLocale() . '.admin.menus.index')
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
            'type' => 'required|string|in:main,footer,sidebar',
            'language' => 'required|string|in:vi,zh',
            'is_active' => 'boolean'
        ]);

        $menu->update($validated);

        return redirect()
            ->route(app()->getLocale() . '.admin.menus.index')
            ->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()
            ->route(app()->getLocale() . '.admin.menus.index')
            ->with('success', 'Menu deleted successfully.');
    }

    // Menu Items Management
    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'icon_class' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $validated['order'] = $menu->items()->max('order') + 1;
        
        $menu->items()->create($validated);

        return redirect()
            ->back()
            ->with('success', 'Menu item added successfully.');
    }

    public function editItem(MenuItem $menuItem)
    {
        return response()->json($menuItem);
    }

    public function updateItem(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon_class' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $menuItem->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroyItem(MenuItem $menuItem)
    {
        $menuItem->delete();

        return redirect()
            ->back()
            ->with('success', 'Menu item deleted successfully.');
    }

    public function reorderItems(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.order' => 'required|integer',
            'items.*.parent_id' => 'nullable|exists:menu_items,id'
        ]);

        foreach ($validated['items'] as $item) {
            MenuItem::where('id', $item['id'])->update([
                'parent_id' => $item['parent_id'] ?? null,
                'order' => $item['order']
            ]);
        }

        return response()->json(['message' => 'Menu items reordered successfully.']);
    }
} 