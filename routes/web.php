<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LearningPathController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Models\LearningPath;
use App\Models\User;
use App\Models\Materi;
use App\Models\MateriCompletion;
use App\Models\Course;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user instanceof User && $user->hasAnyRole(['admin', 'super_admin', '2', '3'])) {
        return redirect('/admin');
    }

    // General stats
    $totalMateris = Materi::count();
    $completedMateris = MateriCompletion::query()->where('user_id', $user->id)->count();
    $completionRate = $totalMateris > 0 ? (int) round($completedMateris / $totalMateris * 100) : 0;

    $avgQuizScore = (int) round((float) (QuizAttempt::query()->where('user_id', $user->id)->avg('percentage') ?? 0));

    // Recent activity (completions + quiz attempts)
    $recentCompletions = MateriCompletion::query()
        ->where('user_id', $user->id)
        ->with('materi.course')
        ->orderByDesc('completed_at')
        ->take(6)
        ->get();

    $recentQuizzes = QuizAttempt::query()
        ->where('user_id', $user->id)
        ->with('materi')
        ->orderByDesc('created_at')
        ->take(6)
        ->get();

    // Per-course progress (show top enrolled courses)
    $enrolledCourses = $user->enrolledCourses()->with('materis')->get();

    $coursesProgress = $enrolledCourses->map(function ($course) use ($user) {
        $total = $course->materis->count();
        $completed = 0;
        if ($total > 0) {
            $completed = MateriCompletion::query()
                ->where('user_id', $user->id)
                ->whereIn('materi_id', $course->materis->pluck('id'))
                ->count();
        }
        $progress = $total > 0 ? (int) round($completed / $total * 100) : 0;
        return (object) ['course' => $course, 'progress' => $progress, 'completed' => $completed, 'total' => $total];
    })->sortByDesc('progress')->values();

    $totalCourses = Course::count();
    $enrolledCoursesCount = $enrolledCourses->count();
    $completedCourses = $coursesProgress->where('progress', 100)->count();
    $inProgressCourses = $coursesProgress->where('progress', '>', 0)->where('progress', '<', 100)->count();
    $coursesProgress = $coursesProgress->take(6);
    $totalQuizAttempts = QuizAttempt::query()->where('user_id', $user->id)->count();

    $enrolledCourseIds = $enrolledCourses->pluck('id')->all();
    $preferredCategoryIds = $enrolledCourses->pluck('category_id')->filter()->unique()->all();
    $recommendedCourses = Course::query()
        ->with(['instructor:id,name,photo_path', 'category:id,name'])
        ->when(! empty($preferredCategoryIds), function ($query) use ($preferredCategoryIds) {
            $query->whereIn('category_id', $preferredCategoryIds);
        })
        ->whereNotIn('id', $enrolledCourseIds)
        ->orderByDesc('id')
        ->take(3)
        ->get();

    if ($recommendedCourses->isEmpty()) {
        $recommendedCourses = Course::query()
            ->with(['instructor:id,name,photo_path', 'category:id,name'])
            ->whereNotIn('id', $enrolledCourseIds)
            ->orderByDesc('id')
            ->take(3)
            ->get();
    }

    $certificateReadyCount = $coursesProgress->where('progress', 100)->count();
    $achievementLabel = 'New Learner';
    if ($completionRate >= 80 && $completedCourses > 0) {
        $achievementLabel = 'Certified Learner';
    } elseif ($completionRate >= 50) {
        $achievementLabel = 'Active Learner';
    }

    return view('dashboard', compact(
        'completionRate',
        'avgQuizScore',
        'recentCompletions',
        'recentQuizzes',
        'coursesProgress',
        'completedMateris',
        'totalMateris',
        'totalCourses',
        'enrolledCoursesCount',
        'completedCourses',
        'inProgressCourses',
        'totalQuizAttempts',
        'recommendedCourses',
        'certificateReadyCount',
        'achievementLabel'
    ));
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/roadmap', function () {
        $user = Auth::user();
        $enrolledCourses = $user->enrolledCourses()->with(['category', 'instructor', 'materis'])->get();
        $enrolledCourseIds = $enrolledCourses->pluck('id')->all();
        $completedMateriIds = MateriCompletion::query()->where('user_id', $user->id)->pluck('materi_id')->all();

        $learningPaths = LearningPath::with(['courses.category', 'courses.instructor', 'courses.materis'])
            ->orderBy('name')
            ->get();

        $pathSummaries = $learningPaths->map(function ($path) use ($completedMateriIds, $user) {
            $courses = $path->courses->map(function ($course) use ($completedMateriIds) {
                $total = $course->materis->count();
                $completed = $course->materis->whereIn('id', $completedMateriIds)->count();
                $progress = $total > 0 ? (int) round($completed / $total * 100) : 0;

                return (object) [
                    'course' => $course,
                    'progress' => $progress,
                    'completed' => $completed,
                    'total' => $total,
                    'remaining' => max(0, $total - $completed),
                ];
            });

            $pathProgress = $courses->count() > 0 ? (int) round($courses->avg('progress')) : 0;

            return (object) [
                'path' => $path,
                'courses' => $courses,
                'progress' => $pathProgress,
            ];
        });

        $courseRoadmap = $enrolledCourses->map(function ($course) use ($completedMateriIds) {
            $total = $course->materis->count();
            $completed = $course->materis->whereIn('id', $completedMateriIds)->count();
            $progress = $total > 0 ? (int) round($completed / $total * 100) : 0;

            return (object) [
                'course' => $course,
                'progress' => $progress,
                'completed' => $completed,
                'total' => $total,
                'remaining' => max(0, $total - $completed),
            ];
        })->sortByDesc('progress')->values();

        $preferredCategoryIds = $enrolledCourses->pluck('category_id')->filter()->unique()->all();
        $recommendedCourses = Course::query()
            ->with(['instructor:id,name,photo_path', 'category:id,name'])
            ->when(! empty($preferredCategoryIds), function ($query) use ($preferredCategoryIds) {
                $query->whereIn('category_id', $preferredCategoryIds);
            })
            ->whereNotIn('id', $enrolledCourseIds)
            ->orderByDesc('id')
            ->take(4)
            ->get();

        if ($recommendedCourses->isEmpty()) {
            $recommendedCourses = Course::query()
                ->with(['instructor:id,name,photo_path', 'category:id,name'])
                ->whereNotIn('id', $enrolledCourseIds)
                ->orderByDesc('id')
                ->take(4)
                ->get();
        }

        return view('roadmap', compact('pathSummaries', 'courseRoadmap', 'recommendedCourses'));
    })->name('roadmap');

    Route::get('/analytics', function () {
        $user = Auth::user();
        $period = request('period', '30');
        $allowedPeriods = ['7', '30', '90', 'all'];
        if (! in_array($period, $allowedPeriods, true)) {
            $period = '30';
        }

        $startDate = null;
        if ($period !== 'all') {
            $startDate = Carbon::now()->subDays((int) $period)->startOfDay();
        }

        $enrolledCourses = $user->enrolledCourses()->with('materis')->get();

        $coursesProgress = $enrolledCourses->map(function ($course) use ($user) {
            $total = $course->materis->count();
            $completed = 0;
            if ($total > 0) {
                $completed = MateriCompletion::query()
                    ->where('user_id', $user->id)
                    ->whereIn('materi_id', $course->materis->pluck('id'))
                    ->count();
            }
            $progress = $total > 0 ? (int) round($completed / $total * 100) : 0;
            return (object) ['course' => $course, 'progress' => $progress, 'completed' => $completed, 'total' => $total];
        });

        $completedCourses = $coursesProgress->where('progress', 100)->count();
        $inProgressCourses = $coursesProgress->where('progress', '>', 0)->where('progress', '<', 100)->count();
        $notStartedCourses = $coursesProgress->where('progress', 0)->count();
        $averageCourseProgress = $coursesProgress->count() ? (int) round($coursesProgress->avg('progress')) : 0;

        $quizAttempts = QuizAttempt::query()->where('user_id', $user->id);
        $completionQuery = MateriCompletion::query()->where('user_id', $user->id);
        if ($startDate) {
            $quizAttempts->where('created_at', '>=', $startDate);
            $completionQuery->where('completed_at', '>=', $startDate);
        }

        $totalQuizAttempts = $quizAttempts->count();
        $averageQuizScore = (int) round((float) ($quizAttempts->avg('percentage') ?? 0));
        $recentQuizAttempts = $quizAttempts->with('materi')->orderByDesc('created_at')->take(5)->get();

        $recentCompletions = $completionQuery
            ->with('materi.course')
            ->orderByDesc('completed_at')
            ->take(5)
            ->get();

        $courseBuckets = [
            'Belum mulai' => $notStartedCourses,
            'Sedang berjalan' => $inProgressCourses,
            'Selesai' => $completedCourses,
        ];

        $topCourseProgress = $coursesProgress->sortByDesc('progress')->take(5);

        return view('analytics', compact(
            'enrolledCourses',
            'coursesProgress',
            'completedCourses',
            'inProgressCourses',
            'notStartedCourses',
            'averageCourseProgress',
            'totalQuizAttempts',
            'averageQuizScore',
            'recentQuizAttempts',
            'recentCompletions',
            'courseBuckets',
            'topCourseProgress',
            'period'
        ));
    })->name('analytics');

    // Read-only pages for all authenticated users (user/admin/super_admin).
    Route::resource('articles', ArticleController::class)->only(['index', 'show']);
    Route::resource('categories', CategoryController::class)->only(['index', 'show']);
    Route::resource('courses', CourseController::class)->only(['index', 'show']);
    Route::get('courses/{course}/quiz/{type}', [CourseController::class, 'quiz'])->name('courses.quiz')->where('type', 'pretest|posttest');
    Route::post('courses/{course}/quiz/{type}', [\App\Http\Controllers\CourseQuizController::class, 'store'])->name('courses.quiz.submit')->where('type', 'pretest|posttest');
    Route::get('courses/{course}/quiz/{type}/history', [\App\Http\Controllers\CourseQuizController::class, 'index'])->name('courses.quiz.history')->where('type', 'pretest|posttest');
    Route::get('courses/{course}/certificate', [CourseController::class, 'certificate'])->name('courses.certificate');
    Route::resource('sections', SectionController::class)->only(['index', 'show']);
    Route::resource('materis', MateriController::class)->only(['index', 'show']);
    Route::post('materis/{materi}/complete', [MateriController::class, 'complete'])->name('materis.complete');
    Route::post('materis/{materi}/quiz', [MateriController::class, 'submitQuiz'])->name('materis.quiz.submit');
    Route::get('materis/{materi}/certificate', [MateriController::class, 'certificate'])->name('materis.certificate');

    // Enrollment management
    Route::post('courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');
    Route::post('courses/{course}/disenroll', [EnrollmentController::class, 'disenroll'])->name('courses.disenroll');

    // Comments
    Route::post('courses/{course}/comments', [CommentController::class, 'storeCourse'])->name('courses.comments.store');
    Route::post('materis/{materi}/comments', [CommentController::class, 'storeMateri'])->name('materis.comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Management pages/actions restricted to admin and super_admin.
    Route::middleware('role:admin,super_admin')->group(function () {
        Route::resource('articles', ArticleController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('categories', CategoryController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('courses', CourseController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('sections', SectionController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('materis', MateriController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('learning-paths', LearningPathController::class)->except(['show']);
    });
});

// Route::get('/home', function () {
//     return view('home');
// });

require __DIR__ . '/auth.php';
