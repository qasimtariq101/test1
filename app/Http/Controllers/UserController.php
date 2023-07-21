<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'q'  => 'nullable|eco_string|max:100',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        
        if(config('settings.publishers_page') != 1) return redirect()->back()->withErrors(__('This feature is disabled'));
        $users = User::withCount('books')->where('status',1);

        if (isset($request->q)) {
            if (config('settings.search_page') == 1) {
                $users = $users->where('name', 'like', $request->q . '%');
            } else {
                return redirect()->back()->withErrors(__('This feature is disabled'));
            }

        }

        $users = $users->orderBy('created_at','DESC')->paginate(18,['id','name','avatar','role','status','about','fb','tw','gp']);
        return view('front.user.index',compact('users'))->with('page_title',__('Publishers'));
    }

    public function profile($username, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'nullable|eco_string',
            'keyword'  => 'nullable|eco_string|max:100',
            's'        => 'nullable|numeric|in:1,2,3,4',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user  = User::where('name', $username)->firstOrfail();
        $books = Book::with('user')->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->where('status', 1)->where('active',1)
            ->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
                $query->whereIn('status', [0, 1]);

            });

        if (isset($request->keyword)) {
            if (config('settings.search_page') == 1) {
                $books = $books->where('title', 'like', '%' . $request->keyword . '%');
            } else {
                return redirect()->back()->withErrors(__('This feature is disabled'));
            }

        }

        if (isset($request->s) && $request->s != 1) {
            if ($request->s == 2) {
                $books = $books->orderBy('views', 'DESC');
            }

            if ($request->s == 3) {
                $books = $books->orderBy('average_rating', 'DESC');
            }

            if ($request->s == 4) {
                $books = $books->where('featured', 1)->orderBy('created_at', 'DESC');
            }

        } else {
            $books = $books->orderBy('created_at', 'DESC');
        }

        $books = $books->paginate(config('settings.books_per_page'));

        $favorites = [];
        if (\Auth::check()) {
            $favorites = Favorite::where('user_id', \Auth::user()->id)
                ->whereHas('book', function ($query) {
                    $query->where(function ($q) {
                        $q->orWhereNull('user_id');
                        $q->orWhereHas('user', function ($user) {
                            $user->whereIn('status', [0, 1]);
                        });
                    });
                })
                ->pluck('book_id')->toArray();
        }
        return view('front.user.show', compact('user', 'books', 'favorites'))->with('page_title', $user->name);
    }

    public function contact($name, Request $request)
    {
        $captcha = '';
        if (config('settings.captcha') == 1) {
            if (config('settings.captcha_type') == 1) {
                $captcha = 'required|captcha';
            } else {
                $captcha = 'required|custom_captcha';
            }

        }
        $validator = Validator::make($request->all(), [
            'name'                 => 'required|eco_string|min:2|max:100',
            'email'                => 'required|email',
            'message'              => 'required|eco_long_string|min:10|max:255',
            'g-recaptcha-response' => $captcha,
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages($validator->errors()->all(),'error');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $user = User::where('name', $name)->firstOrfail(['name', 'email']);
            try {
                \Mail::send('emails.user', ['request' => $request, 'user' => $user], function ($m) use ($user) {
                    $m->to($user->email)->subject(config('settings.site_name') . ' - ' . __('Contact Message'));
                });
            } catch (\Exception $e) {
                \Log::info($e->getMessage());

                if($request->ajax()) return alert_messages(___('Your message was not sent due to invalid mail configuration'),'warning');
                return redirect()->back()->with('warning', __('Your message was not sent due to invalid mail configuration'));
            }

            if($request->ajax()) return alert_messages(__('Your message successfully sent'));
            return redirect()->back()->with('success', __('Your message successfully sent'));
        }

    }

    public function edit()
    {
        $user = User::findOrfail(\Auth::user()->id);
        return view('front.user.edit', compact('user'))->with('page_title', __('Edit Profile'));
    }

    public function update(Request $request)
    {
        $user      = User::findOrfail(\Auth::user()->id);
        $validator = Validator::make($request->all(), [
            'password'              => 'nullable|min:6|string|confirmed',
            'password_confirmation' => 'sometimes',
            'avatar'                => 'sometimes|mimes:jpeg,jpg,png|max:1024',
            'about'                 => 'nullable|eco_long_string',
            'fb'                    => 'nullable|url|max:255',
            'tw'                    => 'nullable|url|max:255',
            'gp'                    => 'nullable|url|max:255',
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages($validator->errors()->all(),'error');
            return redirect()->back()->withErrors($validator);
        }

        if (!empty($request->password)) {
            $user->password = \Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $destinationPath = 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            if (!empty($user->avatar)) {
                if (starts_with($user->avatar, '/uploads') && file_exists(ltrim($user->avatar, '/'))) {
                    unlink(ltrim($user->avatar, '/'));
                }

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
        $user->fb    = $request->fb;
        $user->tw    = $request->tw;
        $user->gp    = $request->gp;

        $user->save();
        if($request->ajax()) return alert_messages(__('Profile successfully updated'));
        return redirect()->back()->withSuccess(__('Profile successfully updated'));
    }

    public function destroy(Request $request)
    {
        $captcha = 'required|custom_captcha';

        $user = User::findOrfail(\Auth::user()->id);
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|string',
            'g-recaptcha-response' => $captcha,
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (\Hash::check($request->password, $user->password)) {

            $books = Book::where('user_id',$user->id)->get();
            
            foreach ($books as $book) {
                if (file_exists(ltrim($book->file, '/'))) {
                    unlink(ltrim($book->file, '/'));
                }

                if (file_exists(ltrim($book->file, '/'))) {
                    unlink(ltrim($book->thumbnail, '/'));
                }

                Book::where('id', $book->id)->delete();
            }

            \Auth::logout();
            if ($user->delete()) return redirect('/')->withSuccess(__('Your account has been deleted successfully'));
        } else {
            return redirect()->back()->withErrors(__('Please enter valid password'));
        }
    }

}
