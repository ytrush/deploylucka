<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Roadmap Pembelajaran</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Jalur Belajar Anda</h3>
                <p class="mt-2 text-sm text-gray-500">Lihat progress learning path yang dibuat admin, lalu pilih course berikutnya sesuai roadmap.</p>
            </div>

            @if ($pathSummaries->isNotEmpty())
                <div class="grid gap-6">
                    @foreach ($pathSummaries as $summary)
                        <div class="rounded-lg bg-white p-6 shadow-sm">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-indigo-600">Learning Path</p>
                                    <h4 class="mt-2 text-xl font-semibold text-slate-900">{{ $summary->path->name }}</h4>
                                    <p class="mt-1 text-sm text-slate-500">{{ $summary->path->description }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-slate-900">{{ $summary->progress }}%</p>
                                    <p class="text-sm text-slate-500">Rata-rata progress path</p>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="h-2 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-600" style="width: {{ $summary->progress }}%"></div>
                                </div>
                            </div>

                            <div class="mt-6 space-y-4">
                                @foreach ($summary->courses as $item)
                                    <div class="rounded-xl border border-slate-200 p-4">
                                        <div class="flex items-center justify-between gap-4">
                                            <div>
                                                <p class="text-sm uppercase tracking-wide text-indigo-600">{{ $item->course->category?->name ?? 'Course' }}</p>
                                                <h5 class="mt-1 text-lg font-semibold text-slate-900">{{ $item->course->title }}</h5>
                                                <p class="mt-1 text-sm text-slate-500">Instruktur: {{ $item->course->instructor?->name ?? 'Tutor' }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xl font-semibold text-slate-900">{{ $item->progress }}%</p>
                                                <span class="text-xs text-slate-500">{{ $item->remaining }} materi tersisa</span>
                                            </div>
                                        </div>
                                        <div class="mt-3 h-2 bg-slate-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-indigo-600" style="width: {{ $item->progress }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <h4 class="text-base font-semibold text-slate-900">Progres Course Terdaftar</h4>
                        <div class="mt-4 space-y-4">
                            @forelse ($courseRoadmap as $item)
                                <div class="rounded-xl border border-slate-200 p-4">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <div class="text-xs uppercase tracking-wide text-indigo-600">{{ $item->course->category?->name ?? 'Course' }}</div>
                                            <h5 class="mt-2 text-lg font-semibold text-slate-900">{{ $item->course->title }}</h5>
                                            <p class="mt-2 text-sm text-slate-600">Instruktur: {{ $item->course->instructor?->name ?? 'Tutor' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-slate-900">{{ $item->progress }}%</p>
                                            <span class="text-xs text-slate-500">{{ $item->remaining }} materi tersisa</span>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div class="h-2 bg-slate-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-indigo-600" style="width: {{ $item->progress }}%"></div>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex flex-wrap gap-2 text-sm text-slate-500">
                                        <span>{{ $item->completed }} / {{ $item->total }} materi selesai</span>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-xl border border-dashed border-slate-300 p-6 text-center text-slate-500">
                                    Belum ada course yang terdaftar. Kunjungi halaman Courses untuk mulai memilih course.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <h4 class="text-base font-semibold text-slate-900">Rekomendasi Course Selanjutnya</h4>
                        <p class="mt-2 text-sm text-gray-500">Course berikut dipilih berdasarkan kategori dan minat yang Anda ikuti.</p>
                        <div class="mt-4 space-y-4">
                            @forelse ($recommendedCourses as $course)
                                <div class="rounded-xl border border-slate-200 p-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <div class="text-xs uppercase tracking-wide text-indigo-600">{{ $course->category?->name ?? 'Course' }}</div>
                                            <h5 class="mt-1 text-lg font-semibold text-slate-900">{{ $course->title }}</h5>
                                            <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ \Illuminate\Support\Str::limit($course->description, 120) }}</p>
                                        </div>
                                        <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Lihat</a>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-xl border border-dashed border-slate-300 p-6 text-center text-slate-500">
                                    Tidak ada rekomendasi saat ini. Coba jelajahi katalog course.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h4 class="text-base font-semibold text-slate-900">Langkah berikutnya dalam roadmap</h4>
                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-500">Total Course Terdaftar</p>
                        <p class="mt-3 text-3xl font-bold text-slate-900">{{ $courseRoadmap->count() }}</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-500">Course Hampir Selesai</p>
                        <p class="mt-3 text-3xl font-bold text-slate-900">{{ $courseRoadmap->where('progress', '>=', 70)->count() }}</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-500">Course Baru Direkomendasikan</p>
                        <p class="mt-3 text-3xl font-bold text-slate-900">{{ $recommendedCourses->count() }}</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-500">Lanjutkan Belajar</p>
                        <p class="mt-3 text-3xl font-bold text-slate-900">{{ $courseRoadmap->where('progress', '>', 0)->where('progress', '<', 100)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
