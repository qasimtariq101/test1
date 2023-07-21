<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Rating;
use App\Models\Report;
use Illuminate\Http\Request;
use Validator;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'nullable|eco_string',
            'keyword'  => 'nullable|eco_string|max:100',
            's'        => 'nullable|numeric|in:1,2,3,4',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $books = Book::with('user')->where('status', 1)->where('active',1);

        if (isset($request->keyword)) {
            if (config('settings.search_page') == 1) {
                $books = $books->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->keyword . '%')
                          ->orWhere('author_name', 'like', '%' . $request->keyword . '%')
                          ->orWhere('overview', 'like', '%' . $request->keyword . '%')
                          ->orWhere('tags', 'like', '%' . $request->keyword . '%');
                });
            } else {
                return redirect()->back()->withErrors(__('This feature is disabled'));
            }
        }
               

        if (isset($request->author)) {
            $books = $books->where('author_name', $request->author);
        }

        $category = [];
        if (isset($request->category) && $request->category != 'all') {
            $category = Category::where('active',1)->where('slug',$request->category)->where(function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->firstOrfail();           
            $books = $books->whereHas('active_category', function ($query) use ($request,$category) {
                $query->where('slug', $category->slug)->orWhere(function($q) use($category){
                    $q->where('parent_id', $category->id)->where('active',1);
                });
                $query->where('active', 1);
            });
        } else {
            $books = $books->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            });
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

        $books = $books->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        });

        $books = $books->paginate(config('settings.books_per_page'));

        $favorites = [];
        if (\Auth::check()) {
            $favorites = Favorite::where('user_id', \Auth::user()->id)->pluck('book_id')->toArray();
        }

        $page_title = __('Books');
        if(!empty($category)) $page_title = $category->name;
        return view('front.books.index', compact('books', 'favorites','category'))->with('page_title', $page_title);
    }

    public function show($slug)
    {
        $book = Book::withCount('ratings')->with('user')->where('slug', $slug)->where('active',1)->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
        })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->firstOrfail();

        $related_books = Book::where('status', 1)->where('active',1)->where('id', '!=', $book->id)->whereHas('category', function ($query) use ($book) {
            $query->where('id', $book->category_id);
            $query->where('active', 1);
        })->limit(6)->get();

        $favorites = [];
        if (\Auth::check()) {
            $favorites = Favorite::where('user_id', \Auth::user()->id)->pluck('book_id')->toArray();
        }

        if (session()->has('already_viewed')) {
            $already_viewed = session('already_viewed');

            if (!in_array($book->id, $already_viewed)) {
                array_push($already_viewed, $book->id);
                $book->views = $book->views + 1;
                $book->save();
            }

            session(['already_viewed' => $already_viewed]);
        } else {
            $already_viewed = [$book->id];
            session(['already_viewed' => $already_viewed]);
            $book->views = $book->views + 1;
            $book->save();
        }

        return view('front.books.show', compact('book', 'favorites', 'related_books'))->with('page_title', $book->title_f);
    }

    public function rateNow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pid'  => 'required|numeric|exists:books,id',
            'rate' => 'required|numeric|between:0.00,5.00',
        ]);
        if ($validator->fails()) {
            return 'error';
        } else {

            $book = Book::where('id', $request->pid)->where('status', 1)->where('active',1)->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
                $query->orWhereNull('user_id');
                $query->orWhereHas('user', function ($user) {
                    $user->whereIn('status', [0, 1]);
                });
            })->firstOrfail();

            $rating = Rating::where('user_id', \Auth::user()->id)->where('book_id', $request->pid)->first();

            if (!empty($rating)) {
                $rating->rate = $request->rate;
                $rating->save();

                $average              = Rating::where('book_id', $request->pid)->avg('rate');
                $average              = round($average, 2);
                $book->average_rating = $average;
                $book->save();

                echo alert_messages(__('Rating successfully upated'), 'success');
            } else {
                $rating          = new Rating();
                $rating->user_id = \Auth::user()->id;
                $rating->book_id = $request->pid;
                $rating->rate    = $request->rate;
                $rating->save();

                $average = Rating::where('book_id', $request->pid)->avg('rate');
                $average = round($average, 2);

                $book->average_rating = $average;
                $book->save();

                echo alert_messages(__('Rating successfully added'), 'success');
            }
        }
    }

    public function download($slug)
    {
        if (config('settings.feature_download') != 1) {
            return redirect()->back()->withErrors(__('This feature is disabled'));
        }

        if (config('settings.public_download') != 1) {
           if(!\Auth::check()) return redirect(route('login'))->withErrors(__('Please login to download this ebook'));
        }

        $book = Book::where('slug', $slug)->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->where('active',1)->whereNull('password')->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->firstOrfail();
        if ($book->status == 3) {
            if (\Auth::check()) {
                if ($book->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if (session()->has('already_downloaded')) {
            $already_downloaded = session('already_downloaded');

            if (!in_array($book->id, $already_downloaded)) {
                array_push($already_downloaded, $book->id);
                $book->downloads = $book->downloads + 1;
                $book->save();
            }

            session(['already_downloaded' => $already_downloaded]);
        } else {
            $already_downloaded = [$book->id];
            session(['already_downloaded' => $already_downloaded]);
            $book->downloads = $book->downloads + 1;
            $book->save();
        }

        if($book->storage == 'google_drive_link'){
            $file_id = str_replace('https://drive.google.com/file/d/','',$book->file);
            $file_id = str_replace('/preview','',$file_id);
            $download_link = 'https://drive.google.com/u/0/uc?id='.$file_id.'&export=download';
            return redirect()->to($download_link);
        }
        elseif ($book->storage == 'embed_code') {
            return redirect()->back()->withErrors(__('You can not download this ebook'));
        }


        $file     = ltrim($book->file, '/');
        $filename = $book->slug . '.' . $book->type;

        return \Storage::disk($book->storage)->download($book->file, $filename);
    }

    public function embed($slug)
    {
        if (config('settings.feature_embed') != 1) {
            return redirect()->back()->withErrors(__('This feature is disabled'));
        }

        $book = Book::with('user')->where('slug', $slug)->where('active',1)->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->firstOrfail();
        if ($book->status == 3) {
            if (\Auth::check()) {
                if ($book->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if (session()->has('already_viewed')) {
            $already_viewed = session('already_viewed');

            if (!in_array($book->id, $already_viewed)) {
                array_push($already_viewed, $book->id);
                $book->views = $book->views + 1;
                $book->save();
            }

            session(['already_viewed' => $already_viewed]);
        } else {
            $already_viewed = [$book->id];
            session(['already_viewed' => $already_viewed]);
            $book->views = $book->views + 1;
            $book->save();
        }

        return view('front.books.embed', compact('book'))->with('page_title', $book->title_f . ' ' . __('Embed'));
    }

    function print($slug) {
        if (config('settings.feature_print') != 1) {
            return redirect()->back()->withErrors(__('This feature is disabled'));
        }

        $book = Book::where('slug', $slug)->where('active',1)->whereIn('storage',['uploads','ftp','s3','external_link'])->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->whereNull('password')->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->firstOrfail();
        if ($book->status == 3) {
            if (\Auth::check()) {
                if ($book->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if (session()->has('already_viewed')) {
            $already_viewed = session('already_viewed');

            if (!in_array($book->id, $already_viewed)) {
                array_push($already_viewed, $book->id);
                $book->views = $book->views + 1;
                $book->save();
            }

            session(['already_viewed' => $already_viewed]);
        } else {
            $already_viewed = [$book->id];
            session(['already_viewed' => $already_viewed]);
            $book->views = $book->views + 1;
            $book->save();
        }

        $book->file = $book->file_f;

        return view('front.books.print', compact('book'))->with('page_title', $book->title_f . ' ' . __('Print '));
    }

    public function report(Request $request)
    {
        if (config('settings.feature_report') != 1) {
            if($request->ajax()) return alert_messages(__('This feature is disabled'),'error');
            return redirect()->back()->withErrors(__('This feature is disabled'));
        }

        $validator = Validator::make($request->all(), [
            'id'     => 'required|numeric|exists:books,id',
            'reason' => 'required|eco_long_string|min:10|max:1000',

        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages($validator->errors()->all(),'error');
            return redirect()->back()
                ->withErrors($validator);
        }

        $report          = new Report();
        $report->book_id = $request->id;
        $report->user_id = \Auth::user()->id;
        $report->reason  = $request->reason;
        $report->save();

        if($request->ajax()) return alert_messages(__('Successfully reported'));
        return redirect()->back()->withSuccess(__('Successfully reported'));
    }

    public function create()
    {
        if (config('settings.admin_only_upload') == 1) {
            if (\Auth::check()) {
                if (\Auth::user()->role != 1) {
                    return redirect()->back()->withErrors(__('Public upload is currently disabled'));
                }

            } else {
                return redirect()->back()->withErrors(__('Public upload is currently disabled'));
            }
        }

        if (config('settings.public_upload') != 1) {
            if (\Auth::check()) {
                if (\Auth::user()->status != 1) {
                    return redirect()->back()->withErrors(__('Public upload is currently disabled'));
                }

            } else {
                return redirect()->back()->withErrors(__('Public upload is currently disabled'));
            }
        }
        return view('front.books.create')->with('page_title', __('Upload eBook'));
    }

    public function store(Request $request)
    {
        if (config('settings.admin_only_upload') == 1) {
            if (\Auth::check()) {
                if (\Auth::user()->role != 1) {
                     if($request->ajax()) return alert_messages(__('Public upload is currently disabled'),'error');
                    return redirect()->back()->withErrors(__('Public upload is currently disabled'));
                }

            } else {
                if($request->ajax()) return alert_messages(__('Public upload is currently disabled'),'error');
                return redirect()->back()->withErrors(__('Public upload is currently disabled'));
            }
        }

        if (config('settings.public_upload') != 1) {
            if (\Auth::check()) {
                if (\Auth::user()->status != 1) {
                    if($request->ajax()) return alert_messages(__('Public upload is currently disabled'),'error');
                    return redirect()->back()->withErrors(__('Public upload is currently disabled'));
                }

            } else {
                if($request->ajax()) return alert_messages(__('Public upload is currently disabled'),'error');
                return redirect()->back()->withErrors(__('Public upload is currently disabled'));
            }
        }

        $captcha = '';
        if (config('settings.captcha') == 1) {
            if (config('settings.captcha_type') == 1) {
                $captcha = 'required|captcha';
            } else {
                $captcha = 'required|custom_captcha';
            }

        }

        if(config('settings.external_link_embed')) $storage_rule = 'required|in:upload,google_drive_link,external_link,embed_code';
        else $storage_rule = 'required|in:upload,google_drive_link'; 

        $validator = Validator::make($request->all(), [
            'storage'                => $storage_rule,
            'title'                => 'nullable|eco_string|max:150',
            'author_name'                => 'nullable|eco_string|max:30',
            'category_id'          => 'required|numeric|exists:categories,id',
            'overview'             => 'nullable|max:5000',
            'tags'                 => 'nullable|eco_tags|max:255',
            'password'             => 'nullable|string|max:30',
            'embed_code'           => 'required_if:storage,==,embed_code|embed_code',
            'external_link'        => 'required_if:storage,==,external_link|external_link',
            'google_drive_link'    => 'required_if:storage,==,google_drive_link|google_drive_link',
            'ebook'                => 'required_if:storage,==,upload|mimes:' . config('settings.allowed_book_mimes') . '|max:' . config('settings.max_book_upload_size') * 1024,
            'thumbnail'            => 'nullable|mimes:jpg,jpeg,png|max:' . config('settings.max_thumbnail_upload_size') * 1024,
            'status'               => 'required|numeric|in:1,2,3',
            'g-recaptcha-response' => $captcha,
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages($validator->errors()->all(),'error');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (\Auth::check()) {
            $book_count = Book::where('user_id', \Auth::user()->id)->whereDate('created_at', date("Y-m-d"))->count();
            if ($book_count >= config('settings.daily_upload_limit_auth')) {
                if($request->ajax()) return alert_messages(__('Daily upload limit reached'),'error');
                return redirect()->back()->withErrors(__('Daily upload limit reached'))->withInput();
            }

            $last_book = Book::where('user_id', \Auth::user()->id)->orderBy('created_at', 'DESC')->limit(1)->first();
            if (!empty($last_book)) {

                if (strtotime($last_book->created_at) > strtotime('-' . config('settings.upload_time_restrict_auth') . ' seconds')) {
                    $mins = config('settings.upload_time_restrict_auth') / 60;

                    if($request->ajax()) return alert_messages(__('Please wait') . ', ' . $mins . ' ' . __('minutes before making another upload'),'error');
                    return redirect()->back()->withErrors(__('Please wait') . ', ' . $mins . ' ' . __('minutes before making another upload'))->withInput();
                }
            }
        } else {
            $ip_address = request()->ip;
            $book_count = Book::where('ip_address', $ip_address)->whereDate('created_at', date("Y-m-d"))->count();
            if ($book_count >= config('settings.daily_upload_limit_unauth')) {

                if($request->ajax()) return alert_messages(__('Daily upload limit reached') . ', ' . __('Please login to increase your upload limit'),'error');
                return redirect()->back()->withErrors(__('Daily upload limit reached') . ', ' . __('Please login to increase your upload limit'))->withInput();
            }

            $last_book = Book::where('ip_address', $ip_address)->orderBy('created_at', 'DESC')->limit(1)->first();
            if (!empty($last_book)) {

                if (strtotime($last_book->created_at) > strtotime('-' . config('settings.upload_time_restrict_unauth') . ' seconds')) {
                    $mins = config('settings.upload_time_restrict_unauth') / 60;

                    if($request->ajax()) return alert_messages(__('Please wait') . ', ' . $mins . ' ' . __('minutes before making another upload'),'error');
                    return redirect()->back()->withErrors(__('Please wait') . ', ' . $mins . ' ' . __('minutes before making another upload'))->withInput();
                }
            }
        }

        $book             = new Book();
        $book->title      = $request->title;
        $book->author_name      = $request->author_name;
        $book->slug       = str_random(6);
        $book->ip_address = request()->ip();
        if (!empty($request->title) && strlen(str_slug($request->title)) > 5) {
            $book->slug = str_slug($request->title . '-' . str_random(3));
        }

        $allowed_tags = explode(',', config('settings.book_overview_allowed_tags'));
        array_walk($allowed_tags, function(&$item) { $item = '<'.trim($item).'>'; });
        $allowed_tags = implode('', $allowed_tags);    
        $book->overview    = strip_tags($request->overview,$allowed_tags);

        $book->tags        = $request->tags;
        $book->category_id = $request->category_id;
        $book->active = (config('settings.book_auto_approve') == 0)?0:1;

        if (!empty($request->password)) {
            $book->password = \Hash::make($request->password);
        }

        if($request->storage == 'upload')
        {
            if ($request->hasFile('ebook')) {
                $destinationPath = 'uploads/books/' . date('Y') . '/' . date('m') . '/' . date('d');
                if (\Auth::check()) {
                    $destinationPath = 'uploads/books/' . \Auth::user()->name . '/' . date('Y') . '/' . date('m') . '/' . date('d');
                }

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $random    = $book->slug;
                $file      = $request->file('ebook');
                $file_size = $request->file('ebook')->getSize();
                $file_ext  = $file->getClientOriginalExtension();
                $file_name = $random . '.' . $file_ext;

                \Storage::disk(config('settings.ebook_storage'))->putFileAs($destinationPath, $file, $file_name);
                $book->storage = config('settings.ebook_storage');

                $book->file      = '/' . $destinationPath . '/' . $file_name;
                $book->file_size = $file_size;
                $book->file_type = $file_ext;
            }
        }
        elseif ($request->storage == 'google_drive_link') {
            $book->file = $request->google_drive_link;
            $book->storage = 'google_drive_link';
        }
        elseif ($request->storage == 'external_link') {
            $book->file = $request->external_link;
            $book->storage = 'external_link';
            $file_ext = explode('.', $request->external_link);
            $file_ext = end($file_ext);
            $book->file_type = $file_ext;
        }
        else{
            $book->file = $request->embed_code;
            $book->storage = 'embed_code';
        }

        if ($request->hasFile('thumbnail')) {
            $destinationPath = 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $random                 = str_random(6);
            $thumbnail              = $request->file('thumbnail');
            $file_ext               = $thumbnail->getClientOriginalExtension();
            $thumbnail_name         = $random . '.' . $file_ext;
            $resized_thumbnail_name = $random . '_258x387.' . $file_ext;

            $thumbnail->move($destinationPath, $thumbnail_name);
            $original_thumbnail = $destinationPath . '/' . $thumbnail_name;

            \Image::make($original_thumbnail)->fit(258, 387)->save($destinationPath . '/' . $resized_thumbnail_name);

            $book->thumbnail = '/' . $destinationPath . '/' . $resized_thumbnail_name;
            unlink($original_thumbnail);
        }

        if (\Auth::check()) {
            $book->user_id = \Auth::user()->id;
        }

        $book->status = $request->status;
        $book->save();

        if(config('settings.book_auto_approve') == 0)
        {
            $success_message = __('You successfully submitted eBook for administrator approval');            
            $redirectTo = route('upload');
        }
        else{
            $success_message = __('You successfully uploaded an eBook');
            if($request->ajax()) $success_message .= ' '.'<a href="'.$book->url.'">'.__('Check Now').'</a>';
            $redirectTo = $book->url;
        }
        if($request->ajax()) return alert_messages($success_message);

        return redirect($redirectTo)->withSuccess($success_message);
    }

    public function myBooks()
    {
        $books     = Book::with('user')->where('user_id', \Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(config('settings.books_per_page'));
        $favorites = [];
        if (\Auth::check()) {
            $favorites = Favorite::where('user_id', \Auth::user()->id)->whereHas('book', function ($query) {
                $query->where(function ($q) {
                    $q->orWhereNull('user_id');
                    $q->orWhereHas('user', function ($user) {
                        $user->whereIn('status', [0, 1]);
                    });
                });
            })->pluck('book_id')->toArray();
        }
        return view('front.books.my_books', compact('books', 'favorites'))->with('page_title', __('My eBooks'));
    }

    public function edit($slug, Request $request)
    {
        $book = Book::where('slug', $slug)->where('user_id', \Auth::user()->id)->firstOrfail();

        return view('front.books.edit', compact('book'))->with('page_title', __('Edit eBook'));
    }

    public function update($slug, Request $request)
    {
        $book      = Book::where('slug', $slug)->where('user_id', \Auth::user()->id)->firstOrfail();
        $validator = Validator::make($request->all(), [
            'title'       => 'nullable|eco_string|max:150',
            'author_name'                => 'nullable|eco_string|max:30',            
            'category_id' => 'required|numeric|exists:categories,id',
            'overview'    => 'nullable|max:5000',
            'tags'        => 'nullable|eco_tags|max:255',
            'password'    => 'nullable|string|max:30',
            'thumbnail'   => 'nullable|mimes:jpg,jpeg,png|max:' . config('settings.max_thumbnail_upload_size') * 1024,
            'status'      => 'required|numeric|in:1,2,3',
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages($validator->errors()->all(),'error');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $book->title       = $request->title;
        $book->author_name       = $request->author_name;

        $allowed_tags = explode(',', config('settings.book_overview_allowed_tags'));
        array_walk($allowed_tags, function(&$item) { $item = '<'.trim($item).'>'; });
        $allowed_tags = implode('', $allowed_tags);    
        $book->overview    = strip_tags($request->overview,$allowed_tags);

        $book->tags        = $request->tags;
        $book->category_id = $request->category_id;

        if (!empty($request->password)) {
            $book->password = \Hash::make($request->password);
        }

        if ($request->hasFile('thumbnail')) {
            $destinationPath = 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            if (!empty($book->thumbnail)) {
                if (starts_with($book->thumbnail, '/uploads') && file_exists(ltrim($book->thumbnail, '/'))) {
                    unlink(ltrim($book->thumbnail, '/'));
                }

            }

            $random                 = str_random(6);
            $thumbnail              = $request->file('thumbnail');
            $file_ext               = $thumbnail->getClientOriginalExtension();
            $thumbnail_name         = $random . '.' . $file_ext;
            $resized_thumbnail_name = $random . '_258x387.' . $file_ext;

            $thumbnail->move($destinationPath, $thumbnail_name);
            $original_thumbnail = $destinationPath . '/' . $thumbnail_name;

            \Image::make($original_thumbnail)->fit(258, 387)->save($destinationPath . '/' . $resized_thumbnail_name);

            $book->thumbnail = '/' . $destinationPath . '/' . $resized_thumbnail_name;
            unlink($original_thumbnail);
        }

        if (\Auth::check()) {
            $book->user_id = \Auth::user()->id;
        }

        $book->status = $request->status;
        $book->save();

        if($request->ajax()) return alert_messages(__('You successfully updated an eBook'));
        return redirect($book->url)->withSuccess(__('You successfully updated an eBook'))->with('page_title', $book->title);
    }

    public function getBook(Request $request)
    {
        $book = Book::where('slug', $request->slug)->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->firstOrfail();
        if ($book->status == 3) {
            if (\Auth::check()) {
                if ($book->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        $book->file = $book->file_f;

        if(in_array($book->storage, ['google_drive_link','embed_code'])){
            $book->file = $book->file_f;
        }
        elseif (ends_with($book->file, '.pdf') && $book->storage == 'uploads') {                        
            $book->file = url('pdf/' . $book->slug);
            if (!empty($book->password)) $book->file .= '?key='.encrypt($request->password);
        } elseif (ends_with($book->file, '.epub')) {
            $book->file = url('epub/' . $book->slug);
            if (!empty($book->password)) $book->file .= '?key='.encrypt($request->password);
        } elseif (ends_with($book->file, '.mp3') || ends_with($book->file, '.wav')) {
            $book->file = url('audio/' . $book->slug);
            if (!empty($book->password)) $book->file .= '?key='.encrypt($request->password);
        } else {
            $book->file = 'https://docs.google.com/gview?embedded=true&url=' . $book->file;
        }

        if (!empty($book->password)) {
            if (password_verify($request->password, $book->password)) {
                $response = ["status" => "success", "file" => $book->file];
            } else {
                $message  = alert_messages(__('Please enter valid password'), 'error');
                $response = ["status" => "error", "message" => $message];
            }
        } else {
            $response = ["status" => "success", "file" => $book->file];
        }

        return response()->json($response);
    }

    public function destroy($slug)
    {
        $book = Book::where('slug', $slug)->where('user_id', \Auth::user()->id)->firstOrfail();

        $book->delete();
        return redirect(route('my_books'))->withSuccess(__('Successfully deleted'));
    }

    public function epub($slug, Request $request)
    {
        $book = Book::where('slug', $slug)->where('active',1)->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->firstOrfail();

        if (!ends_with($book->file, '.epub')) {
            abort(404);
        }        

        if (!empty($book->password)) {

            try{
                $password = decrypt($request->key);
            }
            catch(\Exception $e){
                die($e->getMessage());
            }

            if (!password_verify($password, $book->password)) {
                abort(404);
            }
        }

        $book->file = $book->file_f;

        return view('front.books.epub', compact('book'));
    }

    public function audio($slug,Request $request)
    {
        $book = Book::where('slug', $slug)->where('active',1)->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->firstOrfail();

        if (!ends_with($book->file, '.mp3') && !ends_with($book->file, '.wav')) {
            abort(404);
        }

        if (!empty($book->password)) {

            try{
                $password = decrypt($request->key);
            }
            catch(\Exception $e){
                die($e->getMessage());
            }

            if (!password_verify($password, $book->password)) {
                abort(404);
            }
        }

        $book->file = $book->file_f;

        $book->padding = (!strpos(url()->previous(), 'embed')) ? 1 : 0;

        return view('front.books.audio', compact('book'));
    }


    public function pdf($slug,Request $request)
    {
        $book = Book::where('slug', $slug)->where('active',1)->whereNotIn('storage',['google_drive_link','embed_code'])->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->firstOrfail();

        if (!empty($book->password)) {

            try{
                $password = decrypt($request->key);
            }
            catch(\Exception $e){
                die($e->getMessage());
            }

            if (!password_verify($password, $book->password)) {
                abort(404);
            }
        }

        $book->file = url('vendor/pdfjs-dist/web/viewer.html?file=') . $book->file_f;

        return view('front.books.pdf', compact('book'));
    }    
}
