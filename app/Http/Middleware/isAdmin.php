<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user() == null){
            return redirect('home')->with('error',"PLease login.");
        }

        if(auth()->user()->is_admin == 1){
            return $next($request);
        }

        return redirect('home')->with('error',"You don't have admin access.");
    }
}
