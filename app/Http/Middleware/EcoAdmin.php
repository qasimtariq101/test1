<?php

namespace App\Http\Middleware;

use Closure;

class EcoAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(strpos($request->url(), '/index.php')){
            return redirect(env('APP_URL'));
        }

        if(config('settings.maintenance_mode') == 1){
            session()->flash('warning',__('Site Under Maintenance'));
        }

        if (!\Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['message' => __('You must login to perform this action')], 401);
            } else {
                return redirect()->guest(route('login'));
            }
        }

        if ($request->user()->role != 1) {
            if ($request->ajax()) {
                return response()->json(['message' => __('Permission denied')], 401);
            } else {
                abort(403);
            }

        }

        return $next($request);
    }
}
