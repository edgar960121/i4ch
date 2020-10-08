<?php

namespace App\Http\Middleware;

use Closure;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $needed = null)
    {
        
        $roles = explode('|',$needed);

        $validation = \Session::get('Session.modulos')->map(function($i){
            return collect($i['roles'])->map(function($i,$k){ return $k; })->values();
        })->flatten()->map(function($i) use($roles){
            return in_array($i,$roles);
        })->filter(function($i){
            return $i == true;
        })->count();

        if($validation > 0){
            return $next($request);
        }else{
            return \Redirect::to('/usuario/inicio');
        }
        
    }
}
