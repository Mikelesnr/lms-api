<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Traits\LessonOrganiser;
use App\Traits\NextLessonResolver;

class CourseController extends Controller
{
    use LessonOrganiser, NextLessonResolver;

    public function getCourseLessons(Request $request, int $courseId)
    {
        $authUser = $request->user();

        // Get ordered lessons
        $lessons = $this->getLessonsByCourseIdOrdered($courseId);

        // Get the course instance
        $course = Course::with('lessons')->find($courseId);

        if (!$course) {
            return response()->json([
                'message' => 'Course not found.',
                'lessons' => [],
                'next_lesson' => null,
            ], 404);
        }

        // Get next lesson for the user
        $nextLesson = $this->findNextLesson($course, $authUser->id);

        return response()->json([
            'lessons' => $lessons,
            'next_lesson' => $nextLesson,
        ]);
    }

    // List all courses (for students)
    public function index(Request $request)
    {
        $authUser = $request->user();

        $query = Course::query();

        if ($authUser->role === UserRole::Admin && $request->has('user_id')) {
            // Admin viewing courses by a specific instructor
            $query->where('user_id', $request->input('user_id'));
        } else {
            // Instructor seeing their own courses
            $query->where('user_id', $authUser->id);
        }

        return $query->latest()->get();
    }

    // Get all courses (for API) paginated
    public function getAll()
    {
        $courses = Course::where('is_published', true)
            ->latest()
            ->paginate(12); // Adjust per page as needed

        return response()->json($courses);
    }


    // Show course details
    public function show(Course $course)
    {
        return $course->load(['instructor', 'lessons']);
    }

    // Create a new course (instructor-only)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course = Course::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'user_id' => $request->user()->id,
        ]);

        return response()->json($course, 201);
    }

    // Get featured courses (for homepage)
    public function featured()
    {
        Log::info('Featured courses endpoint accessed.');

        $courses = Cache::remember('featured_courses', now()->addDay(), function () {
            return Course::inRandomOrder()
                ->where('is_published', true)
                ->take(10)
                ->get();
        });

        return response()->json($courses);
    }

    // Get all unique course categories
    public function categories()
    {
        $categories = Course::query()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->values(); // reset array keys for frontend friendliness

        return response()->json($categories);
    }

    // Filter courses based on search criteria
    // Supports title, instructor, or keyword search
    public function filter(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:100',
            'type' => 'nullable|in:title,instructor', // keyword is implicit fallback
            'page' => 'nullable|integer|min:1',
        ]);

        $query = Course::query()->where('is_published', true);

        if ($request->filled('search')) {
            $keyword = $request->input('search');
            $type = $request->input('type');

            // 🎯 Switch behavior based on selected type
            if ($type === 'title') {
                $query->where('title', 'like', "%{$keyword}%");
            } elseif ($type === 'instructor') {
                $query->whereHas('instructor', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            } else {
                // Default keyword mode: flexible title + instructor + description
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%")
                        ->orWhereHas('instructor', function ($q2) use ($keyword) {
                            $q2->where('name', 'like', "%{$keyword}%");
                        });
                });
            }
        }

        $courses = $query->latest()->paginate(12);

        return response()->json($courses);
    }



    // Update an existing course
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);

        // Capture the old 'is_published' state before filling
        $oldIsPublished = $course->is_published;

        // Fill the course with validated data (title, description, and potentially is_published)
        $course->fill($request->only('title', 'description', 'is_published'));

        // Handle published_at logic based on the new 'is_published' value from the request
        if ($request->filled('is_published')) {
            $newIsPublished = $request->input('is_published');

            if ($newIsPublished && !$course->published_at) {
                // If 'is_published' is true and 'published_at' is null, set 'published_at'
                $course->published_at = now();
            } elseif (!$newIsPublished) {
                // If 'is_published' is false, clear 'published_at'
                $course->published_at = null;
            }
            // If 'newIsPublished' is true and 'published_at' is already set, do nothing.
        }
        // If 'is_published' is not filled in the request (i.e., it's null in request), do nothing to published_at.

        $course->save(); // Save the changes

        return response()->json($course);
    }

    // Delete a course
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json(['message' => 'Course deleted']);
    }
}
