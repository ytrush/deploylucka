<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\MateriCompletion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCategoryId = $request->integer('category_id');
        $search = trim((string) $request->input('search', ''));
        $user = Auth::user();

        $courses = Course::query()
            ->with(['instructor:id,name,photo_path', 'category:id,name'])
            ->when($selectedCategoryId > 0, function ($query) use ($selectedCategoryId) {
                $query->where('category_id', $selectedCategoryId);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('id')
            ->paginate((int) $request->integer('per_page', 15));

        $courses->appends($request->query());

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $enrolledCourseIds = $user ? $user->enrolledCourses()->pluck('courses.id')->toArray() : [];
        $preferredCategoryIds = $user ? $user->enrolledCourses()->pluck('category_id')->filter()->unique()->toArray() : [];

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

        return view('courses.index', compact(
            'courses',
            'categories',
            'selectedCategoryId',
            'enrolledCourseIds',
            'search',
            'recommendedCourses'
        ));
    }

    protected function ensureEnrolled(Course $course): ?\Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        if (! $user || $user->hasAnyRole(['admin', 'super_admin', '2', '3'])) {
            return null;
        }

        if (! $course->isEnrolledBy($user)) {
            return redirect()->route('courses.index')->with('error', 'Silakan daftar course ini terlebih dahulu untuk mengaksesnya.');
        }

        return null;
    }

    public function show(Course $course): View|\Illuminate\Http\RedirectResponse
    {
        if ($redirect = $this->ensureEnrolled($course)) {
            return $redirect;
        }

        $course->load([
            'instructor:id,name,photo_path',
            'category:id,name',
            'materis',
            'comments.user',
            'comments.replies.user',
        ]);

        $completedMateriIds = MateriCompletion::query()
            ->where('user_id', Auth::id())
            ->whereIn('materi_id', $course->materis->pluck('id'))
            ->pluck('materi_id')
            ->all();

        $progress = $course->getProgressPercentage();
        $hasCertificate = $course->materis->count() > 0 && count($completedMateriIds) === $course->materis->count();

        return view('courses.show', compact('course', 'completedMateriIds', 'progress', 'hasCertificate'));
    }

    public function quiz(Course $course, string $type): View|\Illuminate\Http\RedirectResponse
    {
        if (! in_array($type, ['pretest', 'posttest'], true)) {
            abort(404);
        }

        if ($redirect = $this->ensureEnrolled($course)) {
            return $redirect;
        }

        $course->load([
            'instructor:id,name,photo_path',
            'category:id,name',
            'materis',
            'sections',
        ]);

        $questions = $course->questions()->with('options')->get();
        $quizLabel = $type === 'pretest' ? 'Pretest' : 'Pos Test';
        $submittedAnswers = [];

        return view('courses.quiz', compact('course', 'type', 'quizLabel', 'questions', 'submittedAnswers'));
    }

    public function submitQuiz(Request $request, Course $course, string $type): View|\Illuminate\Http\RedirectResponse
    {
        if (! in_array($type, ['pretest', 'posttest'], true)) {
            abort(404);
        }

        if ($redirect = $this->ensureEnrolled($course)) {
            return $redirect;
        }

        $course->load([
            'instructor:id,name,photo_path',
            'category:id,name',
            'materis',
            'sections',
        ]);

        $questions = $course->questions()->with('options')->get();

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'nullable|integer|exists:question_options,id',
        ]);

        $submittedAnswers = $validated['answers'];
        $totalPoints = $questions->sum('points');
        $earnedPoints = 0;
        $correctCount = 0;

        $review = $questions->map(function ($question) use ($submittedAnswers, &$earnedPoints, &$correctCount) {
            $selectedOptionId = $submittedAnswers[$question->id] ?? null;
            $selectedOption = $question->options->firstWhere('id', $selectedOptionId);
            $correctOption = $question->options->firstWhere('is_correct', true);
            $isCorrect = $selectedOption?->is_correct ?? false;

            if ($isCorrect) {
                $earnedPoints += $question->points;
                $correctCount++;
            }

            return [
                'question' => $question,
                'selectedOptionId' => $selectedOptionId,
                'selectedOption' => $selectedOption,
                'correctOption' => $correctOption,
                'isCorrect' => $isCorrect,
            ];
        });

        $percentage = $totalPoints > 0 ? (int) round(($earnedPoints / $totalPoints) * 100) : 0;
        $passed = $percentage >= 80;
        $quizLabel = $type === 'pretest' ? 'Pretest' : 'Pos Test';

        $results = [
            'questions' => $questions->count(),
            'correct' => $correctCount,
            'total_points' => $totalPoints,
            'earned_points' => $earnedPoints,
            'percentage' => $percentage,
            'passed' => $passed,
        ];

        return view('courses.quiz', compact('course', 'type', 'quizLabel', 'review', 'submittedAnswers', 'results'));
    }

    public function certificate(Course $course): View|\Illuminate\Http\RedirectResponse
    {
        if ($redirect = $this->ensureEnrolled($course)) {
            return $redirect;
        }

        $course->load('materis');

        $totalMateris = $course->materis->count();
        $completedMateriIds = MateriCompletion::query()
            ->where('user_id', Auth::id())
            ->whereIn('materi_id', $course->materis->pluck('id'))
            ->pluck('materi_id')
            ->all();

        if ($totalMateris === 0 || count($completedMateriIds) !== $totalMateris) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'Selesaikan semua materi terlebih dahulu untuk mendapatkan sertifikat.');
        }

        $completionDate = MateriCompletion::query()
            ->where('user_id', Auth::id())
            ->whereIn('materi_id', $course->materis->pluck('id'))
            ->max('completed_at');

        return view('courses.certificate', compact('course', 'completionDate'));
    }

    public function create(): View
    {
        $instructors = Instructor::query()
            ->orderBy('name')
            ->get(['id', 'name', 'photo_path']);

        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('courses.create', compact('instructors', 'categories'));
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        Course::create($data);

        return redirect()->route('courses.index')->with('success', 'Course berhasil dibuat.');
    }

    public function edit(Course $course): View
    {
        $instructors = Instructor::query()
            ->orderBy('name')
            ->get(['id', 'name', 'photo_path']);

        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('courses.edit', compact('course', 'instructors', 'categories'));
    }

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $data = $request->validated();

        // Handle image removal
        if ($request->input('image_remove') == '1' && $course->image) {
            Storage::disk('public')->delete($course->image);
            $data['image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('courses.show', $course)->with('success', 'Course berhasil diupdate.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course berhasil dihapus.');
    }
}
