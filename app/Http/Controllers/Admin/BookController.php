<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Datatables;
use Illuminate\Http\Request;
use Validator;

class BookController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.books.index')->with('page_title', __('eBooks'));
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $books = Book::select();
            return Datatables::of($books)
                ->addColumn('check', function ($item) {
                    return '<input type="checkbox" class="check" name="check[]" value="' . $item->id . '">';
                })
                ->editColumn('title', function ($item) {
                    $color = ($item->active == 1)?'green-text':'purple-text';
                    return '<a class="'.$color.'" href="' . $item->url . '" target="_blank">' . $item->title_f . '</a>';
                })
                ->editColumn('views', function ($item) {
                    return $item->views_f;
                })
                ->editColumn('downloads', function ($item) {
                    return $item->downloads_f;
                })
                ->editColumn('category', function ($item) {
                    return (isset($item->category)) ? $item->category->name : '-';
                })
                ->addColumn('user', function ($item) {
                    return (isset($item->user)) ? '<a href="' . url('admin/users/' . $item->user->id . '/edit') . '" target="_blank">' . $item->user->name . '</a>' : __('Anonymous');
                })
                ->addColumn('status', function ($item) {
                    if ($item->status == 2) {
                        return '<span class="text-warning">' . __('Unlisted') . '</span>';
                    } elseif ($item->status == 1) {
                        return '<span class="text-success">' . __('Public') . '</span>';
                    } else {
                        return '<span class="text-danger">' . __('Private') . '</span>';
                    }

                })
                ->addColumn('password_protected', function ($item) {
                    if (!empty($item->password)) {
                        return '<i class="fa fa-lock text-danger"></i>';
                    } else {
                        return '-';
                    }

                })
                ->addColumn('action', function ($item) {
                    return '<a class="btn btn-sm btn-default" href="' . url('admin/books/' . $item->id . '/edit') . '"><i class="fa fa-edit"></i> ' . __('Edit') . '</a> <a class="btn btn-sm btn-danger eco_link" href="' . url('admin/books/' . $item->id . '/delete') . '"><i class="fa fa-trash"></i> ' . __('Delete') . '</a>';
                })
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.books.create')->with('page_title', __('eBooks'));
    }    

    public function createBulk()
    {
        return view('admin.books.create_bulk')->with('page_title', __('eBooks'));
    }

    public function edit($id)
    {
        $book = Book::findOrfail($id);
        return view('admin.books.edit', compact('book'))->with('page_title', 'eBooks');
    }

    public function store(Request $request)
    {
        if(config('settings.external_link_embed')) $storage_rule = 'required|in:upload,google_drive_link,external_link,embed_code';
        else $storage_rule = 'required|in:upload,google_drive_link'; 

        $validator = Validator::make($request->all(), [
            'storage'                => $storage_rule,         
            'title'       => 'nullable|eco_string|max:150',
            'author_name'                => 'nullable|eco_string|max:30',            
            'category_id' => 'required|numeric|exists:categories,id',
            'overview'    => 'nullable|max:5000',
			'seo_description'    => 'nullable|max:5000',
            'tags'        => 'nullable|eco_tags|max:255',
            'app_download_link' => 'nullable|eco_string|max:1000',
            'password'    => 'nullable|string|max:30',
            'embed_code'           => 'required_if:storage,==,embed_code|embed_code',
            'external_link'        => 'required_if:storage,==,external_link|external_link',
            'google_drive_link'    => 'required_if:storage,==,google_drive_link|google_drive_link',
            'ebook'                => 'required_if:storage,==,upload|mimes:' . config('settings.allowed_book_mimes') . '|max:' . config('settings.max_book_upload_size') * 1024,
            'thumbnail'   => 'nullable|mimes:jpg,jpeg,png|max:' . config('settings.max_thumbnail_upload_size') * 1024,
            'featured'    => 'required|numeric|in:0,1',
            'status'      => 'required|numeric|in:1,2,3',
            'active'      => 'required|numeric|in:1,0',
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages_admin($validator->errors()->all(),'error');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if($request->storage == 'embed' && !starts_with($request->link,'https://drive.google.com/file/d/') && !ends_with($request->link,'/preview')){
            if($request->ajax()) return alert_messages(__('Please enter valid Google drive embed link'),'error');
            return redirect()->back()->withErrors(__('Please enter valid Google drive embed link'))->withInput();            
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
		$book->seo_description    = strip_tags($request->seo_description,$allowed_tags);

        $book->tags        = $request->tags;
        $book->app_download_link        = $request->app_download_link;
        $book->category_id = $request->category_id;

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

        $book->user_id  = \Auth::user()->id;
        $book->status   = $request->status;
        $book->active   = $request->active;
        $book->featured = $request->featured;
        $book->save();

        if($request->ajax()) return alert_messages_admin(__('You successfully uploaded an eBook').'.'.'<a href="'.$book->url.'">'.__('Check Now').'</a>');
        return redirect()->back()->withSuccess(__('You successfully uploaded an eBook'));
    }

    public function update($id, Request $request)
    {
        $book      = Book::where('id', $id)->firstOrfail();
        $validator = Validator::make($request->all(), [
            'title'       => 'nullable|eco_string|max:150',
            'slug' => 'required|eco_string|max:150|unique:books,slug,' . $book->id,
            'author_name'                => 'nullable|eco_string|max:30',            
            'category_id' => 'required|numeric|exists:categories,id',
            'overview'    => 'nullable|max:5000',
			'seo_description'    => 'nullable|max:5000',
            'tags'        => 'nullable|eco_tags|max:255',
            'app_download_link' => 'nullable|eco_string|max:255',

            'password'    => 'nullable|string|max:30',
            'thumbnail'   => 'nullable|mimes:jpg,jpeg,png|max:' . config('settings.max_thumbnail_upload_size') * 1024,
            'featured'    => 'required|numeric|in:0,1',
            'status'      => 'required|numeric|in:1,2,3',
            'active'      => 'required|numeric|in:1,0',
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages_admin($validator->errors()->all(),'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $book->title       = $request->title;
        $book->slug = $request->slug;
        $book->author_name      = $request->author_name;            

        $allowed_tags = explode(',', config('settings.book_overview_allowed_tags'));
        array_walk($allowed_tags, function(&$item) { $item = '<'.trim($item).'>'; });
        $allowed_tags = implode('', $allowed_tags);    
        $book->overview    = strip_tags($request->overview,$allowed_tags);
		$book->seo_description    = strip_tags($request->seo_description,$allowed_tags);

        $book->tags        = $request->tags;
        $book->app_download_link = $request->app_download_link;
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

        $book->status   = $request->status;
        $book->active   = $request->active;
        $book->featured = $request->featured;

        $book->save();

        if($request->ajax()) return alert_messages_admin(__('You successfully updated an eBook'));
        return redirect()->back()->withSuccess(__('You successfully updated an eBook'));
    }

    public function destroy(Request $request)
    {
        $book = Book::where('id', $request->id)->firstOrfail();

        if($book->storage != 'embed')
        {
            if (\Storage::disk($book->storage)->exists($book->file)) {
                \Storage::disk($book->storage)->delete($book->file);
            }
        }

        if (file_exists(ltrim($book->thumbnail, '/'))) {
            unlink(ltrim($book->thumbnail, '/'));
        }

        $book->delete();
        if($request->ajax()) return alert_messages_admin(__('Successfully deleted'));
        return redirect()->back()->withSuccess(__('Successfully deleted'));
    }

    public function deleteSelected(Request $request)
    {
        if (!empty($request->ids)) {
            $books = Book::whereIn('id', $request->ids)->get();
            foreach ($books as $book) {

                if($book->storage != 'embed')
                {
                    if (\Storage::disk($book->storage)->exists($book->file)) {
                        \Storage::disk($book->storage)->delete($book->file);
                    }
                }

                if (file_exists(ltrim($book->thumbnail, '/'))) {
                    unlink(ltrim($book->thumbnail, '/'));
                }

                Book::where('id', $book->id)->delete();
            }
            return "success";
        } else {
            return "error";
        }
    }

    public function storeBulk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'nullable|eco_string|max:150',
            'author_name'                => 'nullable|eco_string|max:30',            
            'category_id' => 'required|numeric|exists:categories,id',
            'overview'    => 'nullable|max:5000',
			'seo_description'    => 'nullable|max:5000',
            'tags'        => 'nullable|eco_tags|max:255',
            'password'    => 'nullable|string|max:30',
            'ebooks.*'       => 'required|mimes:' . config('settings.allowed_book_mimes') . '|max:' . config('settings.max_book_upload_size') * 1024,
            'thumbnail'   => 'nullable|mimes:jpg,jpeg,png|max:' . config('settings.max_thumbnail_upload_size') * 1024,
            'featured'    => 'required|numeric|in:0,1',
            'status'      => 'required|numeric|in:1,2,3',
            'active'      => 'required|numeric|in:1,0',
        ]);
        if ($validator->fails()) {
            if($request->ajax()) return alert_messages_admin($validator->errors()->all(),'error');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        if (!$request->hasFile('ebooks')) {
            if($request->ajax()) return alert_messages_admin(__('Invalid files selected'),'error');
            return redirect()->back()->withErrors(__('Invalid files selected'));
        }

        $files = $request->file('ebooks');
        $files_count = 0;

        foreach($files as $file){
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
			$book->seo_description    = strip_tags($request->seo_description,$allowed_tags);

            $book->tags        = $request->tags;
            $book->category_id = $request->category_id;

            if (!empty($request->password)) {
                $book->password = \Hash::make($request->password);
            }

            if ($file) {
                $destinationPath = 'uploads/books/' . date('Y') . '/' . date('m') . '/' . date('d');
                if (\Auth::check()) {
                    $destinationPath = 'uploads/books/' . \Auth::user()->name . '/' . date('Y') . '/' . date('m') . '/' . date('d');
                }

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $random    = $book->slug;
                $file_size = $file->getSize();
                $file_ext  = $file->getClientOriginalExtension();
                $file_name = $random . '.' . $file_ext;

                \Storage::disk(config('settings.ebook_storage'))->putFileAs($destinationPath, $file, $file_name);
                $book->storage = config('settings.ebook_storage');

                $book->file      = '/' . $destinationPath . '/' . $file_name;
                $book->file_size = $file_size;
                $book->file_type = $file_ext;
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

            $book->user_id  = \Auth::user()->id;
            $book->status   = $request->status;
            $book->active   = $request->active;
            $book->featured = $request->featured;
            $book->save();

            $files_count++;

        }

        if($request->ajax()) return alert_messages_admin($files_count.' '.__('eBooks successfully uploaded'));
        return redirect()->back()->withSuccess($files_count.' '.__('eBooks successfully uploaded'));
    }    
}
