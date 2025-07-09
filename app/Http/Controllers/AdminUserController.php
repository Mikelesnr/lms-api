<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Enum;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Password;

class AdminUserController extends Controller
{
    public function instructors()
    {
        return User::withCount('courses')
            ->where('role', UserRole::Instructor)
            ->paginate(10); // You can adjust the page size
    }

    public function students()
    {
        return User::withCount('enrollments')
            ->where('role', UserRole::Student)
            ->paginate(10);
    }

    public function sendPasswordReset(User $user)
    {
        $status = Password::sendResetLink([
            'email' => $user->email,
        ]);

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Password reset email sent.'])
            : response()->json(['message' => 'Failed to send reset email.'], 500);
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', new Enum(UserRole::class)],
        ]);

        $user->update([
            'role' => UserRole::from($request->role),
        ]);

        return response()->json(['message' => 'Role updated successfully']);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['sometimes', new Enum(UserRole::class)],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json(['message' => 'User updated', 'user' => $user]);
    }


    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
