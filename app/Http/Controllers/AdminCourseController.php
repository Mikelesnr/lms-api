<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class AdminCourseController extends Controller
{
    public function index()
    {
        return Course::with(['instructor', 'enrollments'])
            ->withCount('enrollments')
            ->paginate(10); // You can adjust the page size
    }

    public function show($id)
    {
        return Course::with([
            'instructor',
            'lessons.quiz',
            'enrollments.student'
        ])->findOrFail($id);
    }
}
