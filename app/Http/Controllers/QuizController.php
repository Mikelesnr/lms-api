<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

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
