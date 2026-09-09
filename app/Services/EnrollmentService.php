<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class EnrollmentService
{
    /**
     * Enroll a user to a course
     */
    public function enroll(User $user, Course $course): Enrollment|false
    {
        // Check if already enrolled
        if ($this->isEnrolled($user, $course)) {
            return false;
        }

        return Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'enrolled_at' => now(),
        ]);
    }

    /**
     * Disenroll a user from a course
     */
    public function disenroll(User $user, Course $course): bool
    {
        return (bool) Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->delete();
    }

    /**
     * Check if user is enrolled in a course
     */
    public function isEnrolled(User $user, Course $course): bool
    {
        return $course->isEnrolledBy($user);
    }

    /**
     * Get all enrolled users in a course
     */
    public function getEnrolledUsers(Course $course): Collection
    {
        return $course->enrolledUsers()->get();
    }

    /**
     * Get enrollment count for a course
     */
    public function getEnrollmentCount(Course $course): int
    {
        return $course->enrollments()->count();
    }

    /**
     * Get all courses enrolled by a user
     */
    public function getUserEnrolledCourses(User $user): Collection
    {
        return $user->enrolledCourses()->get();
    }

    /**
     * Get enrollment statistics
     */
    public function getEnrollmentStats(Course $course): array
    {
        $totalEnrollments = $this->getEnrollmentCount($course);
        $enrolledUsers = $this->getEnrolledUsers($course);

        $activeUsers = $enrolledUsers->filter(function ($user) use ($course) {
            return $course->materis()
                ->whereHas('completions', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->exists();
        })->count();

        return [
            'total_enrollments' => $totalEnrollments,
            'active_learners' => $activeUsers,
            'inactive_learners' => max(0, $totalEnrollments - $activeUsers),
            'engagement_rate' => $totalEnrollments > 0 ? (int) round(($activeUsers / $totalEnrollments) * 100) : 0,
        ];
    }

    /**
     * Bulk enroll users to a course
     */
    public function bulkEnroll(array $userIds, Course $course): array
    {
        $result = [
            'success' => 0,
            'failed' => 0,
            'already_enrolled' => 0,
        ];

        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if (!$user) {
                $result['failed']++;
                continue;
            }

            if ($this->isEnrolled($user, $course)) {
                $result['already_enrolled']++;
                continue;
            }

            if ($this->enroll($user, $course)) {
                $result['success']++;
            } else {
                $result['failed']++;
            }
        }

        return $result;
    }

    /**
     * Get user's enrollment progress in a course
     */
    public function getUserCourseProgress(User $user, Course $course): array
    {
        $totalMateris = $course->materis()->count();

        if ($totalMateris === 0) {
            return [
                'total_materis' => 0,
                'completed_materis' => 0,
                'percentage' => 0,
            ];
        }

        $completedMateris = \App\Models\MateriCompletion::query()
            ->where('user_id', $user->id)
            ->whereIn('materi_id', $course->materis()->pluck('id'))
            ->count();

        return [
            'total_materis' => $totalMateris,
            'completed_materis' => $completedMateris,
            'percentage' => (int) round(($completedMateris / $totalMateris) * 100),
        ];
    }

    /**
     * Pause user's enrollment
     */
    public function pauseEnrollment(User $user, Course $course, string $reason = null): bool
    {
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return false;
        }

        return $enrollment->pause($reason);
    }

    /**
     * Resume user's paused enrollment
     */
    public function resumeEnrollment(User $user, Course $course): bool
    {
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return false;
        }

        return $enrollment->resume();
    }

    /**
     * Mark enrollment as completed
     */
    public function completeEnrollment(User $user, Course $course): bool
    {
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return false;
        }

        return $enrollment->markCompleted();
    }

    /**
     * Get enrollments by status
     */
    public function getEnrollmentsByStatus(Course $course, string $status): Collection
    {
        return $course->enrollments()
            ->where('status', $status)
            ->with('user')
            ->get();
    }

    /**
     * Get enrollment timeline for a course
     */
    public function getEnrollmentTimeline(Course $course): array
    {
        $enrollments = $course->enrollments()
            ->orderBy('enrolled_at', 'desc')
            ->get();

        return [
            'total' => $enrollments->count(),
            'by_month' => $enrollments->groupBy(function ($enrollment) {
                return $enrollment->enrolled_at->format('Y-m');
            })->map(function ($group) {
                return $group->count();
            })->toArray(),
            'by_status' => $enrollments->groupBy('status')->map(function ($group) {
                return $group->count();
            })->toArray(),
        ];
    }
}
