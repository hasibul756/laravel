<?php

// File: notes_on_validation.php

/**
 * Laravel 11 Validation Notes
 * 
 * Laravel provides a robust validation system for ensuring data integrity.
 * You can define validation rules, handle custom error messages, and even customize default validation messages.
 */

/**
 * 1. Basic Validation
 * Use the `validate` method to validate incoming request data. 
 * This method accepts an array of rules and optional custom error messages.
 */
use Illuminate\Http\Request;

Route::post('/store-data', function (Request $request) {
    // Validation rules
    $validatedData = $request->validate(
        [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ],
        // Custom error messages
        [
            'name.required' => 'The name field is required.',
            'email.email' => 'Please provide a valid email address.',
            'password.confirmed' => 'Passwords must match.',
        ]
    );

    // Data passed validation, proceed with storage logic
    return response()->json(['message' => 'Data validated successfully!', 'data' => $validatedData]);
});

/**
 * 2. Editing Default Validation Messages
 * Laravel's default validation messages are stored in language files.
 * 
 * Command to generate language files:
 *     php artisan make:lang
 * 
 * This creates a `lang` directory with subdirectories for each supported locale.
 * Example: lang/en/validation.php
 * 
 * Edit `validation.php` to customize messages globally.
 */

return [
    'required' => 'The :attribute field is mandatory.', // Custom global message for "required" rule
    'email' => 'The :attribute must be a valid email address.', // Global message for "email" rule
    'unique' => 'The :attribute has already been taken.', // Global message for "unique" rule

    // You can also define attributes for a more human-readable error message
    'attributes' => [
        'email' => 'Email Address',
        'password' => 'Password',
    ],
];

/**
 * 3. Using Validation in a Form Request
 * Create a form request class for reusable validation logic.
 * 
 * Command to create a form request:
 *     php artisan make:request StoreUserRequest
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'email.email' => 'Enter a valid email address.',
        ];
    }
}

/**
 * 4. Using the Form Request in a Controller
 * Pass the custom request class as a type-hinted dependency.
 */
use App\Http\Requests\StoreUserRequest;

Route::post('/store-data', function (StoreUserRequest $request) {
    // Validation has already been applied by the form request
    $validatedData = $request->validated();

    // Handle the validated data
    return response()->json(['message' => 'Form validated!', 'data' => $validatedData]);
});

/**
 * 5. Custom Validation Rules
 * Laravel allows you to define custom validation rules as classes.
 * 
 * Command to create a custom rule:
 *     php artisan make:rule ValidUsername
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidUsername implements Rule
{
    public function passes($attribute, $value): bool
    {
        // Custom logic: only allow alphanumeric usernames
        return preg_match('/^[a-zA-Z0-9]+$/', $value);
    }

    public function message(): string
    {
        return 'The :attribute must only contain letters and numbers.';
    }
}

/**
 * Usage of Custom Rule
 */
use App\Rules\ValidUsername;

Route::post('/register', function (Request $request) {
    $validatedData = $request->validate([
        'username' => ['required', new ValidUsername],
    ]);

    return response()->json(['message' => 'Validation passed!', 'data' => $validatedData]);
});

/**
 * Summary:
 * 1. Use the `validate` method for basic validation.
 * 2. Customize default messages in `lang/en/validation.php`.
 * 3. Use form requests for reusable validation logic.
 * 4. Define and use custom validation rules as needed.
 */