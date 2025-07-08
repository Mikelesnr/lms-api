<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\Quiz;
use App\Models\QuizQuestion;

class InstructorOverviewController extends Controller
{
    public function show(Request $request)
    {
        $userId = $request->user()->id;

        $totalCourses = Course::where('user_id', $userId)->count();

        $totalLessons = Lesson::whereHas('course', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->count();

        $activeStudents = Enrollment::whereNull('completed_at')
            ->whereHas('course', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->distinct('user_id')
            ->count('user_id');

        return response()->json([
            'courses' => $totalCourses,
            'lessons' => $totalLessons,
            'active_students' => $activeStudents,
        ]);
    }

    public function students(Request $request)
    {
        $userId = $request->user()->id;
        $perPage = $request->get('per_page', 10);

        return Enrollment::with('student', 'course')
            ->whereHas('course', fn($q) => $q->where('user_id', $userId))
            ->paginate($perPage)
            ->through(fn($enrollment) => [
                'student_name' => $enrollment->student->name,
                'student_email' => $enrollment->student->email,
                'course_title' => $enrollment->course->title,
                'enrolled_at' => $enrollment->started_at,
            ]);
    }

    public function quizStats(Request $request)
    {
        $userId = $request->user()->id;

        $quizzes = Quiz::whereHas('lesson.course', fn($q) => $q->where('user_id', $userId));
        $totalQuizzes = $quizzes->count();

        $totalQuestions = QuizQuestion::whereHas('quiz.lesson.course', fn($q) => $q->where('user_id', $userId))->count();

        return response()->json([
            'total_quizzes' => $totalQuizzes,
            'total_questions' => $totalQuestions,
            'average_questions_per_quiz' => $totalQuizzes ? round($totalQuestions / $totalQuizzes, 1) : 0,
        ]);
    }
}
