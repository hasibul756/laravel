<?php

use Illuminate\Foundation\Application; // Laravel application instance
use Illuminate\Foundation\Configuration\Exceptions; // Exception handling
use Illuminate\Foundation\Configuration\Middleware; // Middleware configuration
use App\Http\Middleware\AgeCheck; // Custom middleware
use App\Http\Middleware\CountryCheck;

// Configure and create the Laravel application instance
return Application::configure(basePath: dirname(__DIR__)) // Set the base path
    // Configure routing paths
    ->withRouting(
        web: __DIR__ . '/../routes/web.php', // Path to web routes
        commands: __DIR__ . '/../routes/console.php', // Path to console commands
        health: '/up', // Health check endpoint
    )
    // Register middleware globally
    ->withMiddleware(function (Middleware $middleware) {
        // Append middleware globally (executed after all previously registered middlewares)
        // $middleware->append(CountryCheck::class);
        // $middleware->append(AgeCheck::class); 

        // Append middleware to a specific middleware group
        $middleware->appendToGroup('check1', [
            AgeCheck::class, // Checks user age (example)
            CountryCheck::class // Validates user country (example)
        ]);
        // Explanation:
        // `appendToGroup` adds specified middleware to the end of the middleware stack of a specific group.
        // The group here is 'check1', which should be defined elsewhere (e.g., in a route group).

        // Prepend middleware to a specific middleware group
        $middleware->prependToGroup('group-name', [
            First::class, // Some middleware executed first in the group
            Second::class, // Some middleware executed after `First::class` in the group
        ]);
        // Explanation:
        // `prependToGroup` adds middleware to the beginning of the middleware stack of the specified group.
        // This ensures that the prepended middleware is executed before others in the group.

        // Summary:
        // - `append`: Adds middleware globally, executed after any previously registered middleware.
        // - `prepend`: Adds middleware globally, executed before any previously registered middleware.
        // - `appendToGroup`: Adds middleware to the end of a specific group.
        // - `prependToGroup`: Adds middleware to the beginning of a specific group.
    })
    // Exception handling configuration
    ->withExceptions(function (Exceptions $exceptions) {
        // Add custom exception handling logic here (if needed)
    })
    // Create the application instance
    ->create();