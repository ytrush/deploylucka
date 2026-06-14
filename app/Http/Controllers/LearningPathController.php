<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\LearningPath;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LearningPathController extends Controller
{
    public function index(): View
    {
        $learningPaths = LearningPath::withCount('courses')->orderBy('name')->get();

        return view('learning-paths.index', compact('learningPaths'));
    }

    public function create(): View
    {
        $courses = Course::orderBy('title')->get();

        return view('learning-paths.create', compact('courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'courses' => 'nullable|array',
            'courses.*' => 'integer|exists:courses,id',
        ]);

        $learningPath = LearningPath::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        if (! empty($validated['courses'])) {
            $syncData = [];
            foreach ($validated['courses'] as $index => $courseId) {
                $syncData[$courseId] = ['position' => $index + 1];
            }
            $learningPath->courses()->sync($syncData);
        }

        return redirect()->route('learning-paths.index')->with('success', 'Learning path berhasil disimpan.');
    }

    public function edit(LearningPath $learningPath): View
    {
        $courses = Course::orderBy('title')->get();
        $selectedCourses = $learningPath->courses->pluck('id')->all();

        return view('learning-paths.edit', compact('learningPath', 'courses', 'selectedCourses'));
    }

    public function update(Request $request, LearningPath $learningPath): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'courses' => 'nullable|array',
            'courses.*' => 'integer|exists:courses,id',
        ]);

        $learningPath->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        $syncData = [];
        if (! empty($validated['courses'])) {
            foreach ($validated['courses'] as $index => $courseId) {
                $syncData[$courseId] = ['position' => $index + 1];
            }
        }
        $learningPath->courses()->sync($syncData);

        return redirect()->route('learning-paths.index')->with('success', 'Learning path berhasil diperbarui.');
    }

    public function destroy(LearningPath $learningPath): RedirectResponse
    {
        $learningPath->courses()->detach();
        $learningPath->delete();

        return redirect()->route('learning-paths.index')->with('success', 'Learning path berhasil dihapus.');
    }
}
