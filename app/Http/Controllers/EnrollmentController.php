<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function enroll(Course $course): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Check if already enrolled
        if ($course->isEnrolledBy($user)) {
            return redirect()->back()->with('info', 'Anda sudah mendaftar di course ini.');
        }

        // Create enrollment
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        return redirect()->back()->with('success', "Berhasil mendaftar di course: {$course->title}");
    }

    public function disenroll(Course $course): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Delete enrollment
        Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->delete();

        return redirect()->back()->with('success', "Berhasil membatalkan pendaftaran dari course: {$course->title}");
    }
}
