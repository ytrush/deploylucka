<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(Request $request): View
    {
        $sections = Section::query()
            ->with('course:id,title,instructor_id')
            ->orderBy('course_id')
            ->orderBy('order')
            ->paginate((int) $request->integer('per_page', 15));

        return view('sections.index', compact('sections'));
    }

    public function show(Section $section): View
    {
        $section->load([
            'course:id,title,instructor_id',
        ]);

        return view('sections.show', compact('section'));
    }

    public function create(): View
    {
        $courses = Course::query()->orderBy('title')->get(['id', 'title']);

        return view('sections.create', compact('courses'));
    }

    public function store(StoreSectionRequest $request): RedirectResponse
    {
        Section::create($request->validated());

        return redirect()->route('sections.index')->with('success', 'Section berhasil dibuat.');
    }

    public function edit(Section $section): View
    {
        $courses = Course::query()->orderBy('title')->get(['id', 'title']);

        return view('sections.edit', compact('section', 'courses'));
    }

    public function update(UpdateSectionRequest $request, Section $section): RedirectResponse
    {
        $section->update($request->validated());

        return redirect()->route('sections.show', $section)->with('success', 'Section berhasil diupdate.');
    }

    public function destroy(Section $section): RedirectResponse
    {
        $section->delete();

        return redirect()->route('sections.index')->with('success', 'Section berhasil dihapus.');
    }
}
