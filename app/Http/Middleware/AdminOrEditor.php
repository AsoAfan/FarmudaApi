<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrEditor
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

//        dd(auth()->check());
        if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'editor'))
            return $next($request);

        abort(403, 'Unauthorized');
    }
}
