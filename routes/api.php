<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/user', function () {
    return [
        'name' => 'John Doe',
        'age' => 30,
        'email' => 'johndoe@example.com',
        'address' => '123 Main Street',
    ];
});

Route::fallback(function () {
    return response()->json(['error' => 'Route not found'], 404);
});