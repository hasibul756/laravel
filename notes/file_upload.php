<?php

// File: notes_on_file_upload.php

/**
 * Laravel 11 File and Image Upload Notes
 * 
 * Laravel provides a straightforward way to handle file uploads, including images and documents.
 * You can validate, store, and retrieve uploaded files using the `Storage` facade and `Request` object.
 */

/**
 * 1. Basic Setup for File Upload
 * Use a POST route to handle a single file upload.
 */
use Illuminate\Http\Request;

Route::post('/upload-file', function (Request $request) {
    // Validation rules for single file upload
    $validatedData = $request->validate(
        [
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048', // Max file size: 2MB
        ],
        // Custom error messages
        [
            'file.required' => 'Please upload a file.',
            'file.mimes' => 'Only JPG, PNG, and PDF files are allowed.',
            'file.max' => 'The file size must not exceed 2MB.',
        ]
    );

    // Store the file in the 'uploads' directory under storage/app/public/uploads
    $filePath = $request->file('file')->store('uploads', 'public');

    return response()->json([
        'message' => 'File uploaded successfully!',
        'path' => $filePath,
    ]);
});

/**
 * 2. HTML Form for File Upload
 * Use the `enctype="multipart/form-data"` attribute to handle file uploads in forms.
 */

?>

<!-- File: resources/views/upload.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>File Upload</title>
</head>
<body>
    <h1>Upload a File</h1>
    <form action="/upload-file" method="POST" enctype="multipart/form-data">
        @csrf <!-- CSRF token for security -->
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>

<?php

/**
 * 3. Multiple File Uploads
 * Laravel supports uploading multiple files using an array.
 */
Route::post('/upload-multiple-files', function (Request $request) {
    // Validation for multiple files
    $validatedData = $request->validate([
        'files.*' => 'required|file|mimes:jpg,png,pdf|max:2048', // Validate each file in the array
    ], [
        'files.*.required' => 'Please upload at least one file.',
        'files.*.mimes' => 'Only JPG, PNG, and PDF files are allowed.',
        'files.*.max' => 'Each file size must not exceed 2MB.',
    ]);

    $filePaths = [];
    foreach ($request->file('files') as $file) {
        $filePaths[] = $file->store('uploads', 'public');
    }

    return response()->json([
        'message' => 'Files uploaded successfully!',
        'paths' => $filePaths,
    ]);
});

?>

<!-- File: resources/views/multiple_upload.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Multiple File Upload</title>
</head>
<body>
    <h1>Upload Multiple Files</h1>
    <form action="/upload-multiple-files" method="POST" enctype="multipart/form-data">
        @csrf <!-- CSRF token for security -->
        <input type="file" name="files[]" multiple required> <!-- Multiple file upload -->
        <button type="submit">Upload</button>
    </form>
</body>
</html>

<?php

/**
 * 4. Handling File Uploads in a Controller
 * Use a dedicated controller to manage file upload logic.
 * 
 * Command to create a controller:
 *     php artisan make:controller FileUploadController
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    // Single file upload
    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $filePath = $request->file('file')->store('uploads', 'public');

        return response()->json(['message' => 'File uploaded successfully!', 'path' => $filePath]);
    }

    // Multiple file uploads
    public function uploadMultiple(Request $request)
    {
        $validatedData = $request->validate([
            'files.*' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $filePaths = [];
        foreach ($request->file('files') as $file) {
            $filePaths[] = $file->store('uploads', 'public');
        }

        return response()->json(['message' => 'Files uploaded successfully!', 'paths' => $filePaths]);
    }
}

/**
 * Routes for the controller methods
 */
use App\Http\Controllers\FileUploadController;

Route::post('/upload-file', [FileUploadController::class, 'upload']);
Route::post('/upload-multiple-files', [FileUploadController::class, 'uploadMultiple']);

/**
 * Summary:
 * 1. Single file upload: Use `file` input and validate with `required|file|mimes`.
 * 2. Multiple file uploads: Use `files[]` input and validate with `files.*`.
 * 3. Store uploaded files in `storage/app/public` using the `store` method.
 * 4. Run `php artisan storage:link` for public access to uploaded files.
 */

