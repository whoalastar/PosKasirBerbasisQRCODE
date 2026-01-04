<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::with('category');

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // Changed pagination from 15 to 10
        $menus = $query->latest()->paginate(5);
        $categories = Category::where('is_active', true)->get();

        return view('admin.menus.index', compact('menus', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.menus.create', compact('categories'));
    }

    public function store(MenuRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully');
    }

    public function show(Menu $menu)
    {
        return view('admin.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully');
    }

    public function toggleStatus(Menu $menu)
    {
        $menu->update(['is_available' => !$menu->is_available]);
        
        $status = $menu->is_available ? 'made available' : 'made unavailable';
        return redirect()->back()->with('success', "Menu {$status} successfully");
    }

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'menu_ids' => 'required|array',
            'menu_ids.*' => 'exists:menus,id',
            'action' => 'required|in:available,unavailable,delete'
        ]);

        $menus = Menu::whereIn('id', $request->menu_ids);

        switch ($request->action) {
            case 'available':
                $menus->update(['is_available' => true]);
                $message = count($request->menu_ids) . ' menus made available';
                break;
            case 'unavailable':
                $menus->update(['is_available' => false]);
                $message = count($request->menu_ids) . ' menus made unavailable';
                break;
            case 'delete':
                foreach ($menus->get() as $menu) {
                    if ($menu->image) {
                        Storage::disk('public')->delete($menu->image);
                    }
                }
                $menus->delete();
                $message = count($request->menu_ids) . ' menus deleted successfully';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    public function updateStock(Request $request, Menu $menu)
    {
        $request->validate([
            'stock' => 'required|integer|min:0|max:999'
        ]);

        $oldStock = $menu->stock;
        $menu->update([
            'stock' => $request->stock,
            'is_available' => $request->stock > 0 ? true : $menu->is_available
        ]);

        $message = "Stock updated from {$oldStock} to {$request->stock}";
        return redirect()->back()->with('success', $message);
    }
}