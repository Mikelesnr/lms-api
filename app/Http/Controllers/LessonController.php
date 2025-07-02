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
