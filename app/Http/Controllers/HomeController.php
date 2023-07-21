<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
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
        

        $featured_books = Book::with('user')->where('status', 1)->where('active',1)->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->where('featured', 1)->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })
        ->orderBy('created_at', 'desc')->limit(config('settings.featured_books_limit'))->get();

        $books = Book::with('user')->where('status', 1)->where('active',1)->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })
        ->orderBy('created_at','DESC')->limit(config('settings.new_books_limit'))->get();

        $popular_books = Book::with('user')->where('status', 1)->where('active',1)->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })
        ->orderBy('views','DESC')->limit(config('settings.featured_books_limit'))->get();

        $slides = \App\Models\Slider::where('active',1)->get(['name','image']);

        $favorites = [];
        if (\Auth::check()) {
            $favorites = Favorite::where('user_id', \Auth::user()->id)->pluck('book_id')->toArray();
        }
        return view('front.home.index', compact('featured_books', 'popular_books','books', 'favorites','slides'))->with('page_title', __('Books, Notes & PDF Collection'));
    }
}
