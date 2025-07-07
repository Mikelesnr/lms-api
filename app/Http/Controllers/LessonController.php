<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'order' => 'nullable|integer',
        ]);

        $lesson = \App\Models\Lesson::create($request->all());

        return response()->json($lesson, 201);
    }

    public function show(Lesson $lesson)
    {
        return response()->json($lesson);
    }

    public function studentView($id)
    {
        $lesson = Lesson::with(['quiz', 'course.lessons'])->findOrFail($id);

        $orderedLessons = $lesson->course->lessons->sortBy('order')->values();
        $currentIndex = $orderedLessons->search(fn($l) => $l->id === $lesson->id);

        $previousLesson = $currentIndex > 0
            ? $orderedLessons[$currentIndex - 1]
            : null;

        $nextLesson = $currentIndex < $orderedLessons->count() - 1
            ? $orderedLessons[$currentIndex + 1]
            : null;

        return response()->json([
            'id' => $lesson->id,
            'title' => $lesson->title,
            'content' => $lesson->content,
            'video_url' => $lesson->video_url,
            'quiz' => $lesson->quiz,
            'previous_lesson' => $previousLesson
                ? ['id' => $previousLesson->id, 'title' => $previousLesson->title]
                : null,
            'next_lesson' => $nextLesson
                ? ['id' => $nextLesson->id, 'title' => $nextLesson->title]
                : null,
        ]);
    }

    public function update(Request $request, \App\Models\Lesson $lesson)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'order' => 'nullable|integer',
        ]);

        $lesson->update($request->only('title', 'content', 'video_url', 'order'));

        return response()->json($lesson);
    }

    public function destroy(\App\Models\Lesson $lesson)
    {
        $lesson->delete();

        return response()->json(['message' => 'Lesson deleted']);
    }
}
