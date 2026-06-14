<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div class="space-y-1">
                <p class="text-sm text-gray-500">Home / My Courses / {{ $course->title }} / {{ $quizLabel }}</p>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $quizLabel }}: {{ $course->title }}</h1>
            </div>
            <div class="flex items-center gap-3 text-sm text-gray-500">
                <a href="{{ route('courses.show', $course) }}" class="hover:text-indigo-600">&lt; Previous</a>
                <span>|</span>
                <a href="{{ route('courses.show', $course) }}" class="text-indigo-600 hover:underline">Back to Course
                    &gt;</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
                <aside class="xl:col-span-3">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
                        <h2 class="text-sm font-semibold text-slate-900 mb-4">Course Outline</h2>
                        @php
                            $sections = $course->sections->sortBy('order');
                            $materis = $course->materis->sortBy('order');
                            $chunkSize =
                                $sections->count() > 0
                                    ? (int) ceil($materis->count() / $sections->count())
                                    : $materis->count();
                        @endphp

                        @if ($sections->isNotEmpty())
                            @foreach ($sections as $section)
                                <div class="mb-3 rounded-2xl border border-slate-200 overflow-hidden">
                                    <button type="button"
                                        class="w-full flex items-center justify-between px-4 py-3 bg-slate-100 text-left text-sm font-semibold text-slate-900">
                                        <div>
                                            <div>{{ $section->title }}</div>
                                            <div class="text-xs text-slate-500">Module {{ $section->order }}</div>
                                        </div>
                                        <span class="text-slate-400">▾</span>
                                    </button>
                                    <div class="space-y-2 p-4">
                                        @foreach ($materis->slice($loop->index * $chunkSize, $chunkSize) as $m)
                                            <a href="{{ route('materis.show', $m) }}"
                                                class="flex items-center justify-between rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                                <span>{{ $m->order }}. {{ Str::limit($m->title, 24) }}</span>
                                                <span class="text-slate-400">›</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="mb-3 rounded-2xl border border-slate-200 overflow-hidden">
                                <button type="button"
                                    class="w-full flex items-center justify-between px-4 py-3 bg-slate-100 text-left text-sm font-semibold text-slate-900">
                                    <div>
                                        <div>Module 1</div>
                                        <div class="text-xs text-slate-500">{{ $course->title }}</div>
                                    </div>
                                    <span class="text-slate-400">▾</span>
                                </button>
                                <div class="space-y-2 p-4">
                                    @foreach ($materis as $m)
                                        <a href="{{ route('materis.show', $m) }}"
                                            class="flex items-center justify-between rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                            <span>{{ $m->order }}. {{ Str::limit($m->title, 24) }}</span>
                                            <span class="text-slate-400">›</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div
                            class="rounded-2xl border border-indigo-100 bg-indigo-50 px-4 py-4 text-sm text-indigo-700">
                            <div class="font-semibold">Quiz Preview</div>
                            <div class="mt-2 text-xs text-slate-600">Kerjakan quiz untuk menguji pemahaman materi.</div>
                        </div>
                    </div>
                </aside>

                <section class="xl:col-span-9">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
                            <div>
                                <span class="text-sm uppercase tracking-[0.2em] text-indigo-600">Rules</span>
                                <h2 class="mt-3 text-2xl font-semibold text-slate-900">{{ $quizLabel }} Rules</h2>
                            </div>
                            <a href="{{ route('courses.show', $course) }}"
                                class="inline-flex items-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                                Kembali ke Course
                            </a>
                        </div>

                        <div class="space-y-4 text-sm text-slate-600 leading-relaxed mb-8">
                            <p>Jawab setiap pertanyaan berikut dan tekan tombol kirim untuk melihat nilai Anda.</p>
                            <p>Semua pertanyaan terbuka untuk Pretest dan Pos Test. Hasil akan ditampilkan setelah
                                pengiriman.</p>
                            <ul class="list-disc list-inside space-y-2">
                                <li>Passing score requirement: 80%</li>
                                <li>Answer is recorded immediately after submit.</li>
                            </ul>
                        </div>

                        @if (isset($results))
                            <div
                                class="mb-8 rounded-2xl border {{ $results['passed'] ? 'border-emerald-300 bg-emerald-50' : 'border-rose-300 bg-rose-50' }} p-8">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-6">
                                    <div class="text-center sm:text-left">
                                        <p
                                            class="text-sm uppercase tracking-[0.2em] {{ $results['passed'] ? 'text-emerald-700' : 'text-rose-600' }} font-semibold">
                                            Hasil Quiz Anda</p>
                                        <p
                                            class="mt-4 text-6xl font-bold {{ $results['passed'] ? 'text-emerald-700' : 'text-rose-600' }}">
                                            {{ $results['percentage'] }}%
                                        </p>
                                        <p
                                            class="mt-2 text-lg font-semibold {{ $results['passed'] ? 'text-emerald-700' : 'text-rose-600' }}">
                                            {{ $results['passed'] ? '✓ Lulus' : '✗ Perlu Diulang' }}
                                        </p>
                                    </div>

                                    <a href="{{ route('courses.quiz.history', ['course' => $course, 'type' => $type]) }}"
                                        class="inline-flex items-center justify-center rounded-full border border-indigo-200 bg-white px-5 py-3 text-sm font-semibold text-indigo-700 shadow-sm hover:bg-indigo-50 transition">
                                        Lihat History Quiz
                                    </a>
                                </div>

                                <div class="grid gap-4 md:grid-cols-3">
                                    <div
                                        class="rounded-xl border {{ $results['passed'] ? 'border-emerald-200 bg-white' : 'border-rose-200 bg-white' }} p-4">
                                        <p
                                            class="text-xs uppercase tracking-[0.2em] {{ $results['passed'] ? 'text-emerald-600' : 'text-rose-600' }} font-semibold">
                                            Total Poin</p>
                                        <p
                                            class="mt-2 text-2xl font-bold {{ $results['passed'] ? 'text-emerald-700' : 'text-rose-700' }}">
                                            {{ $results['earned_points'] }}/{{ $results['total_points'] }}
                                        </p>
                                    </div>
                                    <div
                                        class="rounded-xl border {{ $results['passed'] ? 'border-emerald-200 bg-white' : 'border-rose-200 bg-white' }} p-4">
                                        <p
                                            class="text-xs uppercase tracking-[0.2em] {{ $results['passed'] ? 'text-emerald-600' : 'text-rose-600' }} font-semibold">
                                            Jawaban Benar</p>
                                        <p
                                            class="mt-2 text-2xl font-bold {{ $results['passed'] ? 'text-emerald-700' : 'text-rose-700' }}">
                                            {{ $results['correct'] }}/{{ $results['questions'] }}
                                        </p>
                                    </div>
                                    <div
                                        class="rounded-xl border {{ $results['passed'] ? 'border-emerald-200 bg-white' : 'border-rose-200 bg-white' }} p-4">
                                        <p
                                            class="text-xs uppercase tracking-[0.2em] {{ $results['passed'] ? 'text-emerald-600' : 'text-rose-600' }} font-semibold">
                                            Standar Kelulusan</p>
                                        <p class="mt-2 text-2xl font-bold text-slate-600">
                                            80%
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!isset($results))
                            @if ($questions->isEmpty())
                                <div
                                    class="rounded-2xl border border-slate-200 bg-slate-50 p-8 text-center text-slate-600">
                                    Belum ada quiz untuk course ini. Silakan tambahkan pertanyaan di halaman admin.
                                </div>
                            @else
                                <form method="POST"
                                    action="{{ route('courses.quiz.submit', ['course' => $course, 'type' => $type]) }}">
                                    @csrf

                                    <div class="space-y-6">
                                        @foreach ($questions as $index => $question)
                                            @php
                                                $selectedAnswer = old(
                                                    'answers.' . $question->id,
                                                    $submittedAnswers[$question->id] ?? null,
                                                );
                                            @endphp

                                            <div class="rounded-2xl border border-slate-200 p-6">
                                                <div
                                                    class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                                    <div>
                                                        <p class="text-sm uppercase tracking-[0.2em] text-slate-500">
                                                            Pertanyaan {{ $index + 1 }}</p>
                                                        <h3 class="mt-2 text-lg font-semibold text-slate-900">
                                                            {{ $question->question }}</h3>
                                                    </div>
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-slate-600">
                                                        {{ $question->points }} pts
                                                    </span>
                                                </div>

                                                <div class="mt-5 space-y-3">
                                                    @foreach ($question->options as $option)
                                                        @php
                                                            $isOptionSelected = (int) $selectedAnswer === $option->id;
                                                            $isOptionCorrect = $option->is_correct;
                                                            $optionClasses =
                                                                'flex items-center gap-3 rounded-2xl border px-4 py-3 text-sm transition';
                                                            if (isset($results)) {
                                                                if ($isOptionCorrect) {
                                                                    $optionClasses .=
                                                                        ' border-emerald-300 bg-emerald-50 text-emerald-900';
                                                                } elseif ($isOptionSelected) {
                                                                    $optionClasses .=
                                                                        ' border-rose-300 bg-rose-50 text-rose-900';
                                                                } else {
                                                                    $optionClasses .=
                                                                        ' border-slate-200 bg-white text-slate-700';
                                                                }
                                                            } else {
                                                                $optionClasses .=
                                                                    ' border-slate-200 bg-white text-slate-700 hover:border-slate-300';
                                                            }
                                                        @endphp

                                                        <label class="{{ $optionClasses }}">
                                                            <input type="radio" name="answers[{{ $question->id }}]"
                                                                value="{{ $option->id }}"
                                                                class="h-4 w-4 text-indigo-600"
                                                                {{ isset($results) ? 'disabled' : '' }}
                                                                {{ $isOptionSelected ? 'checked' : '' }} />
                                                            <span>{{ $option->option_text }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>

                                                @if (isset($results) && $question->options->contains('is_correct', true))
                                                    <div
                                                        class="mt-4 rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-700">
                                                        Jawaban benar: <span
                                                            class="font-semibold">{{ $question->options->firstWhere('is_correct', true)->option_text }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <div
                                        class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <p class="text-sm text-slate-500">Pastikan semua jawaban sudah dipilih sebelum
                                            mengirim.</p>
                                        <button type="submit"
                                            class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                                            Kirim {{ $quizLabel }}
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @else
                            <div class="mt-8">
                                <a href="{{ route('courses.show', $course) }}"
                                    class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                                    Kembali ke Course
                                </a>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
