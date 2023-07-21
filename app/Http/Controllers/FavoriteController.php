<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Validator;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorite_books = Favorite::where('user_id',\Auth::user()->id)
        ->whereHas('book',function($query){
            $query->where(function ($q) {
                        $q->whereHas('user', function ($user) {                            
                            $user->whereIn('status', [0, 1]);
                        });
                    });            
        })
        ->orderBy('created_at','DESC')->paginate(config('settings.books_per_page'));
        $favorites = Favorite::where('user_id', \Auth::user()->id)->pluck('book_id')->toArray();
        return view('front.books.favorites', compact('favorite_books','favorites'))->with('page_title', __('Favorite Books'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pid' => 'required|numeric|exists:books,id',
        ]);
        if ($validator->fails()) {
            echo 'error';
        } else {

            $favorite = Favorite::where('user_id', \Auth::user()->id)->where('book_id', $request->pid)->first();
            if (empty($favorite)) {
                $favorite          = new Favorite();
                $favorite->book_id = $request->pid;
                $favorite->user_id = \Auth::user()->id;
                $favorite->save();
                echo 'added';
            } else {
                $favorite->delete();
                echo 'removed';
            }

        }
    }

}
