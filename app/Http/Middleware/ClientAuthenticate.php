<?php

namespace App\Http\Middleware;

use App\Models\Client;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = 'client'){
       
        if(Auth::guard($guard)->user()){
            return $next($request);
        } else {
            return redirect(route('client.login'));
        }
    }
}
