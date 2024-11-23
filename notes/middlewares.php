<?php

/**
 * Laravel 11 Middleware Overview
 * Middleware functions are executed before or after a request reaches the controller.
 * It is used for tasks such as:
 * - Authentication
 * - Authorization
 * - Logging
 * - Request Filtering
 */

// =======================================================================
// Middleware Types in Laravel 11
// =======================================================================
/**
 * 1. Global Middleware:
 *    Automatically applied to every request in the application.
 * 
 * 2. Route Middleware:
 *    Manually applied to specific routes or groups of routes.
 * 
 * 3. Group Middleware:
 *    Applied to a group of routes for shared behavior.
 * 
 * 4. Closure Middleware:
 *    Defined inline with routes for ad hoc requirements.
 */

// =======================================================================
// Creating Middleware
// =======================================================================
/**
 * Generate middleware using Artisan:
 * Command: php artisan make:middleware MiddlewareName
 * Command (with constructor): php artisan make:middleware -c MiddlewareName
 */

// =======================================================================
// Registering Middleware
// =======================================================================
/**
 * Global Middleware:
 * Register in bootstrap/app.php under the withMiddleware function:
 */
    // Register middleware globally
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(AgeCheck::class); // Append AgeCheck middleware globally
    })

// =======================================================================
// Applying Middleware
// =======================================================================

/**
 * Apply Middleware to a Route:
 */
Route::middleware('example.middleware')->get('/route', function () {
    return "Route protected by middleware.";
});

/**
 * Apply Middleware to a Group of Routes:
 */
Route::middleware(['example.middleware'])->group(function () {
    Route::get('/route1', function () {
        return "Route 1 protected by middleware.";
    });
    Route::get('/route2', function () {
        return "Route 2 protected by middleware.";
    });
});

/**
 * Apply Middleware to a Closure Route:
 */
Route::middleware('example.middleware')->get('/closure', function () {
    return "Closure route protected by middleware.";
});

// =======================================================================
// Example: Age Restriction Middleware
// =======================================================================

/**
 * Middleware Example: Restrict access for users under 18.
 */

// Step 1: Create Middleware
// Command: php artisan make:middleware AgeCheck

// Step 2: Middleware Logic (Laravel 11 Example)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgeCheck
{
    /**
     * Handle an incoming request.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Debugging request data (optional)
        info("Middleware executed with request data: ", $request->all());

        // Middleware logic
        if ($request->age < 18) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied. Age restriction applies.',
            ], 403); // Return 403 Forbidden
        }

        // Allow request to proceed to the next middleware/controller
        return $next($request);
    }
}

// Step 3: Register Middleware in bootstrap/app.php
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(AgeCheck::class); // Append AgeCheck middleware globally
    })

// Step 4: Apply Middleware to a Route
Route::middleware('age.check')->get('/restricted', function () {
    return "Welcome to the restricted page.";
});

// =======================================================================
// Advanced Middleware Features
// =======================================================================

/**
 * Dynamically Bind Middleware:
 * 
 * Middleware can be dynamically appended:
 */
app('router')->middleware(['example.middleware'])->group(function () {
    Route::get('/dynamic', function () {
        return "Dynamic middleware example.";
    });
});

/**
 * Middleware Methods:
 * 
 * - handle(Request $request, Closure $next): Executes middleware logic.
 * - terminate($request, $response): Executes after response is sent.
 */

// Example: Middleware with `terminate` Method
class ExampleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        // Perform any cleanup tasks or logging
        info('Response sent for request: ', $request->all());
    }
}

// =======================================================================
// Middleware Benefits
// =======================================================================

/**
 * 1. Centralized Logic:
 *    Reuse middleware for authentication, logging, or other common tasks.
 * 
 * 2. Modular Design:
 *    Apply middleware only where necessary for cleaner code.
 * 
 * 3. Scalability:
 *    Supports complex request pipelines in large applications.
 */