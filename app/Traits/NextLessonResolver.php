<?php

namespace App\Traits;

use App\Models\CompletedLesson;
use App\Models\Course;
use App\Models\Lesson;

trait NextLessonResolver
{
    public function findNextLesson(Course $course, int $userId): ?Lesson
    {
        $completedIds = CompletedLesson::where('user_id', $userId)
            ->whereIn('lesson_id', $course->lessons->pluck('id'))
            ->pluck('lesson_id')
            ->toArray();

        return $course->lessons
            ->sortBy('order') // 👈 ensure lessons are in correct sequence
            ->firstWhere(fn($lesson) => !in_array($lesson->id, $completedIds));
    }
}
