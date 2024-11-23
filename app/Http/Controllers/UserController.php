<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.user_form');
    }

    public function addUser(Request $request)
    {

        // echo $request->input('name');

        // echo $request->name;

        // print_r($request->all());

        // Return only specific fields
        // $filteredData = $request->only(['name', 'email']);

        // Exclude the 'password' field
        // return $request->except(['password']);

        // Return all fields
        // $filteredData = $request->all();
        
        // return response()->json([
        //     'message' => 'User data received successfully.',
        //     'data' => $filteredData,
        // ]);

        // Validation rules with explicit individual validation
        $request->validate([
            'name' => 'required|string|min:3|max:255|uppercase',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'skills' => 'required|array|min:1',
            'gender' => 'required|in:Male,Female,Other',
            'age' => 'required|numeric|min:18',
            'role' => 'required'
        ],[
            // Custom error messages for validation
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
            'skills.required' => 'At least one skill is required.',
            'gender.required' => 'Gender is required.',
            'age.required' => 'Age is required.',
            'role.required' => 'Role is required.',
            'name.min' => 'Name must be at least 3 characters.',
            'email.email' => 'Invalid email format.',
            'password.min' => 'Password must be at least 8 characters.',
            'skills.min' => 'At least one skill is required.',
            'age.min' => 'You must be at least 18 years old.',
            'role.in' => 'Invalid role.'
        ]);

        return response()->json([
            'data' => $request->all(),
        ]);
    }
    
}
