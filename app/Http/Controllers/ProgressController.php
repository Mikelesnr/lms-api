<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function show(Request $request, \App\Models\Course $course)
    {
        $user = \App\Models\User::find($request->input('user_id')); // temporary until auth

        $total = $course->lessons()->count();
        $completed = $user->completedLessons()
            ->whereIn('lesson_id', $course->lessons->pluck('id'))
            ->count();

        return response()->json([
            'course_id' => $course->id,
            'total_lessons' => $total,
            'completed_lessons' => $completed,
            'progress_percent' => $total ? round(($completed / $total) * 100, 1) : 0,
        ]);
    }

    public function index(Request $request)
    {
        $user = \App\Models\User::find($request->input('user_id')); // temp

        $enrollments = $user->enrollments()->with('course.lessons')->get();

        $data = $enrollments->map(function ($enrollment) use ($user) {
            $lessons = $enrollment->course->lessons;
            $total = $lessons->count();
            $completed = $user->completedLessons()
                ->whereIn('lesson_id', $lessons->pluck('id'))
                ->count();

            return [
                'course_id' => $enrollment->course->id,
                'course_title' => $enrollment->course->title,
                'total_lessons' => $total,
                'completed_lessons' => $completed,
                'progress_percent' => $total ? round(($completed / $total) * 100, 1) : 0,
            ];
        });

        return response()->json($data);
    }
}
