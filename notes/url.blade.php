<?php

    // Get the current URL including query string parameters
    $currentUrl = URL::current();
    // Example: If visiting "http://example.com/posts?search=laravel"
    // Output: "http://example.com/posts"
    
    // Get the full URL including query string parameters
    $fullUrl = URL::full();
    // Example: If visiting "http://example.com/posts?search=laravel"
    // Output: "http://example.com/posts?search=laravel"

    // Get the previous URL (the one the user came from)
    $previousUrl = URL::previous();
    // This is particularly useful for redirecting back after a form submission or action.

    // Generate a full URL to a specific path
    $specificUrl = URL::to('/about');
    // Output: "http://example.com/about"
    // You can also pass an array of query parameters
    $specificUrlWithParams = URL::to('/about', ['ref' => 'newsletter']);
    // Output: "http://example.com/about?ref=newsletter"

    // Generate a signed URL for routes (useful for temporary or secure links)
    $signedUrl = URL::signedRoute('verify', ['id' => 123]);
    // The 'verify' route must exist in your routes/web.php file.
    // This URL will include a signature as a query parameter for verification.

    // Generate a temporary signed URL with expiration
    $temporarySignedUrl = URL::temporarySignedRoute('verify', now()->addMinutes(30), ['id' => 123]);
    // This URL will expire in 30 minutes.

?>

// Blade Template Explanation:
// In Blade templates, Laravel provides the `url()` helper to generate URLs dynamically.
// Below are examples and their explanations:

{{ url()->current() }}
// Outputs the current URL without query parameters.
// Example: http://example.com/about

{{ url()->full() }}
// Outputs the current URL along with query parameters.
// Example: http://example.com/about?ref=newsletter

{{ url()->previous() }}
// Outputs the previous URL the user visited.
// Example: http://example.com/home

{{ url('about') }}
// Generates the absolute URL for the /about path.
// Example: http://example.com/about

{{ url('about', ['ref' => 'newsletter']) }}
// Generates the absolute URL for /about with query parameters.
// Example: http://example.com/about?ref=newsletter

{{ url()->signedRoute('verify', ['id' => 123]) }}
// Generates a signed URL for the 'verify' named route, providing an additional layer of security.
// Example: http://example.com/verify?id=123&signature=somehash

{{ url()->temporarySignedRoute('verify', now()->addMinutes(30), ['id' => 123]) }}
// Generates a temporary signed URL for the 'verify' named route with a 30-minute expiration.
// Example: http://example.com/verify?id=123&expires=1699999999&signature=somehash