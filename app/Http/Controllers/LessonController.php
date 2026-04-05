<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LessonController extends Controller
{
    public function index(Request $request): View
    {
        $lessons = Lesson::query()
            ->with('section:id,title,course_id')
            ->orderBy('section_id')
            ->orderBy('order')
            ->paginate((int) $request->integer('per_page', 15));

        return view('lessons.index', compact('lessons'));
    }

    public function show(Lesson $lesson): View
    {
        $lesson->load([
            'section:id,title,course_id',
            'questions',
        ]);

        return view('lessons.show', compact('lesson'));
    }

    public function create(): View
    {
        $sections = Section::query()->with('course:id,title')->orderBy('title')->get(['id', 'title', 'course_id']);

        return view('lessons.create', compact('sections'));
    }

    public function store(StoreLessonRequest $request): RedirectResponse
    {
        Lesson::create($request->validated());

        return redirect()->route('lessons.index')->with('success', 'Lesson berhasil dibuat.');
    }

    public function edit(Lesson $lesson): View
    {
        $sections = Section::query()->with('course:id,title')->orderBy('title')->get(['id', 'title', 'course_id']);

        return view('lessons.edit', compact('lesson', 'sections'));
    }

    public function update(UpdateLessonRequest $request, Lesson $lesson): RedirectResponse
    {
        $lesson->update($request->validated());

        return redirect()->route('lessons.show', $lesson)->with('success', 'Lesson berhasil diupdate.');
    }

    public function destroy(Lesson $lesson): RedirectResponse
    {
        $lesson->delete();

        return redirect()->route('lessons.index')->with('success', 'Lesson berhasil dihapus.');
    }
}
