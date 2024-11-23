<?php

// File: notes_on_query.php

/**
 * Laravel 11 Database Query Notes (Using MVC Pattern + Query Builder)
 * 
 * This file demonstrates how to handle database queries using both Query Builder and Eloquent ORM.
 * All logic is placed within controllers and models, following Laravel's MVC architecture.
 */

/**
 * 1. Setting Up Database Configuration
 * Configure the database in the `.env` file.
 * 
 * Example:
 * DB_CONNECTION=mysql
 * DB_HOST=127.0.0.1
 * DB_PORT=3306
 * DB_DATABASE=your_database
 * DB_USERNAME=your_username
 * DB_PASSWORD=your_password
 */

/**
 * 2. Creating a Model
 * Use `php artisan make:model` to create a model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password']; // Fields for mass assignment
}

/**
 * 3. Creating a Controller
 * Use `php artisan make:controller` to create a controller.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import Query Builder
use App\Models\User;

class UserController extends Controller
{
    /**
     * Fetch all users (Query Builder).
     */
    public function getAllUsersQueryBuilder()
    {
        $users = DB::table('users')->get(); // Fetch all users using Query Builder
        return view('users.index', ['users' => $users]);
    }

    /**
     * Fetch all users (Eloquent ORM).
     */
    public function getAllUsersEloquent()
    {
        $users = User::all(); // Fetch all users using Eloquent
        return view('users.index', ['users' => $users]);
    }

    /**
     * Fetch a single user by ID (Query Builder).
     */
    public function getUserByIdQueryBuilder($id)
    {
        $user = DB::table('users')->where('id', $id)->first(); // Fetch user by ID
        return view('users.show', ['user' => $user]);
    }

    /**
     * Fetch a single user by ID (Eloquent ORM).
     */
    public function getUserByIdEloquent($id)
    {
        $user = User::findOrFail($id); // Fetch user by ID or throw 404
        return view('users.show', ['user' => $user]);
    }

    /**
     * Add a new user (Query Builder).
     */
    public function addUserQueryBuilder(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        DB::table('users')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'User added using Query Builder.');
    }

    /**
     * Add a new user (Eloquent ORM).
     */
    public function addUserEloquent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'User added using Eloquent.');
    }

    /**
     * Update an existing user (Query Builder).
     */
    public function updateUserQueryBuilder(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        DB::table('users')->where('id', $id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return redirect()->route('users.index')->with('success', 'User updated using Query Builder.');
    }

    /**
     * Update an existing user (Eloquent ORM).
     */
    public function updateUserEloquent(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated using Eloquent.');
    }

    /**
     * Delete a user (Query Builder).
     */
    public function deleteUserQueryBuilder($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('users.index')->with('success', 'User deleted using Query Builder.');
    }

    /**
     * Delete a user (Eloquent ORM).
     */
    public function deleteUserEloquent($id)
    {
        User::destroy($id);
        return redirect()->route('users.index')->with('success', 'User deleted using Eloquent.');
    }
}

/**
 * 4. Setting Up Routes
 */

use App\Http\Controllers\UserController;

// Query Builder Routes
Route::get('/users/query', [UserController::class, 'getAllUsersQueryBuilder']);
Route::get('/users/query/{id}', [UserController::class, 'getUserByIdQueryBuilder']);
Route::post('/users/query', [UserController::class, 'addUserQueryBuilder']);
Route::put('/users/query/{id}', [UserController::class, 'updateUserQueryBuilder']);
Route::delete('/users/query/{id}', [UserController::class, 'deleteUserQueryBuilder']);

// Eloquent ORM Routes
Route::get('/users/eloquent', [UserController::class, 'getAllUsersEloquent']);
Route::get('/users/eloquent/{id}', [UserController::class, 'getUserByIdEloquent']);
Route::post('/users/eloquent', [UserController::class, 'addUserEloquent']);
Route::put('/users/eloquent/{id}', [UserController::class, 'updateUserEloquent']);
Route::delete('/users/eloquent/{id}', [UserController::class, 'deleteUserEloquent']);

/**
 * Summary:
 * 1. **Query Builder**: Provides raw control over SQL queries while staying database agnostic.
 * 2. **Eloquent ORM**: Simplifies database interactions with a model-based approach.
 * 3. **CRUD Operations**: Demonstrated using both Query Builder and Eloquent.
 * 4. **MVC Structure**: Separates logic into models, controllers, and views.
 */

