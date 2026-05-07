<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMateriRequest;
use App\Http\Requests\UpdateMateriRequest;
use App\Models\Course;
use App\Models\Materi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    public function show(Materi $materi): View
    {
        $materi->load([
            'course:id,title',
            'questions',
        ]);

        return view('materis.show', compact('materi'));
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
