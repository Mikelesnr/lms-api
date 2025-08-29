<?php

namespace App\Traits;

use App\Models\Lesson;
use App\Models\Course;

trait LessonOrganiser // <-- Renamed trait name
{
    /**
     * Get all lessons for a specific course, ordered by their 'order' column.
     *
     * @param int $courseId The ID of the course.
     * @return \Illuminate\Support\Collection|\App\Models\Lesson[] An ordered collection of Lesson models.
     */
    public function getLessonsByCourseIdOrdered(int $courseId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return collect([]); // Return an empty collection if course not found
        }

        // Retrieve lessons for the course, ordered by 'order' as per Lesson model
        return $course->lessons()->orderBy('order')->get();
    }
}
