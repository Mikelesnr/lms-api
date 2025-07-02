<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizQuestion;

class QuizQuestionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string|max:1000',
        ]);

        $question = QuizQuestion::create($request->all());

        return response()->json($question, 201);
    }

    public function show(QuizQuestion $question)
    {
        return response()->json($question->load('answers'));
    }

    public function update(Request $request, QuizQuestion $question)
    {
        $request->validate([
            'question_text' => 'sometimes|required|string|max:1000',
        ]);

        $question->update($request->only('question_text'));

        return response()->json($question);
    }

    public function destroy(QuizQuestion $question)
    {
        $question->delete();

        return response()->json(['message' => 'Question deleted']);
    }
}
