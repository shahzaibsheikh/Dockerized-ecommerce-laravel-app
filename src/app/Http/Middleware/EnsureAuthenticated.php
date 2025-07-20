<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // var_dump(auth()->user()->role_id);
        // var_dump(User::ADMIN_ROLE);
        // die();
        if(!Auth::check()){
            return redirect()->route('login');
        }
       if(auth()->user()->role_id !== User::ADMIN_ROLE)
       {
        return redirect()->route('index-home');
       }
        return $next($request);
    }
}
