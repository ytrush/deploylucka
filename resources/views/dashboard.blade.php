<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
                <div>
                    <h1 class="text-[20px] font-medium text-gray-900">Selamat datang kembali 👋</h1>
                    <p class="text-sm text-gray-600 mt-1">Pantau progres belajar Anda hari ini.</p>
                </div>
            </div>

            @php
                $completion = (int) ($completionRate ?? 0);
                $completionClamped = min($completion, 100);
                $completedMateris = (int) ($completedMateris ?? 0);
                $totalMateris = (int) ($totalMateris ?? 0);
                $completedCourses = (int) ($completedCourses ?? 0);
                $inProgressCourses = (int) ($inProgressCourses ?? 0);
                $totalCourses = (int) ($totalCourses ?? 0);
                $avgQuiz = (int) ($avgQuizScore ?? 0);

                $courseDonePct = $totalCourses > 0 ? (int) round(($completedCourses / $totalCourses) * 100) : 0;
                $courseProgPct = $totalCourses > 0 ? (int) round(($inProgressCourses / $totalCourses) * 100) : 0;
            @endphp

            <div>
                <p class="text-xs font-medium text-gray-500 tracking-widest uppercase">Ringkasan</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-3">
                    <div class="bg-white border border-slate-200 rounded-xl p-5">
                        <div
                            class="w-9 h-9 rounded-lg flex items-center justify-center mb-3 bg-[#EEEDFE] text-[#534AB7]">
                            <i class="ti ti-progress" aria-hidden="true"></i>
                        </div>
                        <div class="text-xs text-gray-500 mb-1">Completion rate</div>
                        <div class="text-2xl font-medium text-gray-900">{{ $completion }}%</div>
                        <div class="h-1.5 bg-slate-200 rounded-full overflow-hidden mt-3">
                            <div class="h-full bg-[#7F77DD]" style="width:{{ $completionClamped }}%"></div>
                        </div>
                        <div class="text-xs text-gray-400 mt-2">{{ $completedMateris }} dari {{ $totalMateris }} materi
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-xl p-5">
                        <div
                            class="w-9 h-9 rounded-lg flex items-center justify-center mb-3 bg-[#E1F5EE] text-[#0F6E56]">
                            <i class="ti ti-award" aria-hidden="true"></i>
                        </div>
                        <div class="text-xs text-gray-500 mb-1">Nilai rata-rata quiz</div>
                        <div class="text-2xl font-medium text-gray-900">{{ $avgQuiz }}%</div>
                        <div class="h-1.5 bg-slate-200 rounded-full overflow-hidden mt-3">
                            <div class="h-full bg-[#1D9E75]" style="width:100%"></div>
                        </div>
                        <div class="text-xs text-gray-400 mt-2">Sempurna!</div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-xl p-5">
                        <div
                            class="w-9 h-9 rounded-lg flex items-center justify-center mb-3 bg-[#E6F1FB] text-[#185FA5]">
                            <i class="ti ti-book" aria-hidden="true"></i>
                        </div>
                        <div class="text-xs text-gray-500 mb-1">Course selesai</div>
                        <div class="text-2xl font-medium text-gray-900">
                            {{ $completedCourses }} <span class="text-sm font-normal text-gray-400">/
                                {{ $totalCourses }}</span>
                        </div>
                        <div class="h-1.5 bg-slate-200 rounded-full overflow-hidden mt-3">
                            <div class="h-full bg-[#1D9E75]" style="width:{{ $courseDonePct }}%"></div>
                        </div>
                        <div class="text-xs text-gray-400 mt-2">{{ max($totalCourses - $completedCourses, 0) }} course
                            tersisa</div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-xl p-5">
                        <div
                            class="w-9 h-9 rounded-lg flex items-center justify-center mb-3 bg-[#FAEEDA] text-[#854F0B]">
                            <i class="ti ti-loader" aria-hidden="true"></i>
                        </div>
                        <div class="text-xs text-gray-500 mb-1">Sedang berjalan</div>
                        <div class="text-2xl font-medium text-gray-900">
                            {{ $inProgressCourses }} <span class="text-sm font-normal text-gray-400">/
                                {{ $totalCourses }}</span>
                        </div>
                        <div class="h-1.5 bg-slate-200 rounded-full overflow-hidden mt-3">
                            <div class="h-full bg-[#EF9F27]" style="width:{{ $courseProgPct }}%"></div>
                        </div>
                        <div class="text-xs text-gray-400 mt-2">Lanjutkan belajar</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white border border-slate-200 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs font-medium text-gray-500">Course terdaftar</div>
                        <i class="ti ti-books text-gray-400" style="font-size:16px" aria-hidden="true"></i>
                    </div>
                    <div class="text-2xl font-medium text-gray-900">{{ (int) ($enrolledCoursesCount ?? 0) }}</div>
                    <div class="text-xs text-gray-400 mt-1">Course yang Anda daftarkan</div>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs font-medium text-gray-500">Total percobaan quiz</div>
                        <i class="ti ti-pencil text-gray-400" style="font-size:16px" aria-hidden="true"></i>
                    </div>
                    <div class="text-2xl font-medium text-gray-900">{{ (int) ($totalQuizAttempts ?? 0) }}</div>
                    <div class="text-xs text-gray-400 mt-1">Percobaan yang dilakukan</div>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs font-medium text-gray-500">Sertifikat siap</div>
                        <i class="ti ti-certificate text-gray-400" style="font-size:16px" aria-hidden="true"></i>
                    </div>
                    <div class="text-2xl font-medium text-gray-900">{{ (int) ($certificateReadyCount ?? 0) }}</div>
                    <div class="text-xs text-gray-400 mt-1">Siap untuk diunduh</div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs font-medium text-gray-500 tracking-widest uppercase">Aktivitas course</p>
                            <span class="text-xs text-indigo-700 cursor-pointer">Lihat semua</span>
                        </div>

                        <div class="divide-y divide-slate-200">
                            @forelse ($coursesProgress as $item)
                                @php
                                    $progress = (int) ($item->progress ?? 0);
                                    $completed = (int) ($item->completed ?? 0);
                                    $total = (int) ($item->total ?? 0);

                                    $iconBg = '#EEEDFE';
                                    $iconFg = '#534AB7';
                                    if ($progress >= 100) {
                                        $iconBg = '#E1F5EE';
                                        $iconFg = '#0F6E56';
                                    } elseif ($progress < 40) {
                                        $iconBg = '#FAEEDA';
                                        $iconFg = '#854F0B';
                                    } else {
                                        $iconBg = '#E6F1FB';
                                        $iconFg = '#185FA5';
                                    }
                                @endphp

                                <div class="py-3 flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-md flex items-center justify-center"
                                        style="background:{{ $iconBg }}; color:{{ $iconFg }}">
                                        <i class="ti ti-code" aria-hidden="true"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm text-gray-900 truncate">{{ $item->course->title }}</div>
                                        <div class="text-xs text-gray-400">{{ $completed }} / {{ $total }}
                                            completed</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-900">{{ $progress }}%</div>
                                        <div class="text-xs text-gray-400">
                                            {{ $progress >= 100 ? 'Selesai' : 'In progress' }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-3 text-sm text-gray-500">No course progress available yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-[#F8FAFC] rounded-lg p-4 text-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3"
                                style="background:#EEEDFE;color:#534AB7">
                                <i class="ti ti-rosette" aria-hidden="true"></i>
                            </div>
                            <div class="text-base font-medium text-gray-900 mb-1">
                                {{ $achievementLabel ?? 'New Learner' }}</div>
                            <div class="text-xs text-gray-500">Pencapaian Anda berdasarkan progres</div>
                        </div>

                        <div class="bg-[#F8FAFC] rounded-lg p-4">
                            <div class="text-xs text-gray-500 mb-3">Recent Activity</div>

                            <div class="space-y-3">
                                @forelse ($recentCompletions as $c)
                                    <div>
                                        <div class="text-sm text-gray-900">Selesai: {{ $c->materi->title }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            {{ $c->completed_at->format('d M Y H:i') }}</div>
                                    </div>
                                @empty
                                    <div class="text-sm text-gray-500">No recent completions.</div>
                                @endforelse

                                @foreach ($recentQuizzes as $q)
                                    <div class="pt-1">
                                        <div class="text-sm text-gray-900">Quiz: {{ $q->materi?->title ?? '—' }}</div>
                                        <div class="flex items-center justify-between mt-0.5">
                                            <div class="text-xs text-gray-500">
                                                {{ $q->created_at->format('d M Y H:i') }}</div>
                                            <div class="text-sm font-medium text-gray-900">{{ $q->percentage }}%</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 tracking-widest uppercase">Rekomendasi course</p>
                    <p class="text-xs text-gray-400 mt-1">Pilihan sesuai minat Anda</p>
                </div>
                <span class="text-xs text-indigo-700 cursor-pointer">Lihat semua</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse ($recommendedCourses ?? collect() as $recommendedCourse)
                    <div class="bg-white border border-slate-200 rounded-xl p-5">
                        <div class="text-xs font-medium tracking-wide" style="color:#185FA5">
                            {{ $recommendedCourse->category?->name ?? 'COURSE' }}</div>
                        <div class="text-sm font-medium text-gray-900 mt-1">{{ $recommendedCourse->title }}</div>
                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <i class="ti ti-clock" style="font-size:13px" aria-hidden="true"></i>
                                <span>—</span>
                            </div>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium"
                                style="background:#EEEDFE;color:#534AB7">
                                {{ $recommendedCourse->level ?? 'Pemula' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 rounded-xl p-5 md:col-span-3">
                        <div class="text-sm text-gray-500">Belum ada rekomendasi course.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
