<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // Specify the table name if it does not follow Laravel's convention
    protected $table = 'students';

    // Specify the primary key if it is not 'id'
    protected $primaryKey = 'id';

    // Disable timestamps if the table does not have 'created_at' and 'updated_at'
    public $timestamps = false;

    // Define which columns can be mass assigned
    protected $fillable = ['name', 'email', 'phone', 'address', 'course'];

    /**
     * Get all students.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStudents()
    {
        // Return all students
        return self::all();
    }

    /**
     * Find a specific student by ID.
     *
     * @param int $id
     * @return Student|null
     */
    public function getStudentById($id)
    {
        // Retrieve a single student or return null if not found
        return self::find($id);
    }

    /**
     * Add a new student.
     *
     * @param array $data
     * @return Student
     */
    public function addStudent(array $data)
    {
        // Create a new student record using mass assignment
        return self::create($data);
    }

    /**
     * Update an existing student's information.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateStudent($id, array $data)
    {
        // Find the student and update their information
        $student = self::find($id);
        if ($student) {
            return $student->update($data);
        }
        return false;
    }

    /**
     * Delete a student by ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function deleteStudent($id)
    {
        // Find the student and delete their record
        $student = self::find($id);
        if ($student) {
            return $student->delete();
        }
        return false;
    }

    /**
     * Search students by name.
     *
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchStudentsByName($name)
    {
        // Search for students by name (case-insensitive)
        return self::where('name', 'LIKE', '%' . $name . '%')->get();
    }
}