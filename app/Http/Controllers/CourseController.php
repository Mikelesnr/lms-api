<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CourseController extends Controller
{
    // List all courses (for students)
    public function index()
    {
        return Course::with('instructor')->latest()->get();
    }

    // Get all courses (for API) paginated
    public function getAll()
    {
        $courses = \App\Models\Course::where('is_published', true)
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
        $courses = Cache::remember('featured_courses', now()->addDay(), function () {
            return \App\Models\Course::inRandomOrder()
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

        $query = \App\Models\Course::query()->where('is_published', true);

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
        $course->update($request->only('title', 'description'));

        return response()->json($course);
    }

    // Delete a course
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json(['message' => 'Course deleted']);
    }
}
