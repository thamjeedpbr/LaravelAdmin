<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

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
        if (Auth::check()) {
            if (Auth::guard('web')->user()->avatar == "user-icon.webp") {
                if (Auth::guard('web')->user()->disabled == "0") {
                    return $next($request);
                } else {
                    return redirect()->route('login')->with('error_message', 'User is inactive contact Adminstrator');
                }
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
