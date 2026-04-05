<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $courses = Course::query()
            ->with('instructor:id,name,email,role')
            ->orderByDesc('id')
            ->paginate((int) $request->integer('per_page', 15));

        return view('courses.index', compact('courses'));
    }

    public function show(Course $course): View
    {
        $course->load([
            'instructor:id,name,email,role',
            'sections.lessons',
        ]);

        return view('courses.show', compact('course'));
    }

    public function create(): View
    {
        $instructors = User::query()
            ->whereIn('role', ['admin', 'super_admin', '2', '3'])
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role']);

        return view('courses.create', compact('instructors'));
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        Course::create($request->validated());

        return redirect()->route('courses.index')->with('success', 'Course berhasil dibuat.');
    }

    public function edit(Course $course): View
    {
        $instructors = User::query()
            ->whereIn('role', ['admin', 'super_admin', '2', '3'])
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role']);

        return view('courses.edit', compact('course', 'instructors'));
    }

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $course->update($request->validated());

        return redirect()->route('courses.show', $course)->with('success', 'Course berhasil diupdate.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course berhasil dihapus.');
    }
}
