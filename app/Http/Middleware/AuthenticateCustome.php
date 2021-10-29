<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateCustome
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
        if(session('user_data') && is_array(session('user_data')) && count(session('user_data'))){
            return $next($request);
        }
        return redirect('/');
    }
}
