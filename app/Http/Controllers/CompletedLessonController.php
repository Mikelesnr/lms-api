<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
