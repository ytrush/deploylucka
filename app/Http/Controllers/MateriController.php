<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMateriRequest;
use App\Http\Requests\UpdateMateriRequest;
use App\Models\Course;
use App\Models\Materi;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use App\Models\MateriCompletion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MateriController extends Controller
{
    public function index(Request $request): View
    {
        $materis = Materi::query()
            ->with('course:id,title')
            ->orderBy('course_id')
            ->orderBy('order')
            ->paginate((int) $request->integer('per_page', 15));

        return view('materis.index', compact('materis'));
    }

    protected function ensureMateriAccess(Materi $materi): ?\Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $materi->load('course');

        if (! $materi->course || ! $materi->course->isEnrolledBy($user)) {
            return redirect()->route('courses.index')->with('error', 'Silakan daftar course terkait terlebih dahulu untuk mengakses materi.');
        }

        return null;
    }

    public function show(Materi $materi): View|\Illuminate\Http\RedirectResponse
    {
        if ($redirect = $this->ensureMateriAccess($materi)) {
            return $redirect;
        }

        $materi->load([
            'course:id,title',
            'questions',
            'comments.user',
            'comments.replies.user',
        ]);

        $quizAttempts = QuizAttempt::query()
            ->where('user_id', Auth::id())
            ->where('materi_id', $materi->id)
            ->with('answers.question', 'answers.questionOption')
            ->orderByDesc('created_at')
            ->get();

        $videoCompleted = MateriCompletion::query()
            ->where('user_id', Auth::id())
            ->where('materi_id', $materi->id)
            ->exists();

        return view('materis.show', compact('materi', 'quizAttempts', 'videoCompleted'));
    }

    public function complete(Materi $materi): JsonResponse
    {
        if ($redirect = $this->ensureMateriAccess($materi)) {
            return response()->json([
                'success' => false,
                'message' => $redirect->getSession()->get('error'),
            ], 403);
        }

        $completion = MateriCompletion::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'materi_id' => $materi->id,
            ],
            [
                'completed_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'completed' => true,
            'completed_at' => $completion->completed_at?->toDateTimeString(),
        ]);
    }

    public function submitQuiz(Request $request, Materi $materi): View|\Illuminate\Http\RedirectResponse
    {
        if ($redirect = $this->ensureMateriAccess($materi)) {
            return $redirect;
        }

        $materi->load([
            'course:id,title',
            'questions.options',
        ]);

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'nullable|integer|exists:question_options,id',
        ]);

        $questions = $materi->questions;
        $submittedAnswers = $validated['answers'];
        $totalPoints = $questions->sum('points');
        $earnedPoints = 0;
        $correctCount = 0;
        $answers = [];

        $review = $questions->map(function ($question) use ($submittedAnswers, &$earnedPoints, &$correctCount, &$answers) {
            $selectedOptionId = $submittedAnswers[$question->id] ?? null;
            $selectedOption = $question->options->firstWhere('id', $selectedOptionId);
            $correctOption = $question->options->firstWhere('is_correct', true);
            $isCorrect = $selectedOption?->is_correct ?? false;
            $pointsEarned = 0;

            if ($isCorrect) {
                $earnedPoints += $question->points;
                $correctCount++;
                $pointsEarned = $question->points;
            }

            $answers[] = [
                'question_id' => $question->id,
                'question_option_id' => $selectedOptionId,
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned,
            ];

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

        // Save quiz attempt
        DB::beginTransaction();
        try {
            $quizAttempt = QuizAttempt::create([
                'user_id' => Auth::id(),
                'materi_id' => $materi->id,
                'total_questions' => $questions->count(),
                'correct_answers' => $correctCount,
                'total_points' => $totalPoints,
                'earned_points' => $earnedPoints,
                'percentage' => $percentage,
                'passed' => $passed,
            ]);

            foreach ($answers as $answer) {
                QuizAnswer::create([
                    'quiz_attempt_id' => $quizAttempt->id,
                    ...$answer,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        $results = [
            'questions' => $questions->count(),
            'correct' => $correctCount,
            'total_points' => $totalPoints,
            'earned_points' => $earnedPoints,
            'percentage' => $percentage,
            'passed' => $passed,
        ];

        $quizAttempts = QuizAttempt::query()
            ->where('user_id', Auth::id())
            ->where('materi_id', $materi->id)
            ->with('answers.question', 'answers.questionOption')
            ->orderByDesc('created_at')
            ->get();

        return view('materis.show', compact('materi', 'review', 'submittedAnswers', 'results', 'quizAttempts'));
    }

    public function certificate(Materi $materi): View|\Illuminate\Http\RedirectResponse
    {
        if ($redirect = $this->ensureMateriAccess($materi)) {
            return $redirect;
        }

        $materi->load('course');

        // Check if user has passed the quiz for this materi
        $passedAttempt = QuizAttempt::query()
            ->where('user_id', Auth::id())
            ->where('materi_id', $materi->id)
            ->where('passed', true)
            ->orderByDesc('created_at')
            ->first();

        if (! $passedAttempt) {
            return redirect()->route('materis.show', $materi)
                ->with('error', 'Selesaikan dan lulus quiz terlebih dahulu untuk mendapatkan sertifikat.');
        }

        $completionDate = $passedAttempt->created_at;

        return view('materis.certificate', compact('materi', 'completionDate'));
    }

    public function create(): View
    {
        $courses = Course::query()->orderBy('title')->get(['id', 'title']);

        return view('materis.create', compact('courses'));
    }

    public function store(StoreMateriRequest $request): RedirectResponse
    {
        Materi::create($request->validated());

        return redirect()->route('materis.index')->with('success', 'Materi berhasil dibuat.');
    }

    public function edit(Materi $materi): View
    {
        $courses = Course::query()->orderBy('title')->get(['id', 'title']);

        return view('materis.edit', compact('materi', 'courses'));
    }

    public function update(UpdateMateriRequest $request, Materi $materi): RedirectResponse
    {
        $materi->update($request->validated());

        return redirect()->route('materis.show', $materi)->with('success', 'Materi berhasil diupdate.');
    }

    public function destroy(Materi $materi): RedirectResponse
    {
        $materi->delete();

        return redirect()->route('materis.index')->with('success', 'Materi berhasil dihapus.');
    }
}
