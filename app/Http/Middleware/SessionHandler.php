<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class SessionHandler
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
        if(!Auth::check() || ( (Auth::check()) && (\App\Membros::where('user_id', \Auth::user()->id)->count() == 0))){
            $request->session()->forget('igreja_id');
        }else if ((Auth::check()) && !$request->session()->has('igreja_id') && (\App\Membros::where('user_id', \Auth::user()->id)->count() >= 1)) {
            $request->session()->put('igreja_id', \App\Membros::where('user_id', \Auth::user()->id)->orderBy('created_at')->limit(1)->pluck('igreja_id')[0]);
        }
        return $next($request);
    }
}
