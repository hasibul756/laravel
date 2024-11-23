<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CountryCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        echo "Country Check Middleware";

        if($request->country != 'india') {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied. Country restriction applies.',
            ], 403);
        }

        return $next($request);
    }
}
