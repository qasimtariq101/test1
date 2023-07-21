<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\Page;
use App\Models\Book;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Mail;
// use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;


class ApiController extends Controller
{
    public function login(Request $request)
    {
        $creds = $request->only(['email', 'password']);
        if (!$token =  auth()->attempt($creds)) {
            return response()->json(['error'=>'Incorrect email/password'], 401);
        }
        $user = User::where('email', $request->email)->first();
        return response()->json(['user'=>$user, 'status' => true], 200);
    }

    public function register(Request $request)
    {
        if (User::where('email', $request->email)->exists()) {
            return response()->json(
                ['message' => 'Email already exists.', 'status' => false],
                404
            );
        }
        $user = User::create(['name' => $request->name,
         'email' => $request->email,
         'password' => Hash::make($request->password),
         'status' => 1,
         'role' => $request->role]);
        return response()->json(['user' => $user, 'status' => true], 200);
    }
    
    public function social_login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json(['message' => 'User login successfully.', 'user'=>$user, 'status' => true], 200);
        }
        $user = User::create(['name' => $request->name,
         'email' => $request->email,
         'password' => Hash::make('123456789'),
         'status' => 1,
         'role' => 2]);
        return response()->json(['message' => 'User created successfully.', 'user' => $user, 'status' => true], 200);
    }

    public function forgot(Request $request)
    {
        $find_user = User::where('email', $request->email)->first();
        if (!$find_user) {
            return response()->json(
                ['message' => 'User not found.', 'status' => false],
                404
            );
        }
        $pin = rand(99999, 999999);
        $request->merge([
            'pin' => $pin, 'name' => $find_user->name
        ]);
        try {
            $a =  $request->email;
            Mail::send('emails.reset_password', ['request' => $request], function ($m) use ($a) {
                $m->to($a)->subject(config('settings.site_name') . ' - ' . __('Reset Password Notification'));
            });
            return response()->json(['message'=>'Pin code has been on your email. Please check.','pin'=>$pin, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(
                ['message'=> 'Your pin code was not sent due to invalid mail configuration', 'error' => $e->getMessage(), 'status' => false],
                404
            );
        }
        // $user = User::findOrfail($find_user->id);
        // $user->password = \Hash::make($password);
        // $user->save();
        // return response()->json(['password'=>$pin, 'message' => 'Pin code has been on your email. Please check.', 'status' => true], 200);
    }

    public function update_password(Request $request)
    {
        $find_user = User::where('email', $request->email)->first();
        if (!$find_user) {
            return response()->json(
                ['message' => 'User not found.', 'status' => false],
                404
            );
        }
        $user = User::findOrfail($find_user->id);
        $user->password = \Hash::make($request->password);
        $user->save();
        return response()->json(['user'=>$find_user, 'message' => 'You password has been changed successfully.', 'status' => true], 200);
    }

    public function contact(Request $request)
    {
        // $check = $this->authuser();
        // if(!$check){
        //     return response()->json(
        //         ['message'=> 'Token is invalid', 'status' => false],
        //         404
        //     );
        // }
        try {
            Mail::send('emails.contact', ['request' => $request], function ($m) {
                $m->to(config('settings.site_email'))->subject(config('settings.site_name') . ' App - ' . __('Contact Message'));
            });
            return response()->json(['message'=>'Our team will contact with you soon.', 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(
                ['message'=> 'Your message was not sent due to invalid mail configuration', 'error' => $e->getMessage(), 'status' => false],
                404
            );
        }
    }

    public function pages(Request $request)
    {
        $page_content = \DB::table('pages')->where('slug', $request->page)->first();
        if (!$page_content) {
            return response()->json(
                ['message' => 'Page not found.', 'status' => false],
                404
            );
        }
        return response()->json(['page_content'=>$page_content, 'status' => true], 200);
    }

    public function categories(Request $request)
    {
        $category;
        if (isset($request->page) && $request->page > 0) {
            $page = $request->page - 1;
            $category = Category::where('active', 1)->where('parent_id', null)->skip(($page * 10))->take(10)->orderBy('id', 'ASC')->get();
        } else {
            $category = Category::where('active', 1)->where('parent_id', null)->orderBy('id', 'ASC')->get();
        }
        if (!$category || count($category) < 1) {
            return response()->json(
                ['message' => 'No Category found.', 'status' => false],
                404
            );
        }
        foreach ($category as $key => $value) {
            $category[$key]['sub_category'] = Category::where('active', 1)->where('parent_id', $value->id)->orderBy('slug', 'ASC')->get();
        }
        return response()->json(['category'=>$category, 'status' => true], 200);
    }

    public function category_by_id(Request $request)
    {
        $category = Category::where('active', 1)->where('id', $request->id)->orderBy('slug', 'ASC')->get();
        if (!$category || count($category) < 1) {
            return response()->json(
                ['message' => 'No Category found.', 'status' => false],
                404
            );
        }
        foreach ($category as $key => $value) {
            $category[$key]['sub_category'] = Category::where('active', 1)->where('parent_id', $value->id)->orderBy('slug', 'ASC')->get();
        }
        return response()->json(['category'=>$category, 'status' => true], 200);
    }

    public function books_by_cat_id(Request $request)
    {
        $page = (isset($request->page) && $request->page) ? ($request->page -1) : 0 ;
        $category = Category::where('active', 1)->where('id', $request->category_id)->orderBy('slug', 'ASC')->first();
        $sub_category = Category::where('active', 1)->where('parent_id', $request->category_id)->pluck('id');
        if ((!$category || count($category) < 1) && (!$sub_category || count($sub_category) < 1)) {
            return response()->json(
                ['message' => 'No Category found.', 'status' => false],
                404
            );
        }
        $sub_category[] = (int)$request->category_id;
        $total_books = Book::where('status', 1)->where('active', 1)->whereIn('category_id', $sub_category)->count();
        $book = Book::where('status', 1)->where('active', 1)->whereIn('category_id', $sub_category)->with('user')->orderBy('created_at', 'desc')->skip(($page * 10))->take(10)->get();
        return response()->json(['category'=>$category,'sub_category'=>$sub_category, 'books' => $book, 'total_books' => $total_books, 'status' => true], 200);
    }
    
    public function top_trending(Request $request)
    {
        $category_ids = Book::where('status', 1)->where('active', 1)->distinct()->orderByRaw('rand()')->limit(config('settings.featured_books_limit'))->pluck('category_id');
        $categories = Category::whereIn('id', $category_ids)->orderBy('slug', 'ASC')->get();
        $authors = Book::where('status', 1)->where('active', 1)->where('author_name','!=','null' )->distinct()->orderByRaw('rand()')->limit(config('settings.featured_books_limit'))->pluck('author_name');
        $featured_books = Book::with('user')->where('status', 1)->where('active', 1)->whereHas('active_category', function ($query) {
            $query->whereHas('parent', function ($query) {
                $query->where('active', 1);
            })->orWhereNull('parent_id');
        })->where('featured', 1)->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->orderBy('created_at','DESC')->limit(config('settings.featured_books_limit'))->get();

        $books = Book::with('user')->where('status', 1)->where('active', 1)->whereHas('active_category', function ($query) {
            $query->whereHas('parent', function ($query) {
                $query->where('active', 1);
            })->orWhereNull('parent_id');
        })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->orderBy('created_at','DESC')->limit(config('settings.new_books_limit'))->get();

        $popular_books = Book::with('user')->where('status', 1)->where('active', 1)->whereHas('active_category', function ($query) {
            $query->whereHas('parent', function ($query) {
                $query->where('active', 1);
            })->orWhereNull('parent_id');
        })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->orderBy('views','DESC')->limit(config('settings.featured_books_limit'))->get();

        return response()->json(['categories' => $categories, 'featured_books' => $featured_books,'popular_books' => $popular_books, 'books' => $books, 'authors' => $authors, 'status' => true, 'message' => "Top books"], 200);
    }

    public function books(Request $request)
    {
        $books = array();
        $all_count = 0;
        $page = (isset($request->page) && $request->page) ? ($request->page -1) : 0 ;
        if ($request->type == 'featured') {
            $all_count = Book::with('user')->where('status', 1)->where('active', 1)->whereHas('active_category', function ($query) {
                $query->whereHas('parent', function ($query) {
                    $query->where('active', 1);
                })->orWhereNull('parent_id');
            })->where('featured', 1)->where(function ($query) {
                $query->orWhereNull('user_id');
                $query->orWhereHas('user', function ($user) {
                    $user->whereIn('status', [0, 1]);
                });
            })->count();
            $books = Book::with('user')->where('status', 1)->where('active', 1)->whereHas('active_category', function ($query) {
                $query->whereHas('parent', function ($query) {
                    $query->where('active', 1);
                })->orWhereNull('parent_id');
            })->where('featured', 1)->where(function ($query) {
                $query->orWhereNull('user_id');
                $query->orWhereHas('user', function ($user) {
                    $user->whereIn('status', [0, 1]);
                });
            })->orderBy('created_at','DESC')->skip(($page * 10))->take(10)->get();
        }
        if ($request->type == 'new_books') {
            $all_count = Book::with('user')->where('status', 1)->where('active', 1)->whereHas('active_category', function ($query) {
                $query->whereHas('parent', function ($query) {
                    $query->where('active', 1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
                $query->orWhereNull('user_id');
                $query->orWhereHas('user', function ($user) {
                    $user->whereIn('status', [0, 1]);
                });
            })->count();
            $books = Book::with('user')->where('status', 1)->where('active', 1)->whereHas('active_category', function ($query) {
                $query->whereHas('parent', function ($query) {
                    $query->where('active', 1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
                $query->orWhereNull('user_id');
                $query->orWhereHas('user', function ($user) {
                    $user->whereIn('status', [0, 1]);
                });
            })->orderBy('created_at','DESC')->skip(($page * 10))->take(10)->get();
        }
        if ($request->type == 'popular_books') {
            $all_count = Book::with('user')->where('status', 1)->where('active', 1)->whereHas('active_category', function ($query) {
                $query->whereHas('parent', function ($query) {
                    $query->where('active', 1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
                $query->orWhereNull('user_id');
                $query->orWhereHas('user', function ($user) {
                    $user->whereIn('status', [0, 1]);
                });
            })->count();
            $books = Book::with('user')->where('status', 1)->where('active', 1)->whereHas('active_category', function ($query) {
                $query->whereHas('parent', function ($query) {
                    $query->where('active', 1);
                })->orWhereNull('parent_id');
            })->where(function ($query) {
                $query->orWhereNull('user_id');
                $query->orWhereHas('user', function ($user) {
                    $user->whereIn('status', [0, 1]);
                });
            })->orderBy('views', 'desc')->skip(($page * 10))->take(10)->get();
        }
        
        if ($request->type == 'related_books') {
            $all_count = Book::where('status', 1)->where('active',1)->whereHas('category', function ($query) use ($request) {
                $query->where('id', $request->category_id);
                $query->where('active', 1);
            })->count();
        
          
            $books = Book::with('user')->where('status', 1)->where('active',1)->whereHas('category', function ($query) use ($request) {
                $query->where('id', $request->category_id);
                $query->where('active', 1);
            })->orderBy('views', 'desc')->skip(($page * 10))->take(10)->get();
        }

        if ($request->type == 'authors') {
            $all_count = Book::where('status', 1)->where('active', 1)->where('author_name', $request->author_name)->orderBy('created_at','desc')->count();
            $books = Book::where('status', 1)->where('active', 1)->where('author_name', $request->author_name)->orderBy('created_at','desc')->skip(($page * 10))->take(10)->get();
        }

        if ($request->type == 'search') {
            $all_count = Book::where('status', 1)->where('active', 1)
                        ->where(function($query) use($request) {
                            $query->where('title','like','%'.$request->search_query.'%')
                                  ->orWhere('author_name','like','%'.$request->search_query.'%')
                                  ->orWhere('overview','like','%'.$request->search_query.'%')
                                  ->orWhere('slug','like','%'.$request->search_query.'%')
                                  ->orWhere('tags','like','%'.$request->search_query.'%');
                        })->orderBy('created_at','desc')->count();
        
            $books = Book::where('status', 1)->where('active', 1)
                        ->where(function($query) use($request) {
                            $query->where('title','like','%'.$request->search_query.'%')
                                  ->orWhere('author_name','like','%'.$request->search_query.'%')
                                  ->orWhere('overview','like','%'.$request->search_query.'%')
                                  ->orWhere('slug','like','%'.$request->search_query.'%')
                                  ->orWhere('tags','like','%'.$request->search_query.'%');
                        })->orderBy('created_at','desc')->skip(($page * 10))->take(10)->get();
        }

        if ($books && count($books) > 0) {
            return response()->json(['books' => $books, 'all_count'=> $all_count, 'status' => true, 'message' => "Books List"], 200);
        }
        return response()->json(
            ['message' => 'No book found.', 'status' => false],
            404
        );
    }

    public function book_detail(Request $request)
    {
        // $book = Book::with('user')->where('id', $request->book_id)->first();
        $book = Book::withCount('ratings')->with('user')->where('id', $request->book_id)->where('active',1)->whereHas('active_category',function($query){
                $query->whereHas('parent',function($query){
                    $query->where('active',1);
                })->orWhereNull('parent_id');
        })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->firstOrfail();
        if (!$book || count($book) < 1) {
            return response()->json(
                ['message' => 'No book found.', 'status' => false],
                404
            );
        }
        $related_books = Book::where('status', 1)->where('active',1)->where('id', '!=', $request->book_id)->whereHas('category', function ($query) use ($book) {
            $query->where('id', $book->category_id);
            $query->where('active', 1);
        })->orderBy('created_at','desc')->limit(6)->get();
        return response()->json(['book' => $book, 'related_books' => $related_books, 'status' => true, 'message' => "Top books"], 200);
    }

    public function author_listing()
    {
        $authors = Book::where('status', 1)->where('active', 1)->where('author_name','!=','null' )->distinct()->orderBy('author_name', 'asc')->pluck('author_name');
        if (!$authors || count($authors) < 1) {
            return response()->json(
                ['message' => 'No author found.', 'status' => false],
                404
            );
        }
        return response()->json(['authors' => $authors, 'status' => true, 'message' => "Top books"], 200);
    }

    public function rate_now(Request $request)
    {
        $book = Book::where('id', $request->book_id)->where('status', 1)->where('active',1)->whereHas('active_category',function($query){
            $query->whereHas('parent',function($query){
                $query->where('active',1);
            })->orWhereNull('parent_id');
        })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->first();
        if (!$book) {
            return response()->json(['message'=>'Please try again late.', 'status' => false], 404);
        }
        $rating = Rating::where('user_id', $request->user_id)->where('book_id', $request->book_id)->first();
        if (!empty($rating)) {
            $rating->rate = $request->rate;
            $rating->save();
            $average = Rating::where('book_id', $request->book_id)->avg('rate');
            $average = round($average, 2);
            $book->average_rating = $average;
            $book->save();
            return response()->json(['message'=>'Rating successfully upated.', 'status' => true], 200);
        } else {
            $rating = new Rating();
            $rating->user_id = $request->user_id;
            $rating->book_id = $request->book_id;
            $rating->rate    = $request->rate;
            $rating->save();
            $average = Rating::where('book_id', $request->book_id)->avg('rate');
            $average = round($average, 2);
            $book->average_rating = $average;
            $book->save();
            return response()->json(['message'=>'Rating successfully added.', 'status' => true], 200);
        }
    }
}
