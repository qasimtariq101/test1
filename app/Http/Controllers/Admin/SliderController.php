<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Datatables;
use Illuminate\Http\Request;
use Validator;

class SliderController extends Controller
{
    public function index()
    {
        return view('admin.slider.index')->with('page_title', __('Slider'));
    }

    public function create()
    {
        return view('admin.slider.create')->with('page_title', __('Slider'));
    }

    public function edit($id)
    {
        $slide = Slider::findOrfail($id);

        return view('admin.slider.edit', compact('slide'))->with('page_title', __('Slider'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|min:2|max:40|string',
            'image' => 'required|mimes:jpg,jpeg|max:2048',
            'active'  => 'required|numeric|in:0,1',
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages_admin($validator->errors()->all(),'error');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $slide          = new Slider();
            $slide->name   = $request->name;
            $slide->active  = $request->active;


            if ($request->hasFile('image')) {
                $destinationPath = 'uploads/slides';
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $random                 = str_random(6);
                $image              = $request->file('image');
                $file_ext               = $image->getClientOriginalExtension();
                $image_name         = $random . '.' . $file_ext;
                $resized_image_name = $random . '_1170x500.' . $file_ext;

                $image->move($destinationPath, $image_name);
                $original_image = $destinationPath . '/' . $image_name;

                \Image::make($original_image)->fit(1170, 500)->save($destinationPath . '/' . $resized_image_name);

                $slide->image = $destinationPath . '/' . $resized_image_name;
                unlink($original_image);
            }


            $slide->save();

            if($request->ajax()) return alert_messages_admin(__('Successfully added'));
            return redirect()->back()->withSuccess(__('Successfully added'));
        }
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|min:2|max:40|string',
            'image' => 'nullable|mimes:jpg,jpeg|max:2048',
            'active'  => 'required|numeric|in:0,1',
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages_admin($validator->errors()->all(),'error');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $slide          = Slider::findOrfail($id);
            $slide->name   = $request->name;
            $slide->active  = $request->active;

            if ($request->hasFile('image')) {
                $destinationPath = 'uploads/slides';
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                if (file_exists($slide->image)) {
                    unlink($slide->image);
                }

                $random                 = str_random(6);
                $image              = $request->file('image');
                $file_ext               = $image->getClientOriginalExtension();
                $image_name         = $random . '.' . $file_ext;
                $resized_image_name = $random . '_1170x500.' . $file_ext;

                $image->move($destinationPath, $image_name);
                $original_image = $destinationPath . '/' . $image_name;

                \Image::make($original_image)->fit(1170, 500)->save($destinationPath . '/' . $resized_image_name);

                $slide->image = $destinationPath . '/' . $resized_image_name;
                unlink($original_image);
            }

            $slide->save();

            if($request->ajax()) return alert_messages_admin(__('Successfully updated'));
            return redirect()->back()->withSuccess(__('Successfully updated'));
        }
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $items = Slider::select();

            return Datatables::of($items)                
                ->editColumn('active', function ($item) {
                    if ($item->active == 1) {
                        return __('Yes');
                    } else {
                        return __('No');
                    }

                })
                ->addColumn('action', function ($item) {
                    return '<a class="btn btn-sm btn-default" href="' . url('admin/slider/' . $item->id . '/edit') . '"><i class="fa fa-edit"></i> '.__('Edit').'</a> <a class="btn btn-sm btn-danger eco_link" href="' . url('admin/slider/' . $item->id . '/delete') . '"><i class="fa fa-trash"></i> '.__('Delete').'</a>';
                })
                ->make(true);
        }
    }

    public function destroy(Request $request)
    {
        Slider::where('id',$request->id)->delete();

        if($request->ajax()) return alert_messages_admin(__('Successfully added'));
        return redirect()->back()->withSuccess(__('Successfully deleted'));
    }
}
