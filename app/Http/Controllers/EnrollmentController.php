<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Services\EnrollmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    protected EnrollmentService $enrollmentService;

    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    /**
     * Enroll user to a course
     */
    public function enroll(Course $course): RedirectResponse|JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Check if already enrolled
        if ($this->enrollmentService->isEnrolled($user, $course)) {
            return $this->jsonOrRedirect(
                'info',
                'Anda sudah mendaftar di course ini.',
                false
            );
        }

        // Perform enrollment
        $enrollment = $this->enrollmentService->enroll($user, $course);

        if ($enrollment) {
            return $this->jsonOrRedirect(
                'success',
                "Berhasil mendaftar di course: {$course->title}",
                true
            );
        }

        return $this->jsonOrRedirect(
            'error',
            'Gagal mendaftar di course. Silakan coba lagi.',
            false
        );
    }

    /**
     * Disenroll user from a course
     */
    public function disenroll(Course $course): RedirectResponse|JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $result = $this->enrollmentService->disenroll($user, $course);

        if ($result) {
            return $this->jsonOrRedirect(
                'success',
                "Berhasil membatalkan pendaftaran dari course: {$course->title}",
                true
            );
        }

        return $this->jsonOrRedirect(
            'info',
            'Anda tidak terdaftar di course ini.',
            false
        );
    }

    /**
     * Get enrollment details for a course
     */
    public function stats(Course $course): JsonResponse
    {
        $stats = $this->enrollmentService->getEnrollmentStats($course);

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get user's course progress
     */
    public function progress(Course $course): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $progress = $this->enrollmentService->getUserCourseProgress($user, $course);

        return response()->json([
            'success' => true,
            'data' => $progress,
        ]);
    }

    /**
     * Get all enrolled users in a course
     */
    public function enrolledUsers(Course $course): JsonResponse
    {
        $users = $this->enrollmentService->getEnrolledUsers($course);

        return response()->json([
            'success' => true,
            'data' => $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'enrolled_at' => $user->pivot->enrolled_at,
                ];
            }),
        ]);
    }

    /**
     * Get user's enrolled courses
     */
    public function myCourses(): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $courses = $this->enrollmentService->getUserEnrolledCourses($user);

        return response()->json([
            'success' => true,
            'data' => $courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'enrolled_at' => $course->pivot->enrolled_at,
                ];
            }),
        ]);
    }

    /**
     * Pause user's enrollment
     */
    public function pause(Course $course): RedirectResponse|JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $reason = request()->input('reason');
        $result = $this->enrollmentService->pauseEnrollment($user, $course, $reason);

        if ($result) {
            return $this->jsonOrRedirect(
                'success',
                'Enrollment ditangguhkan.',
                true
            );
        }

        return $this->jsonOrRedirect(
            'error',
            'Gagal menghentikan enrollment. Silakan coba lagi.',
            false
        );
    }

    /**
     * Resume user's paused enrollment
     */
    public function resume(Course $course): RedirectResponse|JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $result = $this->enrollmentService->resumeEnrollment($user, $course);

        if ($result) {
            return $this->jsonOrRedirect(
                'success',
                'Enrollment dilanjutkan kembali.',
                true
            );
        }

        return $this->jsonOrRedirect(
            'error',
            'Gagal melanjutkan enrollment. Silakan coba lagi.',
            false
        );
    }

    /**
     * Get enrollment timeline statistics
     */
    public function timeline(Course $course): JsonResponse
    {
        $timeline = $this->enrollmentService->getEnrollmentTimeline($course);

        return response()->json([
            'success' => true,
            'data' => $timeline,
        ]);
    }

    /**
     * Helper method to return JSON or redirect based on request type
     */
    protected function jsonOrRedirect(string $type, string $message, bool $success): RedirectResponse|JsonResponse
    {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with($type, $message);
    }
}
