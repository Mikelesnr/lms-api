<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'nullable|string|max:255',
        ]);

        $quiz = \App\Models\Quiz::create($request->all());

        return response()->json($quiz, 201);
    }

    public function getByLesson($lessonId)
    {
        $quiz = Quiz::with('questions.answers')->where('lesson_id', $lessonId)->first();

        if (!$quiz) {
            return response()->json(null, 404); // Optional: return 204 or null gracefully
        }

        return response()->json($quiz);
    }


    public function show(\App\Models\Quiz $quiz)
    {
        return $quiz->load('questions.answers');
    }

    public function update(Request $request, Quiz $quiz)
    {
        $quiz->update($request->only('title'));
        return response()->json($quiz);
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return response()->json(['message' => 'Quiz deleted']);
    }
}
