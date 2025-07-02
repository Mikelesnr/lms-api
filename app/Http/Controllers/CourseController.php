<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // List all courses (for students)
    public function index()
    {
        return Course::with('instructor')->latest()->get();
    }

    // Show course details
    public function show(Course $course)
    {
        return $course->load(['instructor', 'lessons']);
    }

    // Create a new course (instructor-only)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id', // temporary until auth
        ]);

        $course = Course::create($request->only('title', 'description', 'user_id'));

        return response()->json($course, 201);
    }

    // Update an existing course
    public function update(Request $request, Course $course)
    {
        $course->update($request->only('title', 'description'));

        return response()->json($course);
    }

    // Delete a course
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json(['message' => 'Course deleted']);
    }
}
