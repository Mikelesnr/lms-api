<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $enrollment = \App\Models\Enrollment::firstOrCreate(
            $request->only('user_id', 'course_id'),
            ['started_at' => now()]
        );

        return response()->json($enrollment, 201);
    }

    public function showUserCourses(Request $request, $userId)
    {
        $courses = \App\Models\Course::whereHas(
            'enrollments',
            fn($q) =>
            $q->where('user_id', $userId)
        )
            ->with([
                'instructor:id,name',
                'lessons:id,course_id,title'
            ])
            ->withCount('lessons')
            ->get();

        return response()->json($courses);
    }
}
