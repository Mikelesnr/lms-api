<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Container\Attributes\Log;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CompletedLessonController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\QuizQuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizAnswerController;

//public API routes are defined here
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');


Route::get('/courses/categories', [CourseController::class, 'categories']);

// 📚 Get all published courses with pagination
Route::get('/courses/all', [CourseController::class, 'getAll']);

// 🔍 Filter courses by title, instructor, or general keyword (with pagination)
Route::get('/courses/filter', [CourseController::class, 'filter']);

// 🔥 Get 10 featured (random, cached) courses
Route::get('/courses/featured', [CourseController::class, 'featured']);


Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

//protected routes
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('courses')->controller(CourseController::class)->group(function () {
    Route::get('/', 'index');             // List all courses
    Route::post('/', 'store');            // Create a course
    Route::get('{course}', 'show');       // Show specific course
    Route::put('{course}', 'update');     // Update a course
    Route::delete('{course}', 'destroy'); // Delete a course
});

Route::prefix('lessons')->controller(LessonController::class)->group(function () {
    Route::get('/', 'index');                 // List all lessons`
    Route::post('/', 'store');                // Create a lesson
    Route::get('/{lesson}', 'show');           // View a specific lesson
    Route::get('/student-lessons/{id}', [LessonController::class, 'studentView']); // View a lesson for students
    Route::put('/{lesson}', 'update');         // Update a lesson
    Route::delete('/{lesson}', 'destroy');     // Delete a lesson
});

Route::prefix('enrollments')->controller(EnrollmentController::class)->group(function () {
    Route::post('/', 'store');
    Route::get('/user/{userId}', 'showUserCourses');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/enrollments/me', [EnrollmentController::class, 'showMyCourses']);
    Route::post('/completed-lessons', [CompletedLessonController::class, 'store']);
    Route::get('/completed-lessons/grade/{user?}', [
        CompletedLessonController::class,
        'getGrade',
    ]);

    // Student self-enroll route (uses authenticated user internally)
    Route::post('/my/enrollments', [EnrollmentController::class, 'selfEnroll']);
    // Student self-unenroll route (uses authenticated user internally)
    Route::delete('/my/enrollments', [EnrollmentController::class, 'selfUnenroll']);

    // Unenroll a user from a course (admin/instructor use)
    Route::delete('/enrollments/{user}/{course}', [EnrollmentController::class, 'destroy']);

    // Other protected student routes...
});

Route::prefix('progress')->controller(ProgressController::class)->group(function () {
    Route::get('/', 'index'); // Get progress for all courses user is enrolled in
    Route::get('/{course}', 'show'); // Get progress for a specific course
});

Route::prefix('quizzes')->controller(QuizController::class)->group(function () {
    Route::post('/', 'store');
    Route::get('{quiz}', 'show');
    Route::put('{quiz}', 'update');
    Route::delete('{quiz}', 'destroy');
});

// Get quiz by lesson
// This route retrieves the quiz associated with a specific lesson
// It uses the lesson ID to find the quiz and returns it along with its questions and answers
Route::get('/lessons/{lesson}/quiz', [QuizController::class, 'getByLesson']);

Route::prefix('quiz-questions')->controller(QuizQuestionController::class)->group(function () {
    Route::post('/', 'store');
    Route::get('{question}', 'show');
    Route::put('{question}', 'update');
    Route::delete('{question}', 'destroy');
});


Route::prefix('quiz-answers')->controller(QuizAnswerController::class)->group(function () {
    Route::post('/', 'store');
    Route::get('{answer}', 'show');
    Route::put('{answer}', 'update');
    Route::delete('{answer}', 'destroy');
});

Route::prefix('auth')->group(base_path('routes/auth.php'));
