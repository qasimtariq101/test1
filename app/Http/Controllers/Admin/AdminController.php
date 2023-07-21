<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Book;
use App\Models\Category;
use App\User;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories_active   = Category::where('active', 1)->count();
        $categories_inactive = Category::where('active', 0)->count();

        $pages_active   = Page::where('active', 1)->count();
        $pages_inactive = Page::where('active', 0)->count();

        $books_public   = Book::where('status', 1)->count();
        $books_unlisted = Book::where('status', 2)->count();
        $books_private  = Book::where('status', 3)->count();

        $user_active   = User::where('status', 1)->count();
        $user_inactive = User::where('status', 0)->count();
        $user_banned   = User::where('status', 2)->count();

        $users = User::orderBy('created_at', 'DESC')->limit(6)->get(['id', 'name', 'created_at', 'avatar']);

        return view('admin.dashboard.index', compact('categories_active', 'categories_inactive', 'books_public', 'books_unlisted', 'books_private', 'user_active', 'user_inactive', 'user_banned', 'pages_inactive', 'pages_active', 'users'))->with('page_title', __('Dashboard'));
    }

    public function showLogin()
    {
        if (\Auth::check()) {
            if (\Auth::user()->role == 1) {
                return redirect('admin/dashboard');
            } else {
                return redirect('/');
            }

        }
        return view('admin.auth.login')->with('page_title', __('Admin Login'));
    }
}
