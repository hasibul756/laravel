<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImportDirectly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$args): Response
    {
        // Access the dynamic route parameter (e.g., 'id') directly from the request
        $id = $request->route('id'); // Extract 'id' from route parameters
        echo "Student ID from Route: $id<br>";

        // Proceed with the next middleware or request handler
        return $next($request);
    }
}
