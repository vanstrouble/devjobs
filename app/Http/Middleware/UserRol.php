<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserRol
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
        if($request->user()->rol === 1) {
            // If not rol 2, redirect to home page
            return redirect()->route('home');
        }
        return $next($request);
    }
}
