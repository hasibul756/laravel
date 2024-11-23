<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgeCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        echo "Age Check Middleware";

        // Check if the age is less than 18.
        if ($request->age < 18) {
            // Return a JSON response with a 403 status code for restricted access.
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied. Age restriction applies.',
            ], 403);
        }

        // If age is valid, pass the request to the next middleware or controller.
        return $next($request);
    }
}
