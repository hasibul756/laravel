<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Importing the Request class for handling HTTP requests
use Illuminate\Support\Facades\Http; // Importing Laravel's HTTP client for making API calls
use Illuminate\Support\Facades\Log; // Importing Log for error logging

class ApiCallController extends Controller
{
    private $apiHeaders;

    public function __construct()
    {
        $this->apiHeaders = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . env('API_SECRET_KEY'),
        ];
    }

    /**
     * Handle GET request to fetch user data from an external API.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $apiUrl = 'https://jsonplaceholder.typicode.com/users/1';

        try {
            $response = Http::get($apiUrl);

            if ($response->successful()) {
                $userData = $response->json(); // Use `json()` directly instead of `json_decode`
                return view('api_call.index', ['data' => $userData]);
            }

            return view('api_call.index', [
                'error' => 'Failed to fetch data. Status Code: ' . $response->status(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching user data: ' . $e->getMessage());
            return view('api_call.index', ['error' => 'An error occurred while fetching data.']);
        }
    }

    /**
     * Demonstrate a POST request to an external API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $apiUrl = 'https://jsonplaceholder.typicode.com/posts';
        $payload = [
            'title' => 'Sample Title',
            'body' => 'This is a sample post body.',
            'userId' => 1,
        ];

        try {
            $response = Http::post($apiUrl, $payload);

            if ($response->successful()) {
                return response()->json([
                    'status' => $response->status(),
                    'data' => $response->json(),
                ]);
            }

            return response()->json([
                'status' => $response->status(),
                'message' => 'Failed to create resource.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating resource: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'An internal server error occurred.',
            ]);
        }
    }

    /**
     * Demonstrate PUT request to update data in an external API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $apiUrl = 'https://jsonplaceholder.typicode.com/posts/1';
        $updatedData = [
            'title' => 'Updated Title',
            'body' => 'This is the updated post body.',
        ];

        try {
            $response = Http::put($apiUrl, $updatedData);

            if ($response->successful()) {
                return response()->json([
                    'status' => $response->status(),
                    'data' => $response->json(),
                ]);
            }

            return response()->json([
                'status' => $response->status(),
                'message' => 'Failed to update resource.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating resource: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'An internal server error occurred.',
            ]);
        }
    }

    /**
     * Demonstrate DELETE request to remove data from an external API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $apiUrl = 'https://jsonplaceholder.typicode.com/posts/1';

        try {
            $response = Http::delete($apiUrl);

            if ($response->successful()) {
                return response()->json([
                    'status' => $response->status(),
                    'message' => 'Deleted successfully.',
                ]);
            }

            return response()->json([
                'status' => $response->status(),
                'message' => 'Failed to delete resource.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting resource: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'An internal server error occurred.',
            ]);
        }
    }



    // With Headers:
    public function indexWithHeaders()
    {
        // Step 1: Define the API endpoint
        $apiUrl = 'https://jsonplaceholder.typicode.com/users/1';

        // Step 2: Send a GET request with headers
        $response = Http::withHeaders($this->apiHeaders)->get($apiUrl);

        // Step 3: Handle the response
        $userData = json_decode($response->body());

        // Step 4: Pass the data to a view
        return view('api_call.index', ['data' => $userData]);
    }

    public function storeWithHeaders()
    {
        // Step 1: Define the API endpoint
        $apiUrl = 'https://jsonplaceholder.typicode.com/posts';

        // Step 2: Define the payload
        $payload = [
            'title' => 'Sample Title',
            'body' => 'This is a sample post body.',
            'userId' => 1,
        ];

        // Step 3: Send a POST request with headers
        $response = Http::withHeaders($this->apiHeaders)->post($apiUrl, $payload);

        // Step 4: Handle the response
        $responseData = json_decode($response->body());
        $statusCode = $response->status();

        // Return the response data and status code for demonstration purposes.
        return response()->json([
            'status' => $statusCode,
            'data' => $responseData,
        ]);
    }

    public function updateWithHeaders()
    {
        // Step 1: Define the API endpoint
        $apiUrl = 'https://jsonplaceholder.typicode.com/posts/1';

        // Step 2: Define the updated data payload
        $updatedData = [
            'title' => 'Updated Title',
            'body' => 'This is the updated post body.',
        ];

        // Step 3: Send a PUT request with headers
        $response = Http::withHeaders($this->apiHeaders)->put($apiUrl, $updatedData);

        // Step 4: Handle the response
        $responseData = json_decode($response->body());
        $statusCode = $response->status();

        // Return the response data and status code for demonstration purposes.
        return response()->json([
            'status' => $statusCode,
            'data' => $responseData,
        ]);
    }

    public function destroyWithHeaders()
    {
        // Step 1: Define the API endpoint
        $apiUrl = 'https://jsonplaceholder.typicode.com/posts/1';

        // Step 2: Send a DELETE request with headers
        $response = Http::withHeaders($this->apiHeaders)->delete($apiUrl);

        // Step 3: Handle the response
        $statusCode = $response->status();

        // Return the status code for demonstration purposes.
        return response()->json([
            'status' => $statusCode,
            'message' => $statusCode === 200 ? 'Deleted successfully' : 'Failed to delete',
        ]);
    }


    // With Cookies:
    public function indexWithCookies()
    {
        // Step 1: Define the API endpoint
        $apiUrl = 'https://jsonplaceholder.typicode.com/users/1';

        // Step 2: Send a GET request with cookies
        $response = Http::withCookies($this->apiCookies)->get($apiUrl);

        // Step 3: Handle the response
        $userData = json_decode($response->body());

        // Step 4: Pass the data to a view
        return view('api_call.index', ['data' => $userData]);
    }

    public function storeWithCookies()
    {
        // Step 1: Define the API endpoint
        $apiUrl = 'https://jsonplaceholder.typicode.com/posts'; // Replace with your API endpoint

        // Step 2: Define the payload
        $payload = [
            'title' => 'Sample Title',
            'body' => 'This is a sample post body.',
            'userId' => 1,
        ];

        // Step 3: Send a POST request with cookies
        $response = Http::withCookies($this->apiCookies)->post($apiUrl, $payload);

        // Step 4: Handle the response
        $responseData = json_decode($response->body());
        $statusCode = $response->status();

        // Return the response data and status code for demonstration purposes.
        return response()->json([
            'status' => $statusCode,
            'data' => $responseData,
        ]);
    }

    // With Basic Authentication:
    public function indexWithBasicAuth()
    {
        // Step 1: Define the API endpoint
        $apiUrl = 'https://jsonplaceholder.typicode.com/users/1';

        // Step 2: Send a GET request with basic authentication
        $response = Http::withBasicAuth('username', 'password')->get($apiUrl);

        // Step 3: Handle the response
        $userData = json_decode($response->body());

        // Step 4: Pass the data to a view
        return view('api_call.index', ['data' => $userData]);
    }

    // With Timeout:
    public function indexWithTimeout()
    {
        // Step 1: Define the API endpoint
        $apiUrl = 'https://jsonplaceholder.typicode.com/users/1';

        // Step 2: Send a GET request with a timeout
        $response = Http::timeout(5)->get($apiUrl);

        // Step 3: Handle the response
        $userData = json_decode($response->body());

        // Step 4: Pass the data to a view
        return view('api_call.index', ['data' => $userData]);
    }

    // With Proxy:
    public function indexWithProxy()
    {
        // Step 1: Define the API endpoint
        $apiUrl = 'https://jsonplaceholder.typicode.com/users/1';    

        // Step 2: Send a GET request with a proxy
        $response = Http::proxy('127.0.0.1:8888')->get($apiUrl);

        // Step 3: Handle the response
        $userData = json_decode($response->body());

        // Step 4: Pass the data to a view
        return view('api_call.index', ['data' => $userData]);
    }

    /**
     * Helper method to send an HTTP request with error handling.
     *
     * @param string $method HTTP method (GET, POST, PUT, DELETE)
     * @param string $url API endpoint
     * @param array|null $payload Data to send with the request (optional)
     * @param bool $useHeaders Whether to include default headers
     * @return array Response data or error message
     */
    private function sendRequest(string $method, string $url, array $payload = null, bool $useHeaders = false): array
    {
        try {
            $client = $useHeaders ? Http::withHeaders($this->apiHeaders) : Http::withoutHeaders();
            
            $response = match ($method) {
                'GET' => $client->get($url),
                'POST' => $client->post($url, $payload),
                'PUT' => $client->put($url, $payload),
                'DELETE' => $client->delete($url),
                default => throw new \InvalidArgumentException("Invalid HTTP method: $method"),
            };

            // Check if the response is successful
            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'status' => $response->status(),
                ];
            }

            // Log the error response
            Log::error("API call failed", [
                'url' => $url,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => 'API call failed. Please check the logs for details.',
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            // Log the exception
            Log::error("Exception during API call", [
                'url' => $url,
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while communicating with the API.',
            ];
        }
    }

    public function indexWithHelper()
    {
        $apiUrl = env('API_USER_URL', 'https://jsonplaceholder.typicode.com/users/1');
        $response = $this->sendRequest('GET', $apiUrl);

        if (!$response['success']) {
            return view('errors.api_error', ['message' => $response['message']]);
        }

        return view('api_call.index', ['data' => $response['data']]);
    }

    public function storeWithHelper()
    {
        $apiUrl = env('API_POST_URL', 'https://jsonplaceholder.typicode.com/posts');
        $payload = [
            'title' => 'Sample Title',
            'body' => 'This is a sample post body.',
            'userId' => 1,
        ];

        $response = $this->sendRequest('POST', $apiUrl, $payload);

        return response()->json($response);
    }

    public function updateWithHelper()
    {
        $apiUrl = env('API_POST_URL', 'https://jsonplaceholder.typicode.com/posts/1');
        $payload = [
            'title' => 'Updated Title',
            'body' => 'This is the updated post body.',
        ];

        $response = $this->sendRequest('PUT', $apiUrl, $payload);

        return response()->json($response);
    }

    public function destroyWithHelper()
    {
        $apiUrl = env('API_POST_URL', 'https://jsonplaceholder.typicode.com/posts/1');

        $response = $this->sendRequest('DELETE', $apiUrl);

        return response()->json($response);
    }


}
