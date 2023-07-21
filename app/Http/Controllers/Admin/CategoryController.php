<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Datatables;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $old_categories = \DB::table('categories')->where('name','not like','{%')->get();

        foreach($old_categories as $old_category)
        {
            $result = json_decode($old_category->name);

            if (json_last_error() !== 0) {
                $category = Category::findOrfail($old_category->id);
                $category->name = $old_category->name;
                $category->save();
            }
        }

        return view('admin.categories.index')->with('page_title', __('Categories'));
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::select();
            return Datatables::of($categories)
                ->editColumn('name', function ($item) {
                    return $item->name;
                })
				->editColumn('catgdesc', function ($item) {
                    return $item->catgdesc;
                })
				->editColumn('catgtags', function ($item) {
                    return $item->catgtags;
                })
                ->editColumn('parent', function ($item) {   
                    return (isset($item->parent)) ? $item->parent->name : '-';  
                }) 
                ->editColumn('active', function ($item) {
                    if ($item->active == 1) {
                        return '<span class="text-success">'.__('Active').'</span>';
                    } else {
                        return '<span class="text-danger">'.__('Inactive').'</span>';
                    }

                })
                ->addColumn('action', function ($item) {
                    return '<a class="btn btn-sm btn-default" href="' . url('admin/categories/' . $item->id . '/edit') . '"><i class="fa fa-edit"></i> '.('Edit').'</a> <a class="btn btn-sm btn-danger eco_link" href="' . url('admin/categories/' . $item->id . '/delete') . '"><i class="fa fa-trash"></i> '.('Delete').'</a>';
                })
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.categories.create')->with('page_title', __('Categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|min:3|max:50|eco_string|unique:categories,name',
			'catgdesc'    => 'nullable|max:5000',
            'catgtags'        => 'nullable|eco_tags|max:255',
            'active'    => 'required|numeric|in:0,1',
            'parent'    => 'nullable|numeric|exists:categories,id'
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages_admin($validator->errors()->all(),'error');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $category            = new Category();
            $category->name      = $request->name;
			$category->catgdesc      = $request->catgdesc;
			$category->catgtags      = $request->catgtags;
            $category->slug      = str_slug($request->name);
            $category->active    = $request->active;
            if(!empty($request->parent)) $category->parent_id = $request->parent;
            $category->save();
            if($request->ajax()) return alert_messages_admin(__('Successfully added'));
            return redirect()->back()->withSuccess(__('Successfully added'));
        }
    }

    public function edit($id)
    {
        $category = Category::findOrfail($id);
        return view('admin.categories.edit', compact('category'))->with('page_title', __('Categories'));
    }

    public function update($id, Request $request)
    {
        $category    = Category::where('id', $id)->firstOrfail();
        $validator = Validator::make($request->all(), [
            'name'      => 'required|min:3|max:50|eco_string|unique:categories,name,' . $category->id,
			'catgdesc'    => 'nullable|max:5000',
            'catgtags'        => 'nullable|eco_tags|max:255',
            'active'    => 'required|numeric|in:0,1',
            'parent'    => 'nullable|numeric|exists:categories,id'
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages_admin($validator->errors()->all(),'error');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $category->name      = $request->name;
			$category->catgdesc      = $request->catgdesc;
			$category->catgtags      = $request->catgtags;
            $category->active    = $request->active;
            $category->parent_id = $request->parent;
            $category->save();
            if($request->ajax()) return alert_messages_admin(__('Successfully updated'));
            return redirect()->back()->withSuccess(__('Successfully updated'));
        }
    }

    public function destroy(Request $request)
    {
        Category::where('id', $request->id)->delete();
        if($request->ajax()) return alert_messages_admin(__('Successfully deleted'));
        return redirect()->back()->withSuccess(__('Successfully deleted'));
    }
}
