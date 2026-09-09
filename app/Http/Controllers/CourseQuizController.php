<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseQuizAttempt;
use App\Models\CourseQuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CourseQuizController extends Controller
{
    public function index(Course $course, string $type): View
    {
        abort_unless(in_array($type, ['pretest', 'posttest'], true), 404);

        $testTypeValue = $type === 'pretest' ? 'pre_test' : 'post_test';

        $course->load(['questions' => function ($q) use ($testTypeValue) {
            $q->where('test_type', $testTypeValue)->with('options');
        }]);

        $quizLabel = $type === 'pretest' ? 'Pretest' : 'Pos Test';

        $attempts = CourseQuizAttempt::query()
            ->where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('type', $type)
            ->whereHas('course', function ($q) use ($course) {
                $q->where('id', $course->id);
            })
            ->with('answers.question', 'answers.questionOption')
            ->orderByDesc('created_at')
            ->get();

        return view('courses.quiz_history', compact('course', 'type', 'quizLabel', 'attempts'));
    }

    public function store(Request $request, Course $course, string $type): View
    {
        abort_unless(in_array($type, ['pretest', 'posttest'], true), 404);

        $testTypeValue = $type === 'pretest' ? 'pre_test' : 'post_test';

        $course->load(['questions' => function ($q) use ($testTypeValue) {
            $q->where('test_type', $testTypeValue)->with('options');
        }]);


        $questions = $course->questions;

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'nullable|integer|exists:question_options,id',
        ]);

        $submittedAnswers = $validated['answers'];

        $totalPoints = $questions->sum('points');
        $earnedPoints = 0;
        $correctCount = 0;

        $answers = [];

        $review = $questions->map(function ($question) use ($submittedAnswers, &$earnedPoints, &$correctCount, &$answers) {
            $selectedOptionId = $submittedAnswers[$question->id] ?? null;
            $selectedOption = $question->options->firstWhere('id', $selectedOptionId);
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
                'selectedOption' => $selectedOption,
                'selectedOptionId' => $selectedOptionId,
                'correctOption' => $question->options->firstWhere('is_correct', true),
                'isCorrect' => $isCorrect,
            ];
        });

        $percentage = $totalPoints > 0 ? (int) round(($earnedPoints / $totalPoints) * 100) : 0;
        $passed = $percentage >= 80;
        $quizLabel = $type === 'pretest' ? 'Pretest' : 'Pos Test';

        DB::beginTransaction();
        try {
            $attempt = CourseQuizAttempt::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'type' => $type,
                'total_questions' => $questions->count(),
                'correct_answers' => $correctCount,
                'total_points' => $totalPoints,
                'earned_points' => $earnedPoints,
                'percentage' => $percentage,
                'passed' => $passed,
            ]);

            foreach ($answers as $answer) {
                CourseQuizAnswer::create([
                    'course_quiz_attempt_id' => $attempt->id,
                    ...$answer,
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
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

        return view('courses.quiz', compact('course', 'type', 'quizLabel', 'review', 'submittedAnswers', 'results'));
    }
}
