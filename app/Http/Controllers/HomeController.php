<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    // Display the homepage
    public function index()
    {
        $data = ['title' => 'Home Controller'];

        if(View::exists('home')) {
            return view('home', $data);
        } else {
            return view('pages.home', $data);
        }
    }

    // Show a single post (example of dynamic data)
    public function show($id)
    {
        return "Showing details of post with ID: $id";
    }

    // Handle form submission
    public function store(Request $request)
    {
        // Accessing form data using $request
        $data = $request->all();
        return response()->json([
            'message' => 'Form data submitted successfully!',
            'data' => $data
        ]);
    }

    // Update a resource
    public function update(Request $request, $id)
    {
        // Update logic here
        return response()->json([
            'message' => "Resource with ID $id updated successfully!"
        ]);
    }

    // Delete a resource
    public function destroy($id)
    {
        // Deletion logic here
        return response()->json([
            'message' => "Resource with ID $id deleted successfully!"
        ]);
    }

    // Example of route with optional parameter
    public function optional($param = null)
    {
        if ($param) {
            return "You passed: $param";
        }
        return "No parameter passed!";
    }

    // Example for returning JSON response
    public function jsonResponse()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'This is a JSON response',
        ]);
    }
}
