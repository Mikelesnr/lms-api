<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\CompletedLesson;
use App\Models\Lesson;
use App\Traits\ProgressCalculator;
use App\Traits\NextLessonResolver;

class EnrollmentController extends Controller
{
    use ProgressCalculator, NextLessonResolver;

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $enrollment = Enrollment::firstOrCreate(
            $request->only('user_id', 'course_id'),
            ['started_at' => now()]
        );

        return response()->json($enrollment, 201);
    }

    public function showUserCourses(Request $request, $userId)
    {
        $courses = Course::whereHas(
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

    //Show courses that the authenticated student
    public function showMyCourses(Request $request)
    {
        $userId = $request->user()->id;

        $courses = Course::whereHas('enrollments', fn($q) => $q->where('user_id', $userId))
            ->with([
                'instructor:id,name',
                'lessons:id,course_id,title,order'
            ])
            ->withCount('lessons')
            ->get();

        foreach ($courses as $course) {
            $course->progress = $this->calculateProgress($course, $userId);

            $next = $this->findNextLesson($course, $userId);
            $course->next_lesson = $next
                ? ['id' => $next->id, 'title' => $next->title]
                : null;
        }

        return response()->json($courses);
    }
}
