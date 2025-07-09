<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Enums\UserRole;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'instructors' => User::where('role', UserRole::Instructor)->count(),
            'students' => User::where('role', UserRole::Student)->count(),
            'courses' => Course::count(),
        ]);
    }
}
