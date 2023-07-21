<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (strpos(url()->previous(), 'admin')) {
            $this->redirectTo = 'admin/dashboard';
        }    

        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {       
        return view('auth.login')->with('page_title',__('Login'));
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $captcha = '';
        if(config('settings.captcha') == 1)
        {
            if(config('settings.captcha_type') == 1) $captcha = 'required|captcha';
            else $captcha = 'required|custom_captcha';
        }
        $request->validate([
            $this->username() => 'required|string|max:100|regex:/^[0-9A-Za-z.@-_]+$/',
            'password' => 'required|string',
            'g-recaptcha-response' => $captcha
        ]);
    }    

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $remember = false;
        if ($request->remember == 'on') {
            $remember = true;
        }

        $this->redirectTo = session('url.intended') ? session('url.intended') : $this->redirectTo;

        if (\Auth::attempt(["name" => $request->email, "password" => $request->password], $remember)) {

            // Authentication passed...
            return redirect($this->redirectTo)->withSuccess(__('You succesfully logged in'));
        } elseif (\Auth::attempt(["email" => $request->email, "password" => $request->password], $remember)) {

            // Authentication passed...
            return redirect($this->redirectTo)->withSuccess(__('You succesfully logged in'));
        } else {
            return redirect()->back()->withErrors(__('Invalid Username or Password'));
        }
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        session()->flash('success',__('You successfully logged out'));
    }
}