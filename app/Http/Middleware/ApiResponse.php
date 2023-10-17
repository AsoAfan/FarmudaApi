<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->setContent(json_encode($response->getOriginalContent()));
        $response->header('Content-Type', 'application/json');


//        return $response;
        return response(['errors' => "Server on maintenance"], 400);
    }
}
