<?php

namespace App\Http\Middleware;

use Closure;

class Sidebar
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
        \Session::put('Current.url',str_replace(\URL::to('/'),'',\URL::current()));
        //dd(\Session::all());
        return $next($request);
    }

}
