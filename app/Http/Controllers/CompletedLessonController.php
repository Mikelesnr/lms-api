<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompletedLessonController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        $completion = \App\Models\CompletedLesson::firstOrCreate($request->only('user_id', 'lesson_id'));

        return response()->json($completion, 201);
    }
}
