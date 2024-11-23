<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BladeController extends Controller
{
    public function index()
    {
        // Example data
        $title = 'Blade Template Syntax Examples';
        $user_data = [
            'name' => 'John Doe',
            'age' => 30,
            'email' => 'johndoe@example.com',
            'address' => '123 Main Street',
        ];

        // Flash a success message to the session (example)
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Welcome to the Blade Template Examples!',
        ]);

        return view('notes.blade_template', compact('title', 'user_data'));
    }

    /**
     * Handle the form submission.
     */
    public function submit(Request $request)
    {
        // Validate the form input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Flash a success message to the session
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Form submitted successfully!',
        ]);

        return redirect('/blade');
    }
}
