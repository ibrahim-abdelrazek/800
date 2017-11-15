<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPartner
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
        if (Auth::check()) {

            // if not superAdmin
            if(Auth::user()->user_group_id != 2 && Auth::user()->user_group_id != 1 ){

                return redirect('home');
            }
        }
        return $next($request);
    }
}
