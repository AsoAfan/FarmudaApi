<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
{
//    dd('Admin middleware executed', Auth::user()); // Add this line for debugging

    if (Auth::check() && Auth::user()->role === 'admin') {
        return $next($request);
    }

    abort(403, 'Unauthorized');
}

}
