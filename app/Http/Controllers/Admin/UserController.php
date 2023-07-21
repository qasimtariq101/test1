<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Datatables;
use Hash;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index')->with('page_title', __('Users'));
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email', 'role', 'status', 'created_at']);
            return Datatables::of($users)
                ->editColumn('role', function ($user) {
                    return ($user->role == 1) ? __('Administrator') : __('Registered User');
                })
                ->addColumn('status', function ($user) {
                    if ($user->status == 0) {
                        return '<span class="text-danger">'.__('Inactive').'</span>';
                    } elseif ($user->status == 1) {
                        return '<span class="text-success">'.__('Active').'</span>';
                    } else {
                        return '<span class="text-red">'.__('Banned').'</span>';
                    }

                })
                ->addColumn('action', function ($user) {
                    return '<a class="btn btn-sm btn-default" href="' . url('admin/users/' . $user->id . '/edit') . '"><i class="fa fa-edit"></i> '.__('Edit').'</a> <a class="btn btn-sm btn-danger eco_link" href="' . url('admin/users/' . $user->id . '/delete') . '"><i class="fa fa-trash"></i> '.__('Delete').'</a>';
                })
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.user.create')->with('page_title', __('Users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'              => 'required|alpha_num|min:3|max:20|unique:users,name',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:6|max:50|confirmed',
            'role'                  => 'required|numeric|in:1,2',
            'status'                => 'required|numeric|in:0,1,2',
            'password_confirmation' => '',
            'avatar'                => 'sometimes|mimes:jpeg,jpg,png|max:1024',
            'about'                 => 'nullable|eco_long_string',
            'fb'                    => 'nullable|url|max:255',
            'tw'                    => 'nullable|url|max:255',
            'gp'                    => 'nullable|url|max:255',            
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages_admin($validator->errors()->all(),'error');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user                  = new User();
            $user->name            = $request->username;
            $user->email           = $request->email;
            $user->role            = $request->role;
            $user->status          = $request->status;
            if($request->status == 1){
                $user->email_verified_at = date('Y-m-d H:i:s');
            }            
            $user->password        = Hash::make($request->password);

            if ($request->hasFile('avatar')) {
                $destinationPath = 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                if (!empty($user->avatar)) {
                    if(file_exists(ltrim($user->avatar, '/'))) unlink(ltrim($user->avatar, '/'));
                }
                $random              = str_random(10);
                $avatar              = $request->file('avatar');
                $file_ext            = $avatar->getClientOriginalExtension();
                $avatar_name         = $random . '.' . $file_ext;
                $resized_avatar_name = $random . '_120x120.' . $file_ext;

                $avatar->move($destinationPath, $avatar_name);
                $original_avatar = $destinationPath . '/' . $avatar_name;

                Image::make($original_avatar)->resize(120, 120)->save($destinationPath . '/' . $resized_avatar_name);

                $user->avatar = '/' . $destinationPath . '/' . $resized_avatar_name;
                unlink($original_avatar);
            }
            $user->about = $request->about;
            $user->fb = $request->fb;
            $user->tw = $request->tw;
            $user->gp = $request->gp;
            $user->save();

            if($request->ajax()) return alert_messages_admin(__('Successfully added'));
            return redirect()->back()->withSuccess(__('Successfully added'));
        }
    }

    public function edit($id)
    {
        $user = User::findOrfail($id);
        return view('admin.user.edit', compact('user'))->with('page_title', __('Users'));
    }

    public function update($id, Request $request)
    {
        $user      = User::where('id', $id)->firstOrfail();
        $validator = Validator::make($request->all(), [
            'username'              => 'required|alpha_num|min:3|max:20|unique:users,name,' . $user->id,
            'email'                 => 'required|email|unique:users,email,' . $user->id,
            'password'              => 'nullable|min:6|string|confirmed',
            'password_confirmation' => 'sometimes',
            'role'                  => 'required|numeric|in:1,2',
            'status'                => 'required|numeric|in:0,1,2',
            'avatar'                => 'sometimes|mimes:jpeg,jpg,png|max:1024',
            'about'                 => 'nullable|eco_long_string',
            'fb'                    => 'nullable|url|max:255',
            'tw'                    => 'nullable|url|max:255',
            'gp'                    => 'nullable|url|max:255',            
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages_admin($validator->errors()->all(),'error');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user->name   = $request->username;
            $user->email  = $request->email;
            $user->role   = $request->role;
            $user->status = $request->status;
            if($request->status == 1 && empty($user->email_verified_at)){
                $user->email_verified_at = date('Y-m-d H:i:s');
            } 

            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('avatar')) {
                $destinationPath = 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                if (!empty($user->avatar)) {
                    if(starts_with($user->avatar,'/uploads') && file_exists(ltrim($user->avatar,'/'))) unlink(ltrim($user->avatar, '/'));
                }
                $random              = str_random(10);
                $avatar              = $request->file('avatar');
                $file_ext            = $avatar->getClientOriginalExtension();
                $avatar_name         = $random . '.' . $file_ext;
                $resized_avatar_name = $random . '_120x120.' . $file_ext;

                $avatar->move($destinationPath, $avatar_name);
                $original_avatar = $destinationPath . '/' . $avatar_name;

                Image::make($original_avatar)->resize(120, 120)->save($destinationPath . '/' . $resized_avatar_name);

                $user->avatar = '/' . $destinationPath . '/' . $resized_avatar_name;
                unlink($original_avatar);
            }
            $user->about = $request->about;
            $user->fb = $request->fb;
            $user->tw = $request->tw;
            $user->gp = $request->gp;
            $user->save();

            if($request->ajax()) return alert_messages_admin(__('Successfully updated'));
            return redirect()->back()->withSuccess(__('Successfully updated'));
        }
    }

    public function destroy(Request $request)
    {
        User::where('id', $request->id)->delete();

        if($request->ajax()) return alert_messages_admin(__('Successfully deleted'));
        return redirect()->back()->withSuccess(__('User Successfully deleted'));
    }
}
