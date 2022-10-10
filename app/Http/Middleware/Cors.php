<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
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
        return $next($request)
        ->header('Access-Control-Allow-Origin' , 'http://localhost:3000')
        ->header('Access-Control-Allow-Methods' , 'GET ,PUT ,OPTIONS ,DELETE ,POST , UPDATE')
        ->header('Access-Control-Allow-Headers' , 'Content-type, Accept, Authorization,Origin, x-requested-with,X-CSRF-TOKEN')
        ->header('Access-Control-Allow-credentials ' , 'true')
        ->header('Content-type' , 'application/json');


    }
}