<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;
use Mail;
use Validator;

class PageController extends Controller
{

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('active', 1)->firstOrfail();

        $old_page = \DB::table('pages')->where('slug',$slug)->where('active',1)->first();

        $result = json_decode($old_page->content);

        if (json_last_error() !== 0) {
            
            $page->title = $old_page->title;
            $page->content = $old_page->content;
            $page->save();
        }

        $description = trim(preg_replace('/\s+/', ' ', $page->content));

        $page->description = str_limit($description, 200, '...');

        return view('front.page.show', compact('page'))->with('page_title', $page->title);
    }

    public function contact()
    {
        return view('front.page.contact')->with('page_title', __('Contact Us'));
    }

    public function contactPost(Request $request)
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
            'phone'                => 'nullable|eco_string|min:7|max:20',
            'g-recaptcha-response' => $captcha,
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {

            try {
            Mail::send('emails.contact', ['request' => $request], function ($m) use ($request) {
                $m->to(config('settings.site_email'))->subject(config('settings.site_name') . ' - ' . __('Contact Message'));
                $m->replyTo($request->email, $request->name); // Add this line to set the Reply-To header
            });
            } catch (\Exception $e) {
                \Log::info($e->getMessage());
                return redirect()->back()->with('warning', __('Your message was not sent due to invalid mail configuration'));
            }

            return redirect()->back()->with('success', __('Your message successfully sent'));
        }

    }

    public function sitemaps()
    {
        $first_product = Book::orderBy('created_at')->firstOrfail();

        $last_product = Book::orderBy('created_at','DESC')->firstOrfail();

        $start_date = $first_product->created_at->format('Y-m-d');
        $end_date = $last_product->created_at->format('Y-m-d');

        return response()->view('front.page.sitemaps',compact('start_date','end_date'))->header('Content-Type', 'text/xml');
    }


    public function sitemapMain()
    {
        $pages = Page::where('active', 1)->get(['slug']);

        $categories = Category::where('active', 1)->get(['slug']);
        return response()->view('front.page.sitemap_main', compact('pages', 'categories'))->header('Content-Type', 'text/xml');
    }

    public function sitemap($date)
    {
        $books = Book::where('status', 1)->where('active',1)->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })
        ->whereDate('created_at',$date)
        ->orderBy('created_at','DESC')->get(['id','slug']);

        $users = \App\User::where('status',1)->whereDate('created_at',$date)->orderBy('created_at','DESC')->get(['id','name','avatar','role','status','about','fb','tw','gp']);

        return response()->view('front.page.sitemap',compact('books','users'))->header('Content-Type', 'text/xml');
    }
    
    public function mycategories()
    {
        return view('front.page.mycategories')->with('page_title', __('Categories'));
    }
	
	public function textbooks()
    {
        return view('front.page.textbooks')->with('page_title', __('Text Books'));
    }
	
	public function punjabtextbooks()
    {
        return view('front.page.punjabtextbooks')->with('page_title', __('Punjab Text Books'));
    }
	
	public function sindhtextbooks()
    {
        return view('front.page.sindhtextbooks')->with('page_title', __('Sindh Text Books'));
    }
	
	public function balochistantextbooks()
    {
        return view('front.page.balochistantextbooks')->with('page_title', __('Balochistan Text Books'));
    }

}
