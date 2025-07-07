<?php

namespace App\Traits;

use App\Models\Course;
use App\Models\CompletedLesson;

trait ProgressCalculator
{
    public function calculateProgress(Course $course, int $userId): int
    {
        $total = $course->lessons_count ?? $course->lessons()->count();

        if ($total === 0) {
            return 0;
        }

        $completed = CompletedLesson::whereIn('lesson_id', $course->lessons->pluck('id'))
            ->where('user_id', $userId)
            ->count();

        return round(($completed / $total) * 100);
    }
}
