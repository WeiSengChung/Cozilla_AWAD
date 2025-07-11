<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;

class AdminMiddleware
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
        if (Gate::allows('isAdmin')) {
            return $next($request);
        }
        if(Gate::allows('isUser')) {
            return redirect('/homepage')->with('error', 'You are not authorized to access this page.');
        }
        return redirect('/login/admin')->with('error', 'You are not authorized to access this page.');
    }
}
