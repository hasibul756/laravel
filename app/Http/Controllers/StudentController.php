<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    // Declare the model as a property of the controller
    protected $studentModel;

    /**
     * Initialize the model in the constructor
     */
    public function __construct()
    {
        $this->studentModel = new Student();
    }

    /**
     * Display a listing of students.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Initialize Model
        // $students = \App\Models\Student::all();
        // $studentsModel = new Student();
        
        // Fetch all students using the initialized model
        $students = $this->studentModel->getStudents();

        // Pass the data to the index view
        return view('students.index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new student.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Return the view for creating a student
        return view('students.create');
    }

    /**
     * Store a newly created student in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'course' => 'nullable|string|max:100',
        ]);

        // Use the globally set model to add a new student
        $newStudent = $this->studentModel->addStudent($validatedData);

        // Redirect to the index page with a success message
        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    /**
     * Show the form for editing a specific student.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        // Fetch the student by ID using the globally set model
        $student = $this->studentModel->getStudentById($id);

        // If student doesn't exist, redirect with an error message
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }

        // Pass the student data to the edit view
        return view('students.edit', ['student' => $student]);
    }

    /**
     * Update a specific student in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:students,email,{$id}", // Allow the same email for this student
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'course' => 'nullable|string|max:100',
        ]);

        // Update the student using the globally set model
        $isUpdated = $this->studentModel->updateStudent($id, $validatedData);

        if ($isUpdated) {
            return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        }

        return redirect()->route('students.index')->with('error', 'Failed to update student.');
    }

    /**
     * Delete a specific student from the database.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Use the globally set model to delete the student
        $isDeleted = $this->studentModel->deleteStudent($id);

        if ($isDeleted) {
            return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
        }

        return redirect()->route('students.index')->with('error', 'Failed to delete student.');
    }

    /**
     * Search students by name.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        // Get the search keyword from the request
        $keyword = $request->input('keyword');

        // Use the globally set model to search for students by name
        $students = $this->studentModel->searchStudentsByName($keyword);

        // Return the search results view
        return view('students.search_results', ['students' => $students, 'keyword' => $keyword]);
    }
}