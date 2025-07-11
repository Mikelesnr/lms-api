<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CompletedLessonController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizQuestionController;
use App\Http\Controllers\QuizAnswerController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminCourseController;
use App\Http\Controllers\InstructorOverviewController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

// Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest')->name('register');
// Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest')->name('login');

Route::get('/courses/categories', [CourseController::class, 'categories']);
Route::get('/courses/all', [CourseController::class, 'getAll']);
Route::get('/courses/filter', [CourseController::class, 'filter']);
Route::get('/courses/featured', [CourseController::class, 'featured']);
Route::get('/courses/{course}', [CourseController::class, 'show']);

Route::get('/lessons/{lesson}', [LessonController::class, 'show']);
Route::get('/lessons/student-lessons/{id}', [LessonController::class, 'studentView']);
Route::get('/lessons/{lesson}/quiz', [QuizController::class, 'getByLesson']);

Route::get('/quizzes/{quiz}', [QuizController::class, 'show']);
Route::get('/quiz-questions/{question}', [QuizQuestionController::class, 'show']);
Route::get('/quiz-answers/{answer}', [QuizAnswerController::class, 'show']);

Route::get('/progress', [ProgressController::class, 'index']);
Route::get('/progress/{course}', [ProgressController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());
    Route::put('/users/${id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    Route::get('/instructor/overview', [InstructorOverviewController::class, 'show']);
    Route::get('/instructor/quiz-stats', [InstructorOverviewController::class, 'quizStats']);
    Route::get('/instructor/students', [InstructorOverviewController::class, 'students']);

    Route::get('/enrollments/me', [EnrollmentController::class, 'showMyCourses']);
    Route::get('/enrollments/user/{userId}', [EnrollmentController::class, 'showUserCourses']);
    Route::get('/me/active-enrollments-count', [CompletedLessonController::class, 'activeEnrollmentCount']);
    Route::get('/me/completed-quizzes-count', [CompletedLessonController::class, 'completedQuizCount']);
    Route::get('/me/quiz-analytics', [CompletedLessonController::class, 'quizAnalyticsByCourse']);
    Route::get('/courses/{user_id}', [CourseController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Protected Write Routes (POST, PUT, DELETE)
    |--------------------------------------------------------------------------
    */
    Route::post('/courses', [CourseController::class, 'store']);
    Route::get('/courses', [CourseController::class, 'index']);
    Route::put('/courses/{course}', [CourseController::class, 'update']);
    Route::delete('/courses/{course}', [CourseController::class, 'destroy']);

    Route::post('/lessons', [LessonController::class, 'store']);
    Route::put('/lessons/{lesson}', [LessonController::class, 'update']);
    Route::delete('/lessons/{lesson}', [LessonController::class, 'destroy']);
    Route::post('/lessons/{lesson}/quiz', [QuizController::class, 'store']);

    Route::post('/quizzes', [QuizController::class, 'store']);
    Route::put('/quizzes/{quiz}', [QuizController::class, 'update']);
    Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy']);

    Route::post('/quiz-questions', [QuizQuestionController::class, 'store']);
    Route::put('/quiz-questions/{question}', [QuizQuestionController::class, 'update']);
    Route::delete('/quiz-questions/{question}', [QuizQuestionController::class, 'destroy']);

    Route::post('/quiz-answers', [QuizAnswerController::class, 'store']);
    Route::put('/quiz-answers/{answer}', [QuizAnswerController::class, 'update']);
    Route::delete('/quiz-answers/{answer}', [QuizAnswerController::class, 'destroy']);

    Route::post('/enrollments', [EnrollmentController::class, 'store']);
    Route::post('/my/enrollments', [EnrollmentController::class, 'selfEnroll']);
    Route::delete('/my/enrollments', [EnrollmentController::class, 'selfUnenroll']);
    Route::delete('/enrollments/{user}/{course}', [EnrollmentController::class, 'destroy']);

    Route::post('/completed-lessons', [CompletedLessonController::class, 'store']);
    Route::get('/completed-lessons/grade/{user?}', [CompletedLessonController::class, 'getGrade']);
});

Route::prefix('admin')->middleware(['auth:sanctum', 'can:admin-only'])->group(function () {
    Route::get('instructors', [AdminUserController::class, 'instructors']);
    Route::get('students', [AdminUserController::class, 'students']);
    Route::get('courses', [AdminCourseController::class, 'index']);
    Route::get('courses/{id}', [AdminCourseController::class, 'show']);
    Route::put('users/{user}', [AdminUserController::class, 'update']); // Edit
    Route::patch('users/{user}', [AdminUserController::class, 'updateRole']); // Role only
    Route::delete('users/{user}', [AdminUserController::class, 'destroy']);   // Delete
    Route::get('/stats', [AdminDashboardController::class, 'index']);
    Route::post('/users/{user}/send-password-reset', [AdminUserController::class, 'sendPasswordReset']);
});

/*
|--------------------------------------------------------------------------
| Auth-Focused Subroutes (e.g., Social login, password reset)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(base_path('routes/auth.php'));
