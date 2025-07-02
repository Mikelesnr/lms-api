<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizAnswer;

class QuizAnswerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:quiz_questions,id',
            'answer_text' => 'required|string|max:1000',
            'is_correct' => 'required|boolean',
        ]);

        $answer = QuizAnswer::create($request->all());

        return response()->json($answer, 201);
    }

    public function update(Request $request, QuizAnswer $answer)
    {
        $request->validate([
            'answer_text' => 'sometimes|required|string|max:1000',
            'is_correct' => 'sometimes|required|boolean',
        ]);

        $answer->update($request->only('answer_text', 'is_correct'));

        return response()->json($answer);
    }

    public function destroy(QuizAnswer $answer)
    {
        $answer->delete();

        return response()->json(['message' => 'Answer deleted']);
    }

    public function show(QuizAnswer $answer)
    {
        return response()->json($answer);
    }
}
