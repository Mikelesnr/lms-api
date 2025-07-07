<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CompletedLesson;
use App\Models\Enrollment;

class CompletedLessonController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'grade' => 'nullable|numeric|min:0|max:100',
        ]);

        $completion = \App\Models\CompletedLesson::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'lesson_id' => $request->lesson_id,
            ],
            [
                'grade' => $request->grade,
            ]
        );

        return response()->json([
            'message' => 'Lesson completed successfully.',
            'data' => $completion,
        ], 201);
    }

    public function getGrade(Request $request, User $user = null)
    {
        $requestingUser = $request->user();
        $targetUser = $user ?? $requestingUser;

        $completed = CompletedLesson::where('user_id', $targetUser->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        if ($completed->isEmpty()) {
            return response()->json([
                'message' => 'No grades found for this user.',
                'grades' => [],
            ], 404);
        }

        return response()->json([
            'grades' => $completed->map(function ($record) {
                return [
                    'lesson_id' => $record->lesson_id,
                    'grade' => $record->grade,
                    'updated_at' => $record->updated_at,
                ];
            }),
        ]);
    }

    public function activeEnrollmentCount(Request $request)
    {
        $user = $request->user();

        $count = Enrollment::where('user_id', $user->id)
            ->whereNull('completed_at')
            ->count();

        return response()->json(['active_enrollments' => $count]);
    }

    public function completedQuizCount(Request $request)
    {
        $user = $request->user();

        $count = CompletedLesson::where('user_id', $user->id)->count();

        return response()->json(['completed_quizzes' => $count]);
    }

    public function quizAnalyticsByCourse(Request $request)
    {
        $userId = $request->user()->id;

        $completed = \App\Models\CompletedLesson::with('lesson.course')
            ->where('user_id', $userId)
            ->get();

        $grouped = $completed->groupBy(fn($c) => $c->lesson->course->id)
            ->map(function ($lessons) {
                $course = $lessons->first()->lesson->course;
                return [
                    'course_id' => $course->id,
                    'course_title' => $course->title,
                    'lessons' => $lessons->map(function ($l) {
                        return [
                            'lesson_id' => $l->lesson_id,
                            'title' => $l->lesson->title,
                            'grade' => $l->grade,
                        ];
                    })->values(),
                ];
            })
            ->values();

        return response()->json(['quiz_analytics' => $grouped]);
    }
}
