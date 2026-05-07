<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCategoryId = $request->integer('category_id');

        $courses = Course::query()
            ->with(['instructor:id,name,photo_path', 'category:id,name'])
            ->when($selectedCategoryId > 0, function ($query) use ($selectedCategoryId) {
                $query->where('category_id', $selectedCategoryId);
            })
            ->orderByDesc('id')
            ->paginate((int) $request->integer('per_page', 15));

        $courses->appends($request->query());

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('courses.index', compact('courses', 'categories', 'selectedCategoryId'));
    }

    public function show(Course $course): View
    {
        $course->load([
            'instructor:id,name,photo_path',
            'category:id,name',
            'materis',
        ]);

        return view('courses.show', compact('course'));
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
        Course::create($request->validated());

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
        $course->update($request->validated());

        return redirect()->route('courses.show', $course)->with('success', 'Course berhasil diupdate.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course berhasil dihapus.');
    }
}
