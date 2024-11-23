<?php
/**
 * Laravel Routes: A Comprehensive Overview
 *
 * This file demonstrates various types of routes in Laravel with examples and explanations. 
 */

// Simple GET routes
Route::get('/about', function () {
    return view('pages.about'); // Returns the 'about' view from the 'pages' folder.
});

Route::get('/contact', function () {
    return view('pages.contact'); // Returns the 'contact' view from the 'pages' folder.
});

// Route with an optional parameter
Route::get('/dashboard/{path?}', function ($path = null) {
    return view('pages/home', ['path' => $path]); // Returns 'home' view with an optional 'path' parameter.
});

// Route with a required parameter
Route::get('/user/{id}', function ($id) {
    return "User ID: $id"; // Displays the user ID from the URL.
});

// Route with parameter constraints using Regular Expressions
Route::get('/post/{slug}', function ($slug) {
    return "Post Slug: $slug"; // Displays the post slug.
})->where('slug', '[A-Za-z0-9\-]+'); // Restricts 'slug' to alphanumeric characters with hyphens.

// Named route
Route::get('/profile', function () {
    return 'User Profile Page'; // Named route example.
})->name('profile');

// Grouped routes with a common prefix
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return 'Admin Dashboard'; // Example of an admin dashboard route.
    });

    Route::get('/users', function () {
        return 'Manage Users'; // Example of an admin users management route.
    });
});

// Middleware route
Route::get('/account', function () {
    return 'Account Page'; // Example of a route with 'auth' middleware.
})->middleware('auth');

// POST route for form submission
Route::post('/form-submit', function () {
    return 'Form Submitted!'; // Handles form submission via POST method.
});

// PUT route for updating resources
Route::put('/user/{id}', function ($id) {
    return "Updated user with ID: $id"; // Handles resource updates via PUT method.
});

// PATCH route for partial updates
Route::patch('/user/{id}', function ($id) {
    return "Patched user with ID: $id"; // Handles partial updates via PATCH method.
});

// DELETE route for deleting resources
Route::delete('/user/{id}', function ($id) {
    return "Deleted user with ID: $id"; // Deletes a resource via DELETE method.
});

// Resource route for standard CRUD operations
Route::resource('products', 'ProductController'); // Automatically sets up CRUD routes for 'products'.

// Redirect route
Route::redirect('/home', '/dashboard'); // Redirects '/home' to '/dashboard'.

// Fallback route for undefined routes (404)
Route::fallback(function () {
    return response('Page not found!', 404); // Handles undefined routes.
});

// View route for static views
Route::view('/about', 'about', ['app' => 'Laravel Application']); // Directly returns a static view with data.

// Default route for the homepage
Route::get('/', [HomeController::class, 'index']); // Calls the 'index' method of HomeController.

// Route with a dynamic parameter
Route::get('/post/{id}', [HomeController::class, 'show']); // Calls the 'show' method of HomeController with 'id'.

// Form submission handled by a controller
Route::post('/form-submit', [HomeController::class, 'store']); // Calls the 'store' method of HomeController.

// Update a resource using a controller
Route::put('/update/{id}', [HomeController::class, 'update']); // Calls the 'update' method of HomeController.

// Delete a resource using a controller
Route::delete('/delete/{id}', [HomeController::class, 'destroy']); // Calls the 'destroy' method of HomeController.

// Route with an optional parameter handled by a controller
Route::get('/optional/{param?}', [HomeController::class, 'optional']); // Calls the 'optional' method of HomeController.

// Route returning a JSON response
Route::get('/json-response', [HomeController::class, 'jsonResponse']); // Calls 'jsonResponse' in HomeController and returns JSON.

/**
 * Common Route Functions and Their Uses:
 *
 * - `route('route.name')`: Generates a URL for a named route.
 * - `url('/path')`: Generates a URL for a specific path.
 * - `redirect('/path')`: Redirects to a specific URL or route.
 * - `view('view.name')`: Returns a view for a specific route.
 * - `Route::fallback()`: Catches all undefined routes and serves a custom 404 page.
 * - `Route::middleware()`: Applies middleware to protect or modify routes.
 * - `Route::prefix('prefix')`: Groups routes under a common prefix.
 * - `Route::resource()`: Quickly sets up all CRUD routes for a resource controller.
 *
 * Use these helper functions and routing methods to create clean, maintainable, and scalable Laravel applications.
 */
?>
