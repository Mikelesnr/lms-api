<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\Lesson;

class QuizController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
        ]);

        // 🚫 Check if the lesson already has a quiz
        $existing = \App\Models\Quiz::where('lesson_id', $data['lesson_id'])->first();

        if ($existing) {
            return response()->json(['message' => 'This lesson already has a quiz.'], 409);
        }

        // ✅ Create new quiz
        $quiz = \App\Models\Quiz::create([
            'lesson_id' => $data['lesson_id'],
            'title' => $data['title'],
        ]);

        return response()->json(['quiz' => $quiz], 201);
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
