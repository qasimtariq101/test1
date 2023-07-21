<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Validator;
use DataTables;

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
            return DataTables::of($menus)
                ->editColumn('name', function ($menu) {
                    return $menu->name;
                })
                ->editColumn('is_default', function ($menu) {
                    return ($menu->is_default) ? 'Yes' : 'No';
                })
                ->editColumn('created_at', function ($menu) {
                    return $menu->created_at->format('Y-m-d H:i:s');
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

    // Menu items methods are added here
    public function items(Menu $menu)
    {
        return view('admin.menus.items', compact('menu'))->with('page_title', __('Menu Items'));
    }

    public function createItem(Menu $menu)
    {
        return view('admin.menus.create-item', compact('menu'))->with('page_title', __('Create Menu Item'));
    }

    public function storeItem(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string|max:255',
            'item_link' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) return alert_messages_admin($validator->errors()->all(), 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $menuItem = new MenuItem();
            $menuItem->item_name = $request->item_name;
            $menuItem->item_link = $request->item_link;
            $menu->menuItems()->save($menuItem);
            if ($request->ajax()) return alert_messages_admin(__('Successfully added'));
            return redirect()->route('menus.items', $menu->id)->withSuccess(__('Successfully added'));
        }
    }

    public function editItem(Menu $menu, MenuItem $item)
    {
        return view('admin.menus.edit-item', compact('menu', 'item'))->with('page_title', __('Edit Menu Item'));
    }

    public function updateItem(Request $request, Menu $menu, MenuItem $item)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string|max:255',
            'item_link' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) return alert_messages_admin($validator->errors()->all(), 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $item->item_name = $request->item_name;
            $item->item_link = $request->item_link;
            $item->save();
            if ($request->ajax()) return alert_messages_admin(__('Successfully updated'));
            return redirect()->route('menus.items', $menu->id)->withSuccess(__('Successfully updated'));
        }
    }

    public function destroyItem(Menu $menu, MenuItem $item)
    {
        $item->delete();
        return redirect()->route('menus.items', $menu->id)->withSuccess('Menu item deleted successfully!');
    }

    public function getItems(Request $request, Menu $menu)
    {
        if ($request->ajax()) {
            $items = $menu->menuItems()->select();
            return DataTables::of($items)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->editColumn('item_name', function ($item) {
                    return $item->item_name;
                })
                ->editColumn('item_link', function ($item) {
                    return $item->item_link;
                })
                ->addColumn('action', function ($item) use ($menu) {
                    $editRoute = route('menus.items.edit', [$menu->id, $item->id]);
                    $deleteRoute = route('menus.items.destroy', [$menu->id, $item->id]);
                    $csrfToken = csrf_token();
                    return '<a class="btn btn-sm btn-success" href="' . $editRoute . '"><i class="fa fa-edit"></i> Edit</a> <button class="btn btn-sm btn-danger" onclick="deleteMenuItem(' . $menu->id . ', ' . $item->id . ', \'' . $deleteRoute . '\', \'' . $csrfToken . '\')"><i class="fa fa-trash"></i> Delete</button>';
                })
                ->make(true);
        }
    }
}
