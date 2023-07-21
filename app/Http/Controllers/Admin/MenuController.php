<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Validator;
use Datatables;

class MenuController extends Controller
{
    public function index()
    {
        return view('admin.menus.index')->with('page_title', __('Menus'));
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $menus = Menu::select();
            return Datatables::of($menus)
                ->editColumn('name', function ($menu) {
                    return $menu->name;
                })
                ->editColumn('is_default', function ($menu) {
                    return ($menu->is_default) ? 'Yes' : 'No';
                })
                ->editColumn('created_at', function ($menu) {
                    return $menu->created_at->format('Y-m-d H:i:s');
                })
                ->editColumn('parent', function ($menu) {
                    return ($menu->parent) ? $menu->parent->name : '-';
                })
                ->addColumn('action', function ($menu) {
                    return '<a class="btn btn-sm btn-default" href="' . route('menus.show', $menu->id) . '"><i class="fa fa-eye"></i> View</a> <a class="btn btn-sm btn-success" href="' . route('menus.edit', $menu->id) . '"><i class="fa fa-edit"></i> Edit</a>';
                })
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.menus.create')->with('page_title', __('Menus'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:menus',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) return alert_messages_admin($validator->errors()->all(), 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $menu = new Menu();
            $menu->name = $request->name;
            $menu->is_default = $request->input('is_default', false);
            $menu->save();
            if ($request->ajax()) return alert_messages_admin(__('Successfully added'));
            return redirect()->back()->withSuccess(__('Successfully added'));
        }
    }

    public function show(Menu $menu)
    {
        return view('admin.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'))->with('page_title', __('Menus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:menus,name,' . $menu->id,
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) return alert_messages_admin($validator->errors()->all(), 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $menu->name = $request->name;
            $menu->is_default = $request->input('is_default', false);
            $menu->save();
            if ($request->ajax()) return alert_messages_admin(__('Successfully updated'));
            return redirect()->back()->withSuccess(__('Successfully updated'));
        }
    }

    public function destroy(Menu $menu)
    {
        $menu->menuItems()->delete();
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu deleted successfully!');
    }

    public function items(Menu $menu)
    {
        $menu->load('menuItems');
        return view('admin.menus.items', compact('menu'));
    }

    public function createItem(Menu $menu)
    {
        return view('admin.menus.create-item', compact('menu'));
    }

    public function storeItem(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $menuItem = new MenuItem();
            $menuItem->title = $request->title;
            $menuItem->url = $request->url;
            $menuItem->parent_id = $request->parent_id;
            $menuItem->order = $request->order;
            $menu->menuItems()->save($menuItem);
            return redirect()->route('menus.items', $menu->id)->withSuccess(__('Menu item created successfully!'));
        }
    }

    public function editItem(Menu $menu, MenuItem $item)
    {
        return view('admin.menus.edit-item', compact('menu', 'item'));
    }

    public function updateItem(Request $request, Menu $menu, MenuItem $item)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $item->title = $request->title;
            $item->url = $request->url;
            $item->parent_id = $request->parent_id;
            $item->order = $request->order;
            $item->save();
            return redirect()->route('menus.items', $menu->id)->withSuccess(__('Menu item updated successfully!'));
        }
    }

    public function destroyItem(Menu $menu, MenuItem $item)
    {
        $item->delete();
        return redirect()->route('menus.items', $menu->id)->withSuccess(__('Menu item deleted successfully!'));
    }
}